<?php

namespace App\Http\Controllers\Api\v1\Accountant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Employee\CashRequestResource;
use App\Http\Resources\Api\v1\ErrorResource;
use App\Http\Resources\Api\v1\SuccessResource;
use App\Models\CashRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountantCashRequestController extends Controller
{
    public function cashRequests(Request $request)
    {
        try{

            $cash_requests = CashRequest::where('status', 'approved_by_manager')->orderBy('id', 'desc')
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

            if(!$cash_request) {
                return new ErrorResource(__('cash_request.no_request'));
            }

            return CashRequestResource::make($cash_request);

        }catch(\Exception $e){
            Log::channel('error')->error('error in AccountantCashRequestController@showCashRequest: ' . $e->getMessage() . ' at Line: ' . $e->getLine() . ' in File: ' . $e->getFile());
            return new ErrorResource(__('cash_request.failed'));
        }
    }

    public function approvedByAccountant(Request $request , $cash_request_id)
    {
        try{
            $cash_request = CashRequest::where('id', $cash_request_id)->where('status', 'approved_by_manager')->first();

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

    public function rejectedByAccountant(Request $request , $cash_request_id)
    {
        try{

            $cash_request = CashRequest::where([
                'id'        => $cash_request_id,
                'status'    => 'approved_by_manager',
            ])->first();

            if (!$cash_request) {
                // Handle case where the CashRequest is not found
                return response()->json(['error' => 'Cash request not found.'], 404);
            }

            if ($cash_request->status !== 'approved_by_manager') {
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
            return new ErrorResource("Failed to reject cash request");
        }
    }

}
