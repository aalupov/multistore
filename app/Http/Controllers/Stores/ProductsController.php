<?php
namespace App\Http\Controllers\Stores;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductsRequest;
use App\Http\Requests\AddToCartRequest;

class ProductsController extends BaseController
{

    /**
     * ProductsController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add a new rewiew.
     *
     * @param App\Http\Requests\ProductsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        if ($request->input('comment_product_ID')) {
            if (! ($this->validEmail($request->input('email')))) {
                return redirect()->back()
                    ->withErrors('The email must be a valid email address.')
                    ->withInput();
            }
            $this->ReviewsProductRepository->addNewReview($request->input(), $request->input('comment_product_ID'));
            return redirect()->back()->with('success', 'We have received your review. Thank you!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('store.product', $this->createProductPage($id));
    }

    /**
     * The action to add to the cart.
     *
     * @param App\Http\Requests\AddToCartRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(AddToCartRequest $request)
    {
        $productId = $request->input('product_id');
        $product = $this->ProductsRepository->checkProduct($productId);

        if (! empty($request->input('fast_add_to_cart'))) {
            if ($product->product_type == 'variable') {
                return redirect()->route('productPage.show', $product->id)
                    ->withErrors('Please specify product required option(s).')
                    ->withInput();
            }
        }

        if (! $product) {
            return redirect()->back()
                ->withErrors('Sorry, This product does not exist:(')
                ->withInput();
        }

        if (! ($this->createCart($product, $request))) {
            return redirect()->back()
                ->withErrors('Sorry, We do not have enough of this product:(')
                ->withInput();
        } else {
            return redirect()->back()->with('success', 'Product added to cart successfully! <a href="/cart">View cart</a>');
        }
    }
}
