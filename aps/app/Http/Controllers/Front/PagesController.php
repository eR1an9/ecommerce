<?php 

namespace App\Http\Controllers\Front;

use Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Gambar;
use DB;


class PagesController extends Controller {

	public function __construct() {

		$this->data['cartItems'] = Cart::content();	
	}

	/**
	 * Display a listing of the resurce.
	 * 
	 * @return Response
	 */
	public function index() {
		// ambil data Product
		$this->data['products'] = \App\Models\Products\Product::orderBy('id', 'DESC')
															->limit(3)->offset(0)->get(); // get() or pageinate() or all()
		$this->data['productsk'] = \App\Models\Products\Product::orderBy('id', 'DESC')
															->limit(3)->offset(3)->get();
		$this->data['featurs'] = \App\Models\Products\Product::orderBy('id', 'DESC')
															->limit(6)->offset(0)->get();

		$this->data['date'] = DB::select('SELECT DAY(created_at) FROM product');
                // dd($this->data['date']);

		$this->data['image'] = Product::with([
                  // 'image' 
                ])
                  ->take(12)->orderBy('created_at', 'asc')
                  ->get();
		return view('aqsha.home')
						->with($this->data);
	}

	public function shop(){
		$Products = \App\Models\Products\Product::paginate(5); // get() or pageinate() or all()
		
		return view('front.shop.products')->with('Products', $Products);
	}


	public function product_detail($id) {
		$this->data['products'] = \App\Models\Products\Product::find($id);
		$this->data['image'] = Product::with([
                  // 'image' 
                ])
                  ->take(12)->orderBy('created_at', 'asc')
                  ->get();
		$this->data['images'] = \App\Models\Products\Gambar::get()->where('id_product', $id);
		$this->data['cartItems'] = Cart::content();
								// dd($this->data['image']->first()->path_full);
		return view('aqsha.product_details', $this->data );
	}

	public function profile() {

		return view('aqsha.profile', $this->data);
	}

	public function about() {

		return view('aqsha.about', $this->data);
	}

}