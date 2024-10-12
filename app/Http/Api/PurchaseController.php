<?php

namespace App\Http\Api;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{

    public function status($purchaseId): JsonResponse
    {
        try {
            if ($purchaseId) {
                $purchase = Purchase::findOrFail($purchaseId);
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'purchaseId' => $purchase->id,
                        'status' => $purchase->status,
                        'message' => 'Compra encontrada'
                    ]
                ]);
            }
        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Compra no encontrada'
        ], 404);
    }

}
