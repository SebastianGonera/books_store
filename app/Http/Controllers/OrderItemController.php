<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id): JsonResponse
    {
        try {
            if ($id == '') {
                return response()->json(['error' => "Id is required."], 400);
            }
            $orderItems = OrderItem::where('order_id', $id)
                ->get()
                ->makeHidden(['created_at', 'updated_at', 'book'])
                ->map(function ($item) {
                    $item['book_title'] = $item->book->title;
                    $item['book_image_url'] = $item->book->image_url;
                    return $item;
                }
                );

            if ($orderItems->isEmpty()) {
                return response()->json(['error' => "No order items."], 404);
            }
            return response()->json(['message' => "Order items found.", 'data' => $orderItems]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderItemRequest $request): JsonResponse
    {
        try {
            $item = OrderItem::create($request->validated());

            if ($item) {
                return response()->json(['message' => 'Item added to cart.', 'data' => $item], 201);
            } else {
                return response()->json(['error' => 'Item not created.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderItemRequest $request, string $id): JsonResponse
    {
        try {
            if ($id === "") {
                return response()->json(['error' => 'Id is required.'], 400);
            }
            $item = OrderItem::where('id', $id)->first();
            if (!$item) {
                return response()->json(['error' => 'Item not found.'], 404);
            }
            $item->update($request->validated());

            return response()->json(['message' => 'item updated successfully.', 'data' => $item], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if ($id == '') {
                return response()->json(['error' => "Id is required"], 400);
            }
            $orderItem = OrderItem::where('id', $id)->firstOrFail();
            if (!$orderItem) {
                return response()->json(['error' => "Order item not found."], 404);
            }
            $orderItem->delete();
            return response()->json(['message' => "Order item successfully deleted."]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
