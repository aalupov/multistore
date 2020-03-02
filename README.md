# multistore
Multistore cart project

1.Dependencies:
- Laravel Framework 6.6
- PHP 7.2 and higher
- https://github.com/spatie/geocoder
- https://github.com/Torann/laravel-geoip

2. Features:
- Seaching and sorting the nearest stores by GeoIp of the customer by default
- Seaching and sorting the nearest stores to location
- Sorting the stores by average rating
- Seaching the products by all stores
- Showing the stores on the google map
- Showing contact info and social links of the store
- Showing the current status (opened\closed) of the store
- Showing the full store info on the store page
- Showing the categories and the latest products on the store page
- The products could be like simples, virtuals and variables.
- Sorting the products by average rating and price
- The customer can to see time shedule and to send a message to admin of the store on the contact page
- The customer can to add a review to the product on the product page
- Adding to cart with checking of quantity of the product
- The checkout is available for guest
- The authorized custome can manage the profile, orders and addresses on the user dashboard
- The general admin can to manage the stores, customes and orders in admin panel
- The store admin can to manage the own store, orders, categories, products, attributes of the products, reviews.
- Sending to the customer a confirmation email to the order
- Sending to the customen an email to the new order comment 
- The Form "add a buisness" to send a request 
etc

3. Demo (frontend):
https://multi.ptzhost.net/

4. Installation:
- Install laravel and extensions (see #1)
- Upload these files to the root folder of laravel
- Make from the root folder of laravel
 "php artisan migrate"
- Register a new user
- Set is_general_admin to 1 in the table "users" for this user

Enjoy!
