<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'gm' || $user->role === 'hr') {
            $usersWithAccounts = User::has('accounts')->with('accounts')->get();
        } else {
            $usersWithAccounts = User::where('id', $user->id)
                                      ->has('accounts') 
                                      ->with('accounts')
                                      ->get();
        }
        
        return view('backend.pass-key.index', compact('usersWithAccounts'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'accounts.*.website_name' => 'required|string',
            'accounts.*.account_email' => 'required|email',
            'accounts.*.account_password' => 'required|string',
        ]);
    
        foreach ($request->accounts as $accountData) {
            $account = new UserAccount();
            $account->user_id = auth()->id();
            $account->website_name = $accountData['website_name'];
            $account->account_email = $accountData['account_email'];
            $account->account_password = $accountData['account_password'];
            $account->save();
        }
    
        return redirect()->route('pass-key.index')->with('success', 'Accounts added successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // التحقق من صلاحيات المستخدم إذا كانت مطلوبة
        
        // الحصول على بيانات الحسابات المعدلة
        $accounts = $request->input('accounts', []);
    
        foreach ($accounts as $accountId => $accountData) {
            if (strpos($accountId, 'new_') !== false) {
                // إذا كان الحساب جديدًا (ليس لديه معرف)، قم بإضافته
                UserAccount::create([
                    'user_id' => $id, // تأكد من أن معرف المستخدم صحيح
                    'website_name' => $accountData['website_name'],
                    'account_email' => $accountData['account_email'],
                    'account_password' => $accountData['account_password'],
                ]);
            } else {
                // تحديث الحسابات الموجودة
                $account = UserAccount::find($accountId);
                
                if ($account) {
                    $account->update([
                        'website_name' => $accountData['website_name'],
                        'account_email' => $accountData['account_email'],
                        'account_password' => $accountData['account_password'],
                    ]);
                }
            }
        }
    
        return redirect()->route('pass-key.index')->with('success', 'Accounts updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
