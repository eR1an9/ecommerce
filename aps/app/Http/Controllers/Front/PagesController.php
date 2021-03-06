<?php 

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Products\Product;
use App\Models\Products\Gambar;
use App\User;
use DB;


class PagesController extends Controller {

	public function __construct() {	
		$this->data['image'] = Product::with([
                  // 'image' 
                ])
                  ->take(12)->orderBy('created_at', 'asc')
                  ->get();
    $this->data['abouts'] = DB::table('about')->first();
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
		$this->data['cartItems'] = Cart::content();
		$this->data['date'] = DB::select('SELECT DAY(created_at) FROM product');
                // dd($this->data['date']);
		return view('aqsha.home', $this->data);
						// ->with($this->data);
	}

	public function shop(){
		$this->data['products'] = \App\Models\Products\Product::paginate(5); // get() or pageinate() or all()
		$this->data['shops'] = \App\Models\Products\Product::paginate(12);
		$this->data['cartItems'] = Cart::content();
		return view('aqsha.shop')->with($this->data);
	}


	public function product_detail($id) {
		$this->data['products'] = \App\Models\Products\Product::find($id);
		$this->data['images'] = \App\Models\Products\Gambar::get()->where('id_product', $id);
		$this->data['cartItems'] = Cart::content();
								// dd($this->data['image']->first()->path_full);
		return view('aqsha.product_details', $this->data );
	}

	public function profile() {
		if (!Auth::check()) {
			return redirect('login');
		}
		$userid = Auth::user()->id;
		$this->data['orders'] = DB::table('orders_product')
                    ->leftjoin('product', 'product.id', '=', 'orders_product.product_id')
                    ->leftjoin('orders', 'orders.id', '=', 'orders_product.orders_id')
                    ->select('product.product_name', 'product.product_price as harga', 'orders_product.qty','orders.id as po','orders.pembayaran', 'orders.total', 'orders.status' ,'orders.id', 'orders.created_at')
                    ->orderBy('orders.id','DESC')
                ->where('orders.user_id', $userid)
                ->get();
		$this->data['banks'] = DB::table('payments')->get();
    $this->data['user'] = User::find($userid);
    $this->data['cartItems'] = Cart::content();
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

	public function konfirmasiPembayaran(Request $request) {

		if (Auth::check()) {
			$userid = Auth::user()->id;
			DB::table('pembayaran')->insert(
	    	[
	    		'id_order' => $request->id_order,
	    		'id_user' => $userid, 
	    		'pengirim' => $request->pengirim,
	    		'bank' => $request->bank,
	    		'jumlah_transfer' => $request->jumlah_transfer
	    	]
			);
		}
		return back();
	}

	public function about() {
		$this->data['cartItems'] = Cart::content();
		$this->data['about'] = DB::table('about')->first();
		return view('aqsha.about', $this->data);
	}

}