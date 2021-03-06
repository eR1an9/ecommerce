<?php

Auth::routes();
// view form login ada di vendor AuthenticatesUsers.com
// Route::get('/home', [
//   'as' => 'home.index', 'uses'=>  'HomeController@index']);

// Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'admin']], function() {
//   Route::get('/', function() {
//     return view('backend.index');
//   });
// });
// Route::get('/backend', 'HomeController@index');

// Panggil Controller di dalam folder Front dgn 'namespace'
Route::group(['namespace' => 'Front'], function() { 
  Route::get('/', 'PagesController@index');

  // Route::get('/logins', 'PagesController@login');
  Route::get('/product_detail/{id}', 'PagesController@product_detail');
  
  Route::get('cart', 'CartController@index');
  Route::get('cart/addItem/{id}', 'CartController@addItem');
  Route::put('cart/addItemQty/{id}', 'CartController@addItemQty');

  Route::get('/cart/remove/{id}', 'CartController@destroy');
  Route::put('/cart/update/{id}', 'CartController@update');

  Route::get('/checkout', 'CheckoutController@index');
  Route::post('/formvalidate', 'CheckoutController@formvalidate');

  Route::get('/profile', 'PagesController@profile');
  Route::post('/profile_update/{id}', 'PagesController@profile_update');
  Route::post('/konfirmasi', 'PagesController@konfirmasiPembayaran');

  Route::get('/shop', 'PagesController@shop');
  Route::get('/about', 'PagesController@about');

});


// masuk ke link localhost:8000/admin/ dengan prefix
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
  Route::get('/', 'HomeController@index');
  // Controller Setting
  Route::group(['namespace' => 'backend'], function() {

    // Pelanggan & namespace berfungsi untuk masuk ke folder di controller
    Route::group(['namespace' => 'Pelanggan'], function() {
      // Route::resource('/namalink1', 'nama class Container')
      Route::resource('pelanggan', 'PelangganController');
    });

    // baca class Controller Pesanan di folder backend/Penjualan
    Route::group(['namespace' => 'Penjualan'], function() {
      // menampilkan link web:8000/admin/pesanan
      Route::resource('pesanan', 'PesananController');
      Route::resource('pesananFinance', 'PesananFinanceController');
      Route::resource('pesananDikemas', 'PesananDikemasController');
      Route::resource('pesananDikirim', 'PesananDikirimController');
      // Route::put('pesanan/{pesanan}', [
      //   'as' => 'pesanan.updatepenjualan', 'uses' => 'PesananController@updatepenjualan'
      // ]);
      // Route::get('pesanan/{pesanan}/financeDetail', [
      //   'as' => 'pesanan.financeDetail', 'uses' => 'PesananController@financeDetail'
      // ]);
      // Route::patch('pesanan/{pesanan}', [
      //   'as' => 'pesanan.updateFinance', 'uses' => 'PesananController@updateFinance'
      // ]);
    });

    // baca class Controller Kategori, Produk di folder backend/Produk
    Route::group(['namespace' => 'Produk'], function() {
      // produk Kategori
      Route::resource('category', 'CategoryController');

      // produk
      Route::resource('produk', 'ProdukController');
      Route::resource('image', 'ImageController');
    });

    // baca class Controller Realtime di folder backend/stock
    Route::group(['namespace' => 'Stock'], function() {
      // realtime
      Route::get('realtime', [
        'as' => 'realtime.index', 'uses' => 'RealtimeController@index'
      ]);
      Route::get('entry', [
        'as' => 'entry.index', 'uses' => 'EntryController@index'
      ]);
      Route::get('entry/create', [
        'as' => 'entry.create', 'uses' => 'EntryController@create'
      ]);
      Route::get('history', [
        'as' => 'history.index', 'uses' => 'HistoryController@index'
      ]);
    });
    Route::group(['namespace' => 'Finance'], function() {
      Route::resource('finance', 'FinanceController');
    });

    Route::group(['namespace' => 'Laporan'], function() {
      // Laporan Penjualan
      Route::get('penjualan', [
        'as' => 'penjualan.index', 'uses' => 'PenjualanController@index'
      ]);
      // Per barang
      Route::get('perbarang', [
        'as' => 'perbarang.index', 'uses' => 'PerbarangController@index'
      ]);
      // Per barang
      Route::get('perbarang/show', [
        'as' => 'show.index', 'uses' => 'PerbarangController@show'
      ]);
      // Per Pelanggan
      Route::get('perpelanggan', [
        'as' => 'perpelanggan.index', 'uses' => 'PerpelangganController@index'
      ]);
      Route::get('perpelanggan/show', [
        'as' => 'show.index', 'uses' => 'PerpelangganController@show'
      ]);
    });

    // Baca class Controller Payment,kategoriPelanggan,ekspedisi di folder backend/Setting
    Route::group(['namespace' => 'Setting'], function() {
      Route::resource('payment', 'PaymentController');
      // eksepedisi
      Route::resource('ekspedisi', 'EkspedisiController');
      // katpel
      Route::resource('katpel', 'KatpelController');
      Route::resource('about', 'AboutController');
    });

    Route::group(['namespace' => 'Otorisasi'], function() {
      Route::resource('pengguna', 'PenggunaController');
    });
  });
});
