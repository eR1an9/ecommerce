<?php 

namespace App\Http\Controllers\Front;

use Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Gambar;
use DB;


class PagesController extends Controller {

	/**
	 * Display a listing of the resurce.
	 * 
	 * @return Response
	 */
	public function index() {
		// ambil data Product
		$this->data['products'] = \App\Models\Products\Product::orderBy('id', 'DESC')->limit(3)->offset(0)->get(); // get() or pageinate() or all()
		$this->data['productsk'] = \App\Models\Products\Product::orderBy('id', 'DESC')->limit(3)->offset(3)->get();

		// $this->data['featured_products'] = \App\Models\Products\Product::paginate(12);

		$this->data['cartItems'] = Cart::content();
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


	public function product_details($id) {
		$products = \App\Models\Products\Product::find($id);
								// dd($Products);
		return view('front.shop.product_details', compact('products'));
	}

}