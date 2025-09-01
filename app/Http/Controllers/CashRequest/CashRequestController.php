<?php

namespace App\Http\Controllers\CashRequest;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\CashRequest;
use App\Models\CashCategory;
use Illuminate\Http\Request;
use App\Models\cashRequestItem;
use App\Models\CashRequestApproval;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CashRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cash_categories = CashCategory::all();
        $requests = collect();

        if ($user->is_manager) {
            $team = Team::where('id', $user->team_id)->first();

            if ($team) {
                $employees = User::where('team_id', $team->id)->pluck('id');
                $requests = CashRequest::whereIn('user_id', $employees)
                    ->orderBy('created_at', 'desc')->get();
            } else {
                $employees = User::where('department_id', $user->department_id)->pluck('id');
                $requests = CashRequest::whereIn('user_id', $employees)
                    ->orderBy('created_at', 'desc')->get();
            }
        } else {
            $requests = CashRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')->get();
        }

        return view('backend.cash_requests.index', compact('requests', 'cash_categories'));
    }

    public function store(Request $request)
    {
        // التحقق من صحة المدخلات
        $validated = $request->validate([
            'request_name' => 'required|string',
            'reason' => 'required|string',
            'request_date' => 'required|date',
            'cash_category_id' => 'required',
            'due_date' => 'required|date|after_or_equal:request_date', // تحقق من أن due_date ليس قبل request_date
            'amount' => 'required|numeric',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png',
            'items.*' => 'required|string',
            'prices.*' => 'required|numeric',
        ]);
        // dd($validated);

        // معالجة الملف إذا تم تحميله
        $attachment = null;
        if ($request->hasFile('attachment')) {
            // الحصول على اسم الملف الأصلي
            $originalFilename = $request->file('attachment')->getClientOriginalName();

            // الحصول على اسم الطلب وتنسيق التاريخ الحالي
            $requestName = $request->request_name;
            $currentDate = Carbon::now()->format('Y-m-d');

            // الحصول على اسم الشخص (المستخدم الحالي)
            $userName = auth()->user()->name; // أو auth()->user()->username إذا كنت تستخدم username

            // إنشاء اسم جديد للملف يشمل اسم الطلب، اسم الشخص، والتاريخ
            $newFilename = $userName . '_' . $requestName . '_' . $currentDate . '_' . $originalFilename;
            
            $attachment = $request->file('attachment')->move(public_path("attachments"), $newFilename);

        }
        $status = 'pending';
        $approvedByManager = null;
        $approvedByAccounts = null;
        $approvedByGm = null;

        if (auth()->user()->is_manager) {
            if (auth()->user()->role === 'gm') {
                // إذا كان المدير العام، يتم تعيين الموافقة تلقائيًا للمدير العام
                $status = 'approved_by_gm';
                $approvedByGm = auth()->id();
            } elseif (auth()->user()->role === 'accounts') {
                // إذا كان مدير الحسابات، يتم تعيين الموافقة للحسابات
                $status = 'approved_by_accounts';
                $approvedByAccounts = auth()->id();
            } else {
                // إذا كان مديرًا ولكن ليس في الحسابات أو المدير العام، يتم تعيين الموافقة للمدير فقط
                $status = 'approved_by_manager';
                $approvedByManager = auth()->id();
            }
        }
        // إنشاء طلب المصروف
        $cashRequest = CashRequest::create([
            'request_name' => $request->request_name,
            'reason' => $request->reason,
            'request_date' => $request->request_date,
            'due_date' => $request->due_date,
            'cash_category_id' => $request->cash_category_id,
            'amount' => $request->amount,
            'user_id' => auth()->id(),
            'status' => $status,
            'approved_by_manager' => $approvedByManager,
            'approved_by_accounts' => $approvedByAccounts,
            'approved_by_gm' => $approvedByGm,
            'attachment' => $attachment,
        ]);

        // إضافة العناصر والأسعار
        foreach ($request->item_name as $index => $item) {
            if (!empty($item) && isset($request->price[$index])) {
                cashRequestItem::create([
                    'cash_request_id' => $cashRequest->id,
                    'item_name' => $item,
                    'price' => $request->price[$index], // تأكد أن الحقل price[] في الطلب
                ]);
            }
        }
    
        return redirect()->route('cash_requests.index')->with('success', 'Cash request created successfully');
    }

    protected function sendEmailNotification($recipients, $cashRequest)
    {
        Mail::send('emails.cash_request_notification', ['cashRequest' => $cashRequest], function ($message) use ($recipients) {
            $message->to($recipients)->subject('تم إنشاء طلب نقدي جديد');
        });
    }

    public function update(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);

        $cashRequest->update([
            'request_name' => $request->input('request_name'),
            'amount' => $request->input('amount'),
            'due_date' => $request->input('due_date'),
            'reason' => $request->input('reason'),
        ]);

        CashRequestItem::where('cash_request_id', $cashRequest->id)->delete();

        $itemNames = $request->input('item_name');
        $prices = $request->input('price');

        if (is_array($itemNames)) {
            foreach ($itemNames as $index => $itemName) {
                CashRequestItem::create([
                    'cash_request_id' => $cashRequest->id,
                    'item_name' => $itemName,
                    'price' => $prices[$index] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function managerApproval(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);
        $action = $request->input('action');

        if (!$action) {
            return redirect()->back()->withErrors(['status' => 'حالة الطلب غير محددة.']);
        }

        $status = $action === 'approve' ? 'approved_by_manager' : 'rejected';

        $cashRequest->update([
            'status' => $status,
            'approved_by_manager' => $action === 'approve' ? auth()->id() : $cashRequest->approved_by_manager,
        ]);

        if ($status === 'approved_by_manager') {
            $gm = User::where('role', 'gm')->first(); // افتراض أن هناك مستخدم واحد فقط بدور GM

            if ($gm) {
                $data = [
                    'cashRequest' => $cashRequest,
                    'managerName' => auth()->user()->name,
                    'gmName' => $gm->name,
                ];

                Mail::send('emails.cash_request_gm_notification', $data, function ($message) use ($gm) {
                    $message->to($gm->email)
                        ->subject('Approval Notification: Manager Approved Cash Request');
                });
            }
        }

        return redirect()->route('cash_requests.index')->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    public function approvedByDepartmentHead()
    {
        $requests = CashRequest::whereIn('status', ['approved_by_manager', 'approved_by_gm'])->get();

        return view('backend.cash_requests.gm', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);
        $action = $request->input('action');

        if (!$action) {
            return redirect()->back()->withErrors(['status' => 'حالة الطلب غير محددة.']);
        }

        if ($action === 'approve') {
            if ($cashRequest->status === 'pending') {
                $cashRequest->status = 'approved_by_manager';
                $cashRequest->approved_by_manager = auth()->id(); // تسجيل المستخدم الذي قام بالموافقة
            } elseif ($cashRequest->status === 'approved_by_manager') {
                $cashRequest->status = 'approved_by_gm';
                $cashRequest->approved_by_gm = auth()->id(); // تسجيل المستخدم الذي قام بالموافقة
            }
        } elseif ($action === 'reject') {
            $cashRequest->status = 'rejected';
        } else {
            return redirect()->back()->withErrors(['status' => 'فشل في تحديث الحالة.']);
        }

        $cashRequest->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    public function approvedByAccountsHead()
    {
        $requests = CashRequest::whereIn('status', ['approved_by_accounts', 'approved_by_manager'])->orderBy('created_at', 'desc')->get();

        return view('backend.cash_requests.accounts', compact('requests'));
    }

    public function accountsApproval(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);
        $action = $request->input('action');

        if (!$action) {
            return redirect()->back()->withErrors(['status' => 'حالة الطلب غير محددة.']);
        }

        $status = $action === 'approve' ? 'approved_by_accounts' : 'rejected';

        $cashRequest->update([
            'status' => $status,
            'approved_by_accounts' => $action === 'approve' ? auth()->id() : $cashRequest->approved_by_accounts,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    public function report(Request $request)
    {
        $query = CashRequest::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('request_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('cash_category_id')) {
            $query->where('cash_category_id', $request->cash_category_id);
        }

        $requests = $query->with('cashCategory')->get();

        $total_amount = $requests->sum('amount');

        return view('backend.cash_requests.report', [
            'requests' => $requests,
            'total_amount' => $total_amount,
            'cash_categories' => CashCategory::all(),
        ]);
    }

    public function export(Request $request)
    {
        $query = CashRequest::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('request_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('cash_category_id')) {
            $query->where('cash_category_id', $request->cash_category_id);
        }

        $requests = $query->with('cashCategory')->get();

        return response()->download($filePath);
    }


}
