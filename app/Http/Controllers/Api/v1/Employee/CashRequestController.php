<?php

namespace App\Http\Controllers\Api\v1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Employee\StoreCashRequest;
use App\Http\Resources\Api\v1\Employee\CashRequestResource;
use App\Http\Resources\Api\v1\Employee\DepartmentResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Http\Resources\Api\v1\SuccessResource;
use App\Models\CashRequest;
use App\Models\cashRequestItem;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashRequestController extends Controller
{
    public function cashRequest(StoreCashRequest $request)
    {
        try{
            DB::beginTransaction();

            if($request->has('attachment')) {
                $attachment = $request->file('attachment');
                $attachment_name = time() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(public_path('upload/cash_request'), $attachment_name);
            }

            $cash_request = CashRequest::create([
                'request_name'     => $request->request_name,
                'reason'           => $request->reason,
                'request_date'     => now(),
                'due_date'         => $request->due_date,
                'amount'           => $request->amount,
                'user_id'          => auth()->id(),
                'cash_category_id' => $request->cash_category_id,
                'attachment'       => $attachment_name ?? null,
            ]);

            //create item for cash request
            foreach ($request->item_name as $key => $itemName) {
                cashRequestItem::create([
                    'cash_request_id' => $cash_request->id,
                    'item_name'       => $itemName,
                    'price'           => $request->price[$key],
                ]);
            }


            DB::commit();
            return SuccessResource::make([
                'message' => 'Cash request created successfully.',
            ])->withWrappData();
        }catch(\Exception $e){
            DB::rollBack();
            Log::channel('error')->error('error in AccountantCashRequestController@cashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource('Failed to create cash request.');
        }
    }

    public function departments()
    {
        try{
            $departments = Department::paginate(config('app.paginate'));
            return count($departments) > 0
                ? DepartmentResource::collection($departments)
                : new ErrorResource(__('cash_request.no_departments'));
        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@departments: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function showDepartment(Request $request, $id)
    {
        try{
            $department = Department::where('id', $id)->first();
            if(!$department) {
                return new ErrorResource(__('cash_request.no_department'));
            }
            return DepartmentResource::make($department);
        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showDepartment: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function cashRequests(Request $request , $department_id)
    {
        try{
            $users = Department::where('id', $department_id)->first()->users;
            $user_ids = $users->pluck('id')->toArray();

            $cash_requests = CashRequest::whereIn('user_id', $user_ids)->where('status', 'pending')->orderBy('id', 'desc')->get();

            if(!$cash_requests) {
                return new ErrorResource(__('cash_request.no_requests'));
            }

            return count($cash_requests) > 0
                ? CashRequestResource::collection($cash_requests)
                : new ErrorResource(__('cash_request.no_requests'));

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@cashRequests: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function showCashRequest(Request $request , $department_id, $cash_request_id)
    {
        try{
            $department = Department::where('id', $department_id)->first();
            if(!$department) {
                return new ErrorResource(__('cash_request.no_department'));
            }
            $cash_request = CashRequest::where('id', $cash_request_id)->first();

            if(!$cash_request) {
                return new ErrorResource(__('cash_request.no_request'));
            }

            return CashRequestResource::make($cash_request);

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showCashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function myCashRequests(Request $request)
    {
        try{
            $cash_requests = CashRequest::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

            if(!$cash_requests) {
                return new ErrorResource('No cash requests found.');
            }

            return count($cash_requests) > 0
                ? CashRequestResource::collection($cash_requests)
                : new ErrorResource(__('cash_request.no_requests'));

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@myCashRequests: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function showMyCashRequest(Request $request , $cash_request_id)
    {
        try{
            $cash_request = CashRequest::where('id', $cash_request_id)->first();

            if(!$cash_request) {
                return new ErrorResource(__('cash_request.no_request'));
            }

            return CashRequestResource::make($cash_request);

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showMyCashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function approvedByManager(Request $request , $cash_request_id)
    {
        try{
           $cash_request = CashRequest::where('id', $cash_request_id)->where('status', 'pending')->first();
            if(!$cash_request) {
                return new ErrorResource(__('cash_request.no_request'));
            }

            $cash_request->update([
                'status' => $request->status,
            ]);

            DB::commit();
            return SuccessResource::make([
                'message' => __('cash_request.approved'),
            ])->withWrappData();

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@approvedByManager: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function rejectedByManager(Request $request , $cash_request_id)
    {
        try{

            $cash_request = CashRequest::where('id', $cash_request_id)->first();

            if (!$cash_request) {
                // Handle case where the CashRequest is not found
                return response()->json(['error' => 'Cash request not found.'], 404);
            }

            if ($cash_request->status !== 'pending') {
                // Handle case where the CashRequest status is not 'pending'
                return response()->json([
                    'error' => 'Cash request status must be pending to proceed.',
                    'current_status' => $cash_request->status,
                ], 400);
            }


            $cash_request->update([
                'reason' => $request->reason,
                'status' => $request->status,
            ]);

            DB::commit();
            return SuccessResource::make([
                'message' => 'Cash request rejected successfully.',
            ])->withWrappData();

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@rejectedByManager: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function managerCashRequest(StoreCashRequest $request)
    {
        try{
            DB::beginTransaction();

            if($request->has('attachment')) {
                $attachment = $request->file('attachment');
                $attachment_name = time() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(public_path('upload/cash_request'), $attachment_name);
            }

            $cash_request = CashRequest::create([
                'request_name'     => $request->request_name,
                'reason'           => $request->reason,
                'request_date'     => now(),
                'due_date'         => $request->due_date,
                'amount'           => $request->amount,
                'user_id'          => auth()->id(),
                'cash_category_id' => $request->cash_category_id,
                'attachment'       => $attachment_name ?? null,
                'status'           => 'approved_by_manager',
            ]);
            DB::commit();
            return SuccessResource::make([
                'message' => __('cash_request.created'),
            ])->withWrappData();
        }catch(\Exception $e){
            DB::rollBack();
            Log::channel('error')->error('error in AccountantCashRequestController@cashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }
}
