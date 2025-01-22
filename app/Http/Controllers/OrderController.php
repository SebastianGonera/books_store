<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try{
            $orders = Order::all()
                ->makeHidden(['updated_at', 'user'])
                ->map(function ($order) {
                    $order['username'] = $order->user->name;
                    return $order;
                });
            return response()->json($orders);
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): JsonResponse
    {
        try{
            $order = Order::create($request->validated());
            if($order){
                return response()->json(['data' => $order, 'message' => 'Order created successfully']);
            }
            else{
                return response()->json(['error' => 'Order could not be created'], 404);
            }
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if($id==''){
                return response()->json(['error' => 'id not provided'], 400);
            }
            $order = Order::where('id', $id)->firstOrFail();
            if ($order){
                return response()->json(['order' => $order]);
            }
            else{
                return response()->json(['error' => 'order not found'], 404);
            }
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        try {
            if($id==''){
                return response()->json(['error' => 'id not provided'], 400);
            }
            $order = Order::where('id', $id)->firstOrFail();
            if($order){
                $order->update($request->validated());
                return response()->json(['data' => $order, 'message' => 'Order updated successfully']);
            }
            else{
                return response()->json(['error' => 'order not found'], 404);
            }
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try{
            if($id == ''){
                return response()->json(['error' => 'id is required'], 400);
            }
            $order = Order::where('id', $id)->firstOrFail();
            if($order){
                $order->delete();
                return response()->json(['message' => 'Order deleted successfully'], 200);
            }
            else{
                return response()->json(['error' => 'Order not found'], 404);
            }
        }
        catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()],500);
        }
    }
}
