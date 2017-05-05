<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


Route::get('/test', 'TestController@index');

Route::get('/comments', 'TestController@comments');
Route::get('/api/comments', 'TestController@getComments');

Route::get('/goods', 'GoodController@index');
Route::get('/api/goods', 'GoodController@get');
Route::post('/api/goods/add', 'GoodController@store');
Route::get('/orders/{good_id}', 'GoodController@orders');


Route::get('/tree', 'GoodController@startTree');


//дерево - второй способ
Route::get('/tree2', 'GoodController@startTree2');
Route::get('/api/goods2', 'GoodController@get2');
Route::get('/api/orders2/{good_id}', 'GoodController@orders2');
Route::get('/api/payment/{order_id}', 'GoodController@payment');
//дерево - вывод объектов
Route::get('/api/good/{good_id}', 'GoodController@view');
Route::get('/api/order/{order_id}', 'GoodController@orderView');
Route::get('/api/payments/{payment_id}', 'PaymentController@view');

//datagreed
Route::get('/payments', 'PaymentController@index');
Route::get('/payments-data', 'PaymentController@getData');
Route::post('/payments/delete', 'PaymentController@delete');


//datagreed ajax paginate
Route::get('/payments-paginate', 'PaymentController@indexPaginate');
Route::get('/payments-data-paginate', 'PaymentController@getDataPaginate');

//пример сокета
route::get('/socket', 'SocketController@index');
route::get('/message', 'SocketController@message');
route::post('/sendmessage', 'SocketController@sendMessage');

