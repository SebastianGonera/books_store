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
        try {
            $orders = Order::all()
                ->makeHidden(['updated_at', 'user'])
                ->map(function ($order) {
                    $order['username'] = $order->user->name;
                    return $order;
                });

            if ($orders->isEmpty()) {
                return response()->json(['error' => 'There are no orders yet.'], 404);
            }

            return response()->json(['message' => 'Successfully get all orders.', 'data' => $orders]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): JsonResponse
    {
        try {
            $order = Order::create($request->validated());
            if ($order) {
                return response()->json(['message' => 'Order created successfully.', 'data' => $order]);
            } else {
                return response()->json(['error' => 'Order could not be created.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            if ($id == '') {
                return response()->json(['error' => 'Id not provided.'], 400);
            }
            $order = Order::where('id', $id)
                ->get()
                ->makeHidden(['user'])
                ->map(function ($order) {
                    $order['username'] = $order->user->name;
                    return $order;
                });
            if ($order) {
                return response()->json(['message' => 'Successfully get order.', 'data' => $order]);
            } else {
                return response()->json(['error' => 'Order not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id): JsonResponse
    {
        try {
            if ($id == '') {
                return response()->json(['error' => 'Id not provided.'], 400);
            }
            $order = Order::where('id', $id)->firstOrFail();
            if ($order) {
                $order->update($request->validated());
                return response()->json(['message' => 'Order updated successfully.', 'data' => $order], 201);
            } else {
                return response()->json(['error' => 'Order not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if ($id == '') {
                return response()->json(['error' => 'Id is required.'], 400);
            }
            $order = Order::where('id', $id)->firstOrFail();
            if ($order) {
                $order->delete();
                return response()->json(['message' => 'Order deleted successfully.']);
            } else {
                return response()->json(['error' => 'Order not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
