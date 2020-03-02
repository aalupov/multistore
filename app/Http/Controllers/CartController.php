<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends BaseController
{

    /**
     * CartController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalInCart = $this->getGrandTotalInCart();

        return view('cart', compact(self::viewShareVarsCart));
    }

    /**
     * Update the cart.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->input('remove')) {
            $cart = session()->get('cart');
            $store_id = $request->input('store_id');
            $product_id = $request->input('remove');
            unset($cart[$store_id][$product_id]);
            if (count($cart[$store_id]) == 1) {
                unset($cart[$store_id]);
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed successfully');
        }
        if ($request->input('update')) {

            $cart = session()->get('cart');
            $store_id = $request->input('store_id');
            foreach ($request->input('product_id') as $product_id) {
                $product = $this->ProductsRepository->getQtyAndNameProductById($product_id);
                $quantity = $request->input('quantity')[$product_id];
                if (! $this->checkQtyProduct($product->product_quantity, $quantity)) {
                    return redirect()->back()
                        ->withErrors('Sorry, We do not have enough of this product: ' . $product->product_title)
                        ->withInput();
                }
                $cart[$store_id][$product_id]['product_quantity'] = $quantity;
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully');
        }
    }

    /**
     * Clear the cart
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function clear(Request $request)
    {
        if ($request->input('clear_cart')) {
            $request->session()->forget('cart');
            return redirect()->back()->with('success', 'Cart has been cleared');
        }
    }
}
