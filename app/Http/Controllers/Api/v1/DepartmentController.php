<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Employee\DepartmentResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
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
}
