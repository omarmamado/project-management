<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Employee\CashCategoryResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Models\CashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CashCategoryController extends Controller
{
    public function cashCategories()
    {
        try{
            $cash_categories = CashCategory::paginate(config('app.paginate'));
            return count($cash_categories) > 0
                ? CashCategoryResource::collection($cash_categories)
                : new ErrorResource(__('cash_request.no_departments'));
        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@departments: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function showCashCategory(Request $request, $id)
    {
        try{
            $cash_category = CashCategory::where('id', $id)->first();
            if(!$cash_category) {
                return new ErrorResource(__('cash_request.no_department'));
            }
            return CashCategoryResource::make($cash_category);
        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showDepartment: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }
}
