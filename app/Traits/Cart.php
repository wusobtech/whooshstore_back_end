<?php
namespace App\Traits;

use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Product;

trait Cart{
    public function processCart($product_id  = null ,$quantity = 1){
        $cart = getUserCart();

        if(!empty($product_id)){
            $product = Product::find($product_id);

            if(empty($product)){
                return ['success' => false, 'msg' => 'Item could not be validated!'];
            }


            $item = CartItem::where('cart_id' , $cart->id)->where('product_id' , $product->id)->first();
            if(!empty($item)){
                $item->delete();
                $msg = 'Item removed from cart!';
                $nxtAction = 'Add to cart';
                $type = 'remove';
                $cart_item = [
                    'quantity' => 1,
                    'total' => format_money($product->getPrice()),
                ];
            }
            else{
                $item = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'discount' => $product->discount ?? 0,
                ]);
                $msg = 'Item added to cart!';
                $nxtAction = 'Remove from cart';
                $type = 'add';
                $cart_item = [
                    'quantity' => $item->quantity,
                    'total' => format_money($item->getPrice()),
                ];
            }
        }

        $cart = refreshCart($cart->id);

        return [
            'success' => $msg ? true : false,
            'msg' => $msg ?? 'Couldn`t process request!',
            'cart' => $this->cartObject($cart),
            'action_type' => $type,
            'title' => $nxtAction,
            'cart_item_id' => $item->id,
            'item' => $cart_item,
        ];
    }


    public function updateCartItemQuantity($product_id , $quantity){
        $cart = getUserCart();
        $item = CartItem::where('cart_id' , $cart->id)->where('product_id' , $product_id)->first();
        if(empty($item->id)){
            $product = Product::find($product_id);

            if(empty($product)){
                return ['success' => false, 'msg' => 'Item could not be validated!'];
            }

            return [
                'success' => true,
                'msg' => '',
                'cart' => $this->cartObject($cart),
                'item' => [
                    'quantity' => $quantity,
                    'total' => format_money(($product->getPrice() * $quantity)),
                ],

            ];
        }

        $item->quantity = $quantity;
        $item->save();
        $item->total = format_money($item->getPrice() , 0);

        $cart = refreshCart($cart->id);
        return [
            'success' => true,
            'msg' => 'Item quantity updated!',
            'cart' => $this->cartObject($cart),
            'item' => [
                'quantity' => $item->quantity,
                'total' => format_money($item->getPrice()),
            ],
        ];
    }


    private function cartObject($cart){
        return [
            'total' => format_money($cart->total),
            'price' => format_money($cart->price),
            'discount' => format_money($cart->discount),
            'quantity' => $cart->items,
        ];
    }

}
