<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Employee\CashRequestResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Http\Resources\Api\v1\SuccessResource;
use App\Models\CashRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminCashRequestController extends Controller
{
    public function cashRequests(Request $request)
    {
        try{

            $cash_requests = CashRequest::where('status', 'approved_by_accounts')->orderBy('id', 'desc')
                ->paginate(config('app.paginate'));


            return count($cash_requests) > 0
                ? CashRequestResource::collection($cash_requests)
                : new ErrorResource(__('cash_request.no_requests'));

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@cashRequests: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function showCashRequest(Request $request , $cash_request_id)
    {
        try{
            $cash_request = CashRequest::where('id', $cash_request_id)->first();

            if($cash_request->status !== 'approved_by_accounts') {
                return new ErrorResource("Cash request status must be approved by accounts to proceed.");
            }

            if(!$cash_request) {
                return new ErrorResource("Cash request not found");
            }

            return CashRequestResource::make($cash_request);

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showCashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource("Failed to get cash request");
        }
    }

    public function approvedByAdmin(Request $request , $cash_request_id)
    {
        try{
            $cash_request = CashRequest::where('id', $cash_request_id)->first();

            if($cash_request->status !== 'approved_by_accounts') {
                return new ErrorResource("Cash request status must be approved by accounts to proceed.");
            }

            if(!$cash_request) {
                return new ErrorResource("Cash request not found");
            }

            $cash_request->update([
                'status' => $request->status,
            ]);

            DB::commit();
            return SuccessResource::make([
                'message' => "Cash request approved successfully",
            ])->withWrappData();

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@approvedByManager: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource("Failed to approve cash request");
        }
    }

    public function rejectedByAdmin(Request $request , $cash_request_id)
    {
        try{

            $cash_request = CashRequest::where('id' , $cash_request_id)->first();


            if($cash_request->status !== 'approved_by_accounts') {
                return new ErrorResource("Cash request status must be approved by accounts to proceed.");

            }

            if (!$cash_request) {
                return response()->json(['error' => 'Cash request not found.'], 404);
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
            return new ErrorResource("Failed to reject cash request");
        }
    }

}
