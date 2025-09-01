<?php

namespace App\Http\Controllers\Api\v1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\EmployeeAuth\EditProfile;
use App\Http\Requests\Api\v1\EmployeeAuth\Login;
use App\Http\Resources\Api\v1\Employee\UserResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Http\Resources\Api\v1\SuccessResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Log};
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Login $request)
    {
        try {
            DB::beginTransaction();
            $user = User::whereEmail($request->email)->first();
            if (!$user) {
                return (new ErrorResource(__('auth.login_failed')));
            }
            if (!Hash::check($request->password, $user->password)) {
                return (new ErrorResource(__('auth.login_failed')));
            }

            if ($user->where(['email' => $request->email, 'password' => Hash::make($request->password)])) {
                $user->update([
                    'api_token' => Str::random(60),
                ]);
                DB::commit();
                return SuccessResource::make([
                    'message'   => __('auth.login_success'),
                    'token'     => $user->api_token,
                ])->withWrappData();
            } else {
                return (new ErrorResource(__('auth.login_failed')));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            Log::channel('website')->error('error in AuthClientController@login: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return (new ErrorResource(__('auth.login_failed')));
        }
    }

    public function updateProfile(EditProfile $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', Auth::guard('api')->user()->id)->first();
            if (!$user) {
                return new ErrorResource('Login failed');
            }

            if($request->has('photo')) {
                $photo = $request->file('photo');
                $photo_name = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('upload/admin_image'), $photo_name);
                $user->update([
                    'photo' => $photo_name,
                ]);
            }

            $user->update([
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'job_title'     => $request->job_title,
            ]);

            DB::commit();
            return SuccessResource::make([
                'message' => 'Profile updated successfully',
            ])->withWrappData();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('website')->error('error in AuthClientController@editProfile: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('auth.login_failed'));
        }
    }

    public function profile()
    {
        try {
            DB::beginTransaction();

            $user = User::where('id', Auth::guard('api')->user()->id)->first();
//            $user_second = DB::connection('mysql_second')->table('users')->first();
//            dd($user_second);

            if (!$user) {
                return new ErrorResource(__('auth.login_failed'));
            }

            DB::commit();
            return UserResource::make($user);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('website')->error('error in AuthClientController@profile: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('auth.login_failed'));
        }
    }

    public function logout()
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', Auth::guard('api')->user()->id)->first();
            $user->update([
                'api_token' => null,
            ]);
            DB::commit();
            return SuccessResource::make([
                'message' => __('auth.logout_success'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('website')->error('error in AuthClientController@logout: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
           return new ErrorResource(__('auth.login_failed'));
        }
    }

}
