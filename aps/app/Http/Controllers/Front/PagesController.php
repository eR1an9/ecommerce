<?php 

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Products\Product;
use App\Models\Products\Gambar;
use App\Models\Users;
use App\User;
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
		$this->data['Products'] = \App\Models\Products\Product::paginate(5); // get() or pageinate() or all()
		
		return view('aqsha.shop')->with($this->data);
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
		$userid = Auth::user()->id;
    $this->data['user'] = User::find($userid);

		return view('aqsha.profile', $this->data);
	}

	public function profile_update(Request $request, $id) {

		// dd($request->phone);
		DB::table('users')
            ->where('id', $id)
            ->update([
            	'name' => $request->name,
            	'email' => $request->email,
            	'phone' => $request->phone,
            	]);
		return back();
	}

	public function about() {

		return view('aqsha.about', $this->data);
	}

}