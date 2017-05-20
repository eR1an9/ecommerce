<?php

namespace App\Http\Requests\backend\Products;

use App\Http\Requests\Request;

class ProductRequest extends Request
{

  function authorize()
  {
    return \Auth::check();
    Auth::user()->can('roduct-create');
    // return Entrust::can(['product-create', 'product-update'], true);
    // return Auth::user()->can(['product-create', 'product-update', true]);
  }

  public function rules(){
    return [
      'id_category' => 'required',
      'product_name' => 'required|unique:product,product_name,' . Request::get('id'),
      'product_price' => 'min:0',
      'image[]' => 'image',
      'value[]' => 'required_with:name[]'
    ];
  }

  public function messages() {
    return [
      'id_category.required' => 'Category diperlukan',
      'product_name.required' => 'Nama Product Diperlukan',
      'product_name.unique' => 'Nama product sudah dipakai',
      'image[].image' => 'File harus berbentuk gambar (jpg,jpeg,png,bmp)',
      'value.required_with' => 'Nama attribute diperlukan',
    ];
  }
}
