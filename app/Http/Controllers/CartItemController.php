<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $userId): JsonResponse
    {
        try {
            $cartItems = CartItem::where('user_id', $userId)
                ->get()
                ->makeHidden(['created_at', 'updated_at', 'book', 'user_id'])
                ->map(function ($item) {
                    $item['title'] = $item->book->title;
                    $item['author'] = $item->book->author;
                    $item['image_url'] = $item->book->image_url;
                    $item['price'] = $item->book->price * $item->quantity;
                    return $item;
                })
            ;
            return response()->json($cartItems);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartItemRequest $request): JsonResponse
    {
        try{
            $item = CartItem::create($request->validated());
            if ($item) {
                return response()->json(['data'=>$item, 'message'=> 'Item added to cart'], 201);
            }
            else{
                return response()->json(['error' => 'Item not created'], 400);
            }
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            if($id===""){
                return response()->json(['error' => 'id is required'], 400);
            }
            $item = CartItem::where('id', $id)->first();
            if (!$item) {
                return response()->json(['error' => 'item not found'], 404);
            }
            $item->update($request->validate([
                'quantity' => 'required|integer|min:1|max:10'
            ]));

            return response()->json(['data' => $item, 'message' => 'item updated successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if ($id===""){
                return response()->json(['error' => 'id is required'], 400);
            }
            $item = CartItem::where("id", $id)->firstOrFail();
            if (!$item) {
                return response()->json(['error' => 'item not found'], 404);
            }
            $item->delete();
            return response()->json(['message' => 'item deleted successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
