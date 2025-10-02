<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartRequest;
class CartController extends Controller
{

  protected function userId(): int
    {
        return Auth::id();
    }

    public function index()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', $this->userId())
                        ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.',
                'cart' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Cart contents retrieved successfully.',
            'cart' => $cartItems
        ], 200);
    }


    public function store(CartRequest $request)
    {
        $productId = $request->product_id;
         $quantity  = $request->quantity ?? 1;

        // 2. Check if the item already exists
        $cartItem = Cart::where('user_id', $this->userId())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();

            return response()->json([
                'cart_item' => $cartItem,
                'message' => 'Product quantity updated in cart successfully.',
            ], 200);

        } else {
            $newCartItem = Cart::create([
                'user_id' => $this->userId(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);

            return response()->json([
                'cart_item' => $newCartItem,
                'message' => 'Product added to cart successfully.',
            ], 201);
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cartItem = Cart::where('user_id', $this->userId())->findOrFail($id);
        
        // 3. Update quantity
        $cartItem->quantity = $validatedData['quantity'];
        $cartItem->save();

        return response()->json([
            'cart_item' => $cartItem,
            'message' => 'Cart item quantity updated successfully.',
        ], 200);
    }


    public function destroy(string $id)
    {
        $deleted = Cart::where('user_id', $this->userId())
                       ->findOrFail($id)
                       ->delete();

        if ($deleted) {
             return response()->json([
                'message' => 'Product removed from cart successfully.',
            ], 200);
        }
        
        return response()->json(['message' => 'Could not delete cart item.'], 500);
    }
}