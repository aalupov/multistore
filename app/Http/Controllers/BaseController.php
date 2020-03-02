<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Carbon\Carbon;
use App\Mail\ConfirmationMailSend;
use App\Mail\AddBuisnessMailSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Repositories\StoresRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\ReviewsProductRepository;
use App\Repositories\GoogleApiKeyRepository;
use App\Repositories\AttributesProductRepository;
use App\Repositories\CountryGeoDataRepository;
use App\Repositories\CategoryProductsRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\OrdersProductsRepository;
use App\Repositories\OrdersAddressesRepository;
use App\Repositories\OrdersStatusesRepository;
use App\Repositories\OrdersCommentsRepository;
use App\Repositories\OrdersProductsAttributesValuesRepository;
use App\Repositories\UserAddressesRepository;
use Spatie\Geocoder\Geocoder;
use Illuminate\Support\Facades\Auth;

abstract class BaseController extends Controller
{

    /**
     * const integer
     */
    protected const PAGINATE = 6;

    /**
     * const integer
     */
    protected const PAGINATE4REVIEWS = 3;

    /**
     * const array
     */
    protected const viewShareVarsCart = [
        'totalInCart'
    ];

    /**
     * const array
     */
    protected const viewShareVarsGuestCheckout = [
        'totalInCart',
        'virtual'
    ];

    /**
     * const array
     */
    protected const viewShareVarsCheckout = [
        'totalInCart',
        'addresses',
        'virtual'
    ];

    /**
     * const array
     */
    private const viewShareVarsContactForm = [
        'storeInfo',
        'namesOfCategories',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsForStores = [
        'storeList',
        'city',
        'state',
        'apiKey',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsForCategory = [
        'id',
        'storeInfo',
        'namesOfCategories',
        'categoryName',
        'products',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsSeachProducts = [
        'city',
        'state',
        'apiKey',
        'products',
        'totalInCart'
    ];

    /**
     * const array
     */
    protected const viewShareVarsForGoogleMap = [
        'storeInfo',
        'geoDataofMultiStore',
        'apiKeyAndCountry',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsForProducts = [
        'storeInfo',
        'namesOfCategories',
        'categoryNamesOfProduct',
        'products',
        'category_id',
        'relatedProducts',
        'reviews',
        'ratingOfProduct',
        'attributes',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsForStoreInfo = [
        'storeInfo',
        'namesOfCategories',
        'products',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsForProfile = [
        'userInfo',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsUserOrdersPage = [
        'orders',
        'totalInCart'
    ];

    /**
     * const array
     */
    private const viewShareVarsUserOrderPage = [
        'order',
        'products',
        'totalInCart'
    ];

    /**
     * const array
     */
    protected const viewShareVarsForShortStoreInfo = [
        'storeInfo'
    ];

    /**
     * BaseController constructor
     */
    public function __construct()
    {
        $this->ReviewsProductRepository = app(ReviewsProductRepository::class);
        $this->StoresRepository = app(StoresRepository::class);
        $this->ProductsRepository = app(ProductsRepository::class);
        $this->AttributesProductRepository = app(AttributesProductRepository::class);
        $this->GoogleApiKeyRepository = app(GoogleApiKeyRepository::class);
        $this->CountryGeoDataRepository = app(CountryGeoDataRepository::class);
        $this->CategoryProductsRepository = app(CategoryProductsRepository::class);
        $this->UserRepository = app(UserRepository::class);
        $this->OrdersRepository = app(OrdersRepository::class);
        $this->OrdersProductsRepository = app(OrdersProductsRepository::class);
        $this->OrdersAddressesRepository = app(OrdersAddressesRepository::class);
        $this->OrdersStatusesRepository = app(OrdersStatusesRepository::class);
        $this->OrdersCommentsRepository = app(OrdersCommentsRepository::class);
        $this->UserAddressesRepository = app(UserAddressesRepository::class);
        $this->OrdersProductsAttributesValuesRepository = app(OrdersProductsAttributesValuesRepository::class);
    }

    /**
     * Sorting the stores collection by proximity
     *
     * @param decimal $lat,
     *            $lon
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function sortStoresByDistance($lat, $lon, $collection)
    {
        foreach ($collection as $item) {
            $item->distance = round($this->distance($lat, $lon, $item->store_lat, $item->store_lon), 0);
        }

        $result = $collection->sortBy('distance');

        return $result;
    }

    /**
     * Sorting the category collection by subcategories
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param Illuminate\Database\Eloquent\Collection $categories
     *
     * @return array|null
     */
    protected function sortCategoriesByChildrens($collection, $categories = NULL)
    {
        if (isset($categories)) {
            foreach ($categories as $cat) {
                foreach ($collection as $items) {
                    if ($items->id == $cat->category_id) {
                        $items->is_category = true;
                    }
                }
            }
        }

        foreach ($collection as $items) {
            if (! $items->parent_id) {
                $data['parents'][$items->id]['category_name'] = $items->category_name;
                $data['parents'][$items->id]['category_id'] = $items->id;
            }
        }

        foreach ($collection as $items) {
            if (isset($data['parents'][$items->parent_id])) {
                $data['childrens'][$items->parent_id][$items->id]['category_name'] = $items->category_name;
                $data['childrens'][$items->parent_id][$items->id]['category_id'] = $items->id;
                if ($items->is_category) {
                    $data['childrens'][$items->parent_id][$items->id]['is_category'] = true;
                } else {
                    $data['childrens'][$items->parent_id][$items->id]['is_category'] = false;
                }
            }
        }

        if (isset($data)) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * Sorting the collection by rating
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *            $param string $key
     *            
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function sortByRating($collection, $key)
    {
        return $collection->sortByDesc($key);
    }

    /**
     * Pagination of Illuminate\Database\Eloquent\Collection
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param string|null $perPage
     * @param string|null $pageName
     * @param int|null $fragment
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginateCollection($collection, $perPage = null, $pageName = 'page', $fragment = null): Paginator
    {
        $currentPage = Paginator::resolveCurrentPage($pageName);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);
        parse_str(request()->getQueryString(), $query);
        unset($query[$pageName]);
        $paginator = new Paginator($currentPageItems, $collection->count(), $perPage, $currentPage, [
            'pageName' => $pageName,
            'path' => Paginator::resolveCurrentPath(),
            'query' => $query,
            'fragment' => $fragment
        ]);

        return $paginator;
    }

    /**
     * Get category name from collection of categories by id
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param int $id
     *
     * @return string
     */
    private function getCategoryName($collection, $id)
    {
        foreach ($collection as $item) {
            if ($item->id == $id) {
                return $item->category_name;
            }
        }

        return null;
    }

    /**
     * Get category names from collections
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param Illuminate\Database\Eloquent\Collection $categories
     *
     * @return Illuminate\Support\Collection
     */
    private function getCategoryNamesForProduct($collection, $categories)
    {
        foreach ($collection as $item) {
            $data[$item->category_id] = $this->getCategoryName($categories, $item->category_id);
        }

        return collect($data);
    }

    /**
     * Counting of raiting
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return int
     */
    private function countRating($collection)
    {
        $r = 0;
        foreach ($collection as $item) {
            $r = $item->rating + $r;
        }
        if ($collection->count() != 0) {
            $raiting = $this->countingOfTheRating($r, $collection->count());
        } else {
            $raiting = 0;
        }
        return $raiting;
    }

    /**
     * Validate an email address.
     *
     * @param string $email
     *
     * @return boolean
     */
    protected function validEmail($email)
    {
        $atom = "[-a-z0-9!#$%&'*+/=?^_`{|}~]"; // RFC 5322 unquoted characters in local-part
        $localPart = "(?:\"(?:[ !\\x23-\\x5B\\x5D-\\x7E]*|\\\\[ -~])+\"|$atom+(?:\\.$atom+)*)"; // quoted or unquoted
        $alpha = "a-z\x80-\xFF"; // superset of IDN
        $domain = "[0-9$alpha](?:[-0-9$alpha]{0,61}[0-9$alpha])?"; // RFC 1034 one domain component
        $topDomain = "[$alpha](?:[-0-9$alpha]{0,17}[$alpha])?";
        return (bool) preg_match("(^$localPart@(?:$domain\\.)+$topDomain\\z)i", $email);
    }

    /**
     * Converting the dates of collection to HH:MM format and converting if the days of week.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return void
     */
    protected function convertDateToHourMinute($collection)
    {
        foreach ($collection as $item) {
            if ($item->opened_at != NULL) {
                $item->opened_at = $this->getHoursAndMinutesFromDate($item->opened_at, $item->time_zone);
            }
            if ($item->closed_at != NULL) {
                $item->closed_at = $this->getHoursAndMinutesFromDate($item->closed_at, $item->time_zone);
            }

            if ($item->day_of_week == 1) {
                $item->day_of_week = 'Monday';
            } elseif ($item->day_of_week == 2) {
                $item->day_of_week = 'Tuesday';
            } elseif ($item->day_of_week == 3) {
                $item->day_of_week = 'Wednesday';
            } elseif ($item->day_of_week == 4) {
                $item->day_of_week = 'Thursday';
            } elseif ($item->day_of_week == 5) {
                $item->day_of_week = 'Friday';
            } elseif ($item->day_of_week == 6) {
                $item->day_of_week = 'Saturday';
            } elseif ($item->day_of_week == 7) {
                $item->day_of_week = 'Sunday';
            }
        }
    }

    /**
     * Converting the dates of collection to HH:MM format.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return void
     */
    protected function convertDateToHourMinuteForStoreEdit($collection)
    {
        foreach ($collection as $item) {
            if ($item->opened_at != NULL) {
                $item->opened_at = $this->getHoursAndMinutesFromDate2($item->opened_at, $item->time_zone);
            }
            if ($item->closed_at != NULL) {
                $item->closed_at = $this->getHoursAndMinutesFromDate2($item->closed_at, $item->time_zone);
            }
        }
    }

    /**
     * Add store status(opened\closed) to the store list collection.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Collection $collection
     */
    private function addStoreStatus($collection)
    {
        foreach ($collection as $items) {
            $items->status = true;
            if (! $this->checkStoreStatus($items->time_shedule)) {
                $items->status = false;
            }
        }
        return $collection;
    }

    /**
     * Add rating to the store list collection.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Collection $collection
     */
    private function addRatingToStoresList($collection)
    {
        foreach ($collection as $items) {
            $items->store_rating = $this->countRating($items->reviews);
        }

        return $collection;
    }

    /**
     * Add rating to the product collection.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param Illuminate\Support\Collection $products
     *
     * @return Illuminate\Support\Collection
     */
    private function addRatingToProductCollection($collection, $products)
    {
        foreach ($products as $product) {

            $id = $product->id;
            $data[$id] = 0;
            $count = 0;
            foreach ($collection as $items) {

                if ($id == $items->product_id) {
                    $data[$id] = $items->rating + $data[$id];
                    $count ++;
                }
            }
            if ($data[$id] == 0) {
                $product->rating = 0;
            } else {
                $product->rating = $this->countingOfTheRating($data[$id], $count);
            }
        }

        return $products;
    }

    /**
     * Getting the current store status opened\closed.
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return boolean
     */
    protected function checkStoreStatus($collection)
    {
        $current_day = Carbon::now()->dayOfWeek;

        foreach ($collection as $item) {
            if ($item->opened_at == NULL && $item->day_of_week == $current_day) {
                return false;
            }
        }
        return true;
    }

    /**
     * Adding the cart to session.
     *
     * @param App\Models\Products $product
     * @param App\Http\Requests\AddToCartRequest $request
     *
     * @return boolean
     */
    protected function createCart($product, $request)
    {
        $product_id = $product->id;
        $store_id = $request->input('store_id');
        $attributeValues = NULL;
        $cart = $request->session()->get('cart');

        if ($request->input('attribute_values')) {
            $attributeValues = $request->input('attribute_values');
        }

        if (isset($cart[$store_id][$product_id])) {
            $tmpVar = $cart[$store_id][$product_id]['product_quantity'];
            $cart[$store_id][$product_id]['product_quantity'] = $cart[$store_id][$product_id]['product_quantity'] + $request->input('quantity');

            // checking of quantity of products
            if (! $this->checkQtyProduct($product->product_quantity, $cart[$store_id][$product_id]['product_quantity'])) {
                $cart[$store_id][$product_id]['product_quantity'] = $tmpVar;
                return false;
            } else {
                $request->session()->put('cart', $cart);
                return true;
            }
        } else {
            $cart[$store_id][$product_id] = [
                'product_title' => $product->product_title,
                'product_sku' => $product->product_sku,
                'product_regular_price' => $product->product_regular_price,
                'product_sale_price' => $product->product_sale_price,
                'product_type' => $product->product_type,
                'product_picture' => $product->product_picture,
                'product_quantity' => $request->input('quantity'),
                'attribute_values' => $attributeValues
            ];

            $cart[$store_id]['store_title'] = $request->input('store_title');

            // checking of quantity of products
            if (! $this->checkQtyProduct($product->product_quantity, $cart[$store_id][$product_id]['product_quantity'])) {
                return false;
            } else {
                $request->session()->put('cart', $cart);
                return true;
            }
        }
    }

    /**
     * Checking a quantity of the product.
     *
     * @param int $available
     * @param int $quantity
     *
     * @return boolean
     */
    protected function checkQtyProduct($available, $quantity)
    {
        if ($available < $quantity) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * counting the total price and quantity of the products in the cart.
     *
     * @return array
     */
    protected function getGrandTotalInCart()
    {
        $total['products'] = 0;
        $total['price'] = 0;

        if (session('cart')) {
            $cart = session()->get('cart');
            foreach ($cart as $store) {
                unset($store['store_title']);
                foreach ($store as $item) {
                    $total['products'] += $item['product_quantity'];
                    if (! empty($item['product_sale_price'])) {
                        $price = $item['product_sale_price'];
                    } else {
                        $price = $item['product_regular_price'];
                    }
                    $total['price'] += $price * $item['product_quantity'];
                }
            }
        }
        return $total;
    }

    /**
     * send confirmation email to the customer.
     *
     * @param array $request
     * @param array $data
     * @param int $orderId
     * @param string $orderNumber
     *
     * @return void
     */
    protected function sendConfirmEmail($request, $data, $orderId, $orderNumber)
    {
        $objMailSend = new \stdClass();
        $objMailSend->sender_message = $data;
        $objMailSend->order_id = $orderId;
        $objMailSend->order_number = $orderNumber;
        $objMailSend->sender_email = env('MAIL_FROM_ADDRESS', 'demo@multistore.com');
        $objMailSend->sender_name = env('MAIL_FROM_NAME', 'Laravel');

        if (isset(Auth::user()->id)) {
            $objMailSend->receiver_name = Auth::user()->name;
            $mailTo = Auth::user()->email;
        } else {
            $objMailSend->receiver_name = $request['address']['billing']['first_name'] . ' ' . $request['address']['billing']['last_name'];
            $mailTo = $request['address']['billing']['email'];
        }
        Mail::to($mailTo)->send(new ConfirmationMailSend($objMailSend));
    }

    /**
     * send "add a buisness" email to the admin.
     *
     * @param array $data
     *
     * @return void
     */
    protected function sendAddBuisnessEmail($data)
    {
        $objMailSend = new \stdClass();
        $objMailSend->sender_message = $data;
        $objMailSend->sender_email = $data['store_email'];
        $objMailSend->sender_name = $data['store_title'];
        $objMailSend->receiver_name = env('MAIL_FROM_NAME', 'Laravel');
        $mailTo = env('MAIL_FROM_ADDRESS', 'demo@multistore.com');

        Mail::to($mailTo)->send(new AddBuisnessMailSend($objMailSend));
    }

    /**
     * Creating of the store page by store id .
     *
     * @param App\Models\Stores $storeInfo
     * @param string $key
     *
     * @return array
     */
    protected function createStorePage($storeInfo, $key = NULL)
    {
        $namesOfCategories = $this->sortCategoriesByChildrens($storeInfo->categories);
        if (isset($key)) {
            $collectedProductsWithRating = $this->sortByRating($this->addRatingToProductCollection($storeInfo->reviews, $storeInfo->products), $key);
        } else {
            $collectedProductsWithRating = $this->addRatingToProductCollection($storeInfo->reviews, $storeInfo->products);
        }
        $products = $this->paginateCollection($collectedProductsWithRating, self::PAGINATE);
        $storeInfo->store_status = $this->checkStoreStatus($storeInfo->time_shedule);
        $storeInfo->store_rating = $this->countRating($storeInfo->reviews);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsForStoreInfo);
    }

    /**
     * Creating of the category page by store id and category id.
     *
     * @param int $storeId
     * @param int $id
     * @param string $key
     *
     * @return array
     */
    protected function createCategoryPage($storeId, $id, $key = NULL)
    {
        $storeInfo = $this->StoresRepository->getStoreInfoById($storeId);
        $categoryName = $this->getCategoryName($storeInfo->categories, $id);
        $namesOfCategories = $this->sortCategoriesByChildrens($storeInfo->categories);
        if (! $storeInfo->products->isEmpty()) {
            $products = $this->getProductsByCategoryId($id, $storeInfo->products, $storeInfo->store_categories_products);
            if (isset($key)) {
                $collectedProductsWithRating = $this->sortByRating($this->addRatingToProductCollection($storeInfo->reviews, $products), $key);
            } else {
                $collectedProductsWithRating = $this->addRatingToProductCollection($storeInfo->reviews, $products);
            }
            $products = $this->paginateCollection($collectedProductsWithRating, self::PAGINATE);
        } else {
            $products = NULL;
        }
        $storeInfo->store_status = $this->checkStoreStatus($storeInfo->time_shedule);
        $storeInfo->store_rating = $this->countRating($storeInfo->reviews);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsForCategory);
    }

    /**
     * Creating of the product page by product id
     *
     * @param int $id
     *
     * @return array
     */
    protected function createProductPage($id)
    {
        $storeId = $this->ProductsRepository->getStoreIdByProductId($id)->store_id;
        $storeInfo = $this->StoresRepository->getStoreInfoById($storeId);
        $namesOfCategories = $this->sortCategoriesByChildrens($storeInfo->categories);
        $products = $this->ProductsRepository->getProductById($id);
        $categoryNamesOfProduct = $this->getCategoryNamesForProduct($products->store_categories_products, $storeInfo->categories);
        $attributes = $this->AttributesProductRepository->getAttributesByProductId($id);
        $collectedProductsWithRating = $this->addRatingToProductCollection($storeInfo->reviews, $storeInfo->products);
        $relatedProducts = $this->paginateCollection($collectedProductsWithRating, self::PAGINATE);
        $reviews = $products->reviews;
        $ratingOfProduct = $this->countRating($reviews);
        $reviews = $this->paginateCollection($reviews, self::PAGINATE4REVIEWS);
        $storeInfo->store_status = $this->checkStoreStatus($storeInfo->time_shedule);
        $storeInfo->store_rating = $this->countRating($storeInfo->reviews);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsForProducts);
    }

    /**
     * Creating of the user profile to edit page by user id
     *
     * @param int $id
     *
     * @return array
     */
    protected function profileEditPage($id)
    {
        $userInfo = $this->UserRepository->getUserInfoByUserId($id);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsForProfile);
    }

    /**
     * Creating of the contact page by store id
     *
     * @param int $id
     *
     * @return array
     */
    protected function createContactPage($id)
    {
        $storeInfo = $this->StoresRepository->getStoreInfoByIdForContactForm($id);
        $namesOfCategories = $this->sortCategoriesByChildrens($storeInfo->categories);
        $storeInfo->store_status = $this->checkStoreStatus($storeInfo->time_shedule);
        $storeInfo->store_rating = $this->countRating($storeInfo->reviews);
        $this->convertDateToHourMinute($storeInfo->time_shedule);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsContactForm);
    }

    /**
     * Creating of the user orders page by user id
     *
     * @param int $id
     *
     * @return array
     */
    protected function createUserOrdersPage($id)
    {
        $orders = $this->paginateCollection($this->OrdersRepository->getOrdersByUserId($id), self::PAGINATE);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsUserOrdersPage);
    }

    /**
     * Creating of the user order page by order id
     *
     * @param int $id
     *
     * @return array
     */
    protected function createUserOrderPage($id)
    {
        $order = $this->OrdersRepository->getOrderByOrderId($id);
        $products = $this->convertProductsForOrderPage($order->products, $order->attributes_values);
        $totalInCart = $this->getGrandTotalInCart();

        return compact(self::viewShareVarsUserOrderPage);
    }

    /**
     * Sorting and converting the product collection to array for the order page
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     * @param Illuminate\Database\Eloquent\Collection $attributes
     *
     * @return array
     */
    protected function convertProductsForOrderPage($collection, $attributes)
    {
        foreach ($collection as $product) {
            $data[$product->store_id]['store_title'] = $product->store_title;
            $data[$product->store_id][$product->product_id]['product_title'] = $product->product_title;
            $data[$product->store_id][$product->product_id]['product_sku'] = $product->product_sku;
            $data[$product->store_id][$product->product_id]['product_regular_price'] = $product->product_regular_price;
            $data[$product->store_id][$product->product_id]['product_sale_price'] = $product->product_sale_price;
            $data[$product->store_id][$product->product_id]['product_quantity'] = $product->product_order_quantity;
            $data[$product->store_id][$product->product_id]['product_picture'] = $product->product_picture;

            if ($product->product_type == 'variable') {
                foreach ($attributes as $item) {
                    if ($item->product_id == $product->product_id) {
                        $data[$product->store_id][$product->product_id]['attribute_values'][$item->attribute_name] = $item->attribute_value;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Creating of the found products page
     *
     * $param \App\Http\Requests\StoresStoreRequest $request
     *
     * @return array|NULL
     */
    protected function seachProducts($request)
    {
        $key = $request->input('find_product');
        $products = $this->ProductsRepository->getProductsByKey($key);

        if (empty($products->count())) {
            return NULL;
        } else {
            $apiKey = '';
            $apiKeyAndCountry = $this->GoogleApiKeyRepository->getApiKeyAndCountryCode();
            if (isset($apiKeyAndCountry)) {
                $apiKey = $apiKeyAndCountry->google_api_keys;
            }
            $city = geoip()->getLocation()->city;
            $state = geoip()->getLocation()->state;

            foreach ($products as $item) {
                $collectedProductsWithRating = $this->addRatingToProductCollection($item->reviews, $products);
            }
            $products = $this->paginateCollection($collectedProductsWithRating, self::PAGINATE);
            $totalInCart = $this->getGrandTotalInCart();

            return compact(self::viewShareVarsSeachProducts);
        }
    }

    /**
     * Converting address from string to array
     *
     * $param string $address
     *
     * @return array
     */
    protected function convertAddressFromStringToArray($address)
    {
        $address = explode("|", $address);
        $data['first_name'] = $address[1];
        $data['last_name'] = $address[2];
        $data['email'] = $address[3];
        $data['phone'] = $address[4];
        $data['city'] = $address[5];
        $data['zip_code'] = $address[6];
        $data['address'] = $address[7];
        $data['state'] = $address[8];
        $data['country'] = $address[9];

        return $data;
    }

    /**
     * Creating of the home stores page
     *
     * $param \App\Http\Requests\StoresStoreRequest $request
     *
     * @return array
     */
    protected function createStoresPage($request = NULL)
    {
        $apiKey = '';
        $country = 'US';
        $apiKeyAndCountry = $this->GoogleApiKeyRepository->getApiKeyAndCountryCode();
        if (isset($apiKeyAndCountry)) {
            $apiKey = $apiKeyAndCountry->google_api_keys;
            $country = $apiKeyAndCountry->country_location;
        }
        $city = geoip()->getLocation()->city;
        $state = geoip()->getLocation()->state;
        $lat = geoip()->getLocation()->lat;
        $lon = geoip()->getLocation()->lon;
        $totalInCart = $this->getGrandTotalInCart();
        $storeList = $this->StoresRepository->getAllActiveStores();
        $storeList = $this->addStoreStatus($storeList);
        $storeList = $this->addRatingToStoresList($storeList);

        if (isset($request)) {
            if ($request->input('find_store')) {
                $zipOrCity = $request->input('find_store');

                // get geo data
                $client = new \GuzzleHttp\Client();
                $geocoder = new Geocoder($client);
                $geocoder->setApiKey($apiKey);
                $geocoder->setCountry($country);
                $lat = $geocoder->getCoordinatesForAddress($zipOrCity)['lat'];
                $lon = $geocoder->getCoordinatesForAddress($zipOrCity)['lng'];

                if ($lat != 0 && $lon != 0) {
                    $storeList = $this->sortStoresByDistance($lat, $lon, $storeList);
                } else {
                    $lat = geoip()->getLocation()->lat;
                    $lon = geoip()->getLocation()->lon;
                    $storeList = $this->sortStoresByDistance($lat, $lon, $storeList);
                }
            } elseif ($request->input('orderby')) {
                $storeList = $this->sortByRating($storeList, 'store_rating');
            }
        } else {
            $storeList = $this->sortStoresByDistance($lat, $lon, $storeList);
        }

        $storeList = $this->paginateCollection($storeList, self::PAGINATE);

        return compact(self::viewShareVarsForStores);
    }

    /**
     * Checking of virtual products
     *
     * $param array $cart
     *
     * @return boolean
     */
    protected function checkVirtualProducts($cart)
    {
        foreach ($cart as $store) {
            unset($store['store_title']);
            foreach ($store as $product) {
                if ($product['product_type'] != 'virtual') {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get real IP of the client
     *
     * @return string
     */
    protected function getIp()
    {
        foreach (array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    /**
     * form the product collection by category id.
     *
     * @param int $id
     * @param Illuminate\Database\Eloquent\Collection $products
     * @param Illuminate\Database\Eloquent\Collection $categories
     *
     * @return Illuminate\Support\Collection
     */
    private function getProductsByCategoryId($id, $products, $categories)
    {
        foreach ($categories as $key => $category) {
            if ($category->category_id != $id) {
                unset($categories[$key]);
            }
        }

        foreach ($categories as $category) {
            foreach ($products as $key => $product) {

                if ($category->product_id == $product->id) {
                    $newProducts[$key] = $products[$key];
                }
            }
        }

        return collect($newProducts);
    }

    /**
     * Counting of the rating.
     *
     * @param decimal $totalRating
     * @param int $count
     *
     * @return decimal $rating
     */
    private function countingOfTheRating($totalRating, $count)
    {
        return round(($totalRating / $count) / 10, 0, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Convert date to "h:mm a" format.
     *
     * @param
     *            date(Y-m-d H:i:s) $date
     * @param string $time_zone
     *
     * @return date(h:mm a) $date
     */
    private function getHoursAndMinutesFromDate($date, $time_zone)
    {
        return Carbon::parse($date, $time_zone)->isoFormat('h:mm a');
    }

    /**
     * Convert date to "HH:mm" format.
     *
     * @param
     *            date(Y-m-d H:i:s) $date
     * @param string $time_zone
     *
     * @return date(h:mm a) $date
     */
    private function getHoursAndMinutesFromDate2($date, $time_zone)
    {
        return Carbon::parse($date, $time_zone)->isoFormat('HH:mm');
    }

    /**
     * Counting a distance to the store
     *
     * @param decimal $lat1,
     *            $lon1, $lat2, $lon2
     * @param string $unit
     * @return decimal
     */
    private function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $unit = strtoupper($unit);

        if ($unit == "K") {

            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
