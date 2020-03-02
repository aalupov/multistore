<?php
namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends BaseController
{

    /**
     * CheckoutController constructor
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
        $virtual = $this->checkVirtualProducts(session('cart'));

        if (! isset(Auth::user()->id)) {
            return view('checkout', compact(self::viewShareVarsGuestCheckout));
        } else {
            $addresses = $this->UserAddressesRepository->getAddressesByUserId(Auth::user()->id);
            return view('checkout', compact(self::viewShareVarsCheckout));
        }
    }

    /**
     * Place the order.
     *
     * @param App\Http\Requests\CheckoutRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function placeOrder(CheckoutRequest $request)
    {
        if (! isset(Auth::user()->id)) {
            $addresses = $request->input()['address'];
            if ($request['answer'] == 1) {
                $addresses['shipping'] = $addresses['billing'];
            }

            if (! ($this->validEmail($addresses['billing']['email']))) {
                return redirect()->back()
                    ->withErrors('The Billing Email must be a valid email address.')
                    ->withInput();
            }
            if ($request['virtual'] != 1) {
                if (! ($this->validEmail($addresses['shipping']['email']))) {
                    return redirect()->back()
                        ->withErrors('The Shipping Email must be a valid email address.')
                        ->withInput();
                }
            }
        } else {
            $billing = $request->input()['billing'];
            if ($request['answer'] == 1) {
                $shipping = $billing;
            }
            $addresses['billing'] = $this->convertAddressFromStringToArray($billing);

            if ($request['virtual'] != 1) {
                $shipping = $request->input()['shipping'];
                $addresses['shipping'] = $this->convertAddressFromStringToArray($shipping);
            }
        }

        // creating and checking the order number to uniq
        $checkOrderNumber = true;
        while ($checkOrderNumber) {
            $orderNumber = strtoupper(Str::random(6));
            if (! $this->OrdersRepository->getOrderIdByOrderNumber($orderNumber)) {
                $checkOrderNumber = false;
            }
        }
        // creating of the new order
        $data['user_id'] = 0;
        if (isset(Auth::user()->id)) {
            $data['user_id'] = Auth::user()->id;
        }
        $data['order_number'] = $orderNumber;
        $data['total_amount'] = $request->input()['total_amount'];
        $data['shipping_amount'] = 0;
        if ($request->input()['shipping_amount']) {
            $data['shipping_amount'] = $request->input()['shipping_amount'];
        }
        $data['payment_fee'] = 0;
        if ($request->input()['payment_fee']) {
            $data['payment_fee'] = $request->input()['payment_fee'];
        }
        $data['order_status_id'] = $this->OrdersStatusesRepository->getOrderStatusId('processing')->id;
        $data['ip_address'] = $this->getIp();

        $orderId = $this->OrdersRepository->createNewOrder($data);

        // add the product to the order
        $cart = session()->get('cart');
        foreach ($cart as $storeId => $stores) {
            unset($stores['store_title']);
            foreach ($stores as $productId => $products) {
                // checking quantiry of the product
                $product = $this->ProductsRepository->getQtyAndNameProductById($productId);
                if (! $this->checkQtyProduct($product->product_quantity, $products['product_quantity'])) {
                    $this->OrdersRepository->deleteOrder($orderId);
                    return redirect()->back()
                        ->withErrors('Sorry, We do not have enough of this product: ' . $product->product_title)
                        ->withInput();
                } else {
                    $this->OrdersProductsRepository->addProductToOrder($orderId, $storeId, $productId, $products['product_quantity']);
                    // update quantiry of the current product
                    $newQty = $product->product_quantity - $products['product_quantity'];
                    $this->ProductsRepository->updateQtyProduct($productId, $newQty);

                    // add attribute variables to the db
                    if (! empty($products['attribute_values'])) {
                        foreach ($products['attribute_values'] as $attrName => $attrValue) {
                            $this->OrdersProductsAttributesValuesRepository->addProductAttributeValueToOrder($orderId, $productId, $attrName, $attrValue);
                        }
                    }
                }
            }
        }
        // add the addresseses to the order
        $this->OrdersAddressesRepository->addAddressToOrder($orderId, 'billing', $addresses['billing']);
        if (! empty($addresses['shipping'])) {
            $this->OrdersAddressesRepository->addAddressToOrder($orderId, 'shipping', $addresses['shipping']);
        }

        // add the comment to the order
        $this->OrdersCommentsRepository->addCommentToOrder($orderId, $request->input()['order_comment']);

        // send confirmation email
        $this->sendConfirmEmail($request->input(), session()->get('cart'), $orderId, $orderNumber);

        // flush session
        $request->session()->forget('cart');

        $urlToOrder = '#' . $orderNumber;
        if (isset(Auth::user()->id)) {
            $urlToOrder = '<a href="/order/' . $orderId . '">#' . $orderNumber . '</a>';
        }
        return redirect('/success')->with('success', 'The order ' . $urlToOrder . ' has been placed successfully. <br>
          Thank you! <br>
          <a href="/"><button type="button" class="wpcmsdev-button color-blue">Continue to shop</button></a>');
    }
}
