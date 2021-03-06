@extends('backend.layouts.master')
@section('title','Pesanan')
@section('js')
  <script>    
    // membuat function tampilkan_nama
    function tampilkan_nama(){
      var nilai_form=document.getElementById("product").value;
      document.getElementById("hasil").value = nilai_form;
      document.getElementById("link").setAttribute("href", "{{ url('cart/') }}/addItem/" + nilai_form,);
      // document.getElementById("hasil").innerHTML = "<h3>Nama Saya Adalah Andi</h3>";
    }
    function tampilkan_id(){
      var alamat=document.getElementById('get_id').value;
      document.getElementById('id_tampil').value = alamat;
    }

    $(function () {
    var theText = $("#theText");
    // var theText = theText + 10;
    var theOutputText = $("#theOutputText");
    var theOutputKeyPress = $("#theOutputKeyPress");
    var theOutputKeyDown = $("#theOutputKeyDown");
    var theOutputKeyUp = $("#theOutputKeyUp");
    var theOutputFocusOut = $("#theOutputFocusOut");

    theText.keydown(function (event) {
        keyReport(event, theOutputKeyDown);
    });

    theText.keypress(function (event) {
        keyReport(event, theOutputKeyPress);
    });

    theText.keyup(function (event) {
        keyReport(event, theOutputKeyUp);
    });

    function keyReport(event, output) {
        // catch enter key = submit (Safari on iPhone=10)
        if (event.which == 10 || event.which == 13) {
            event.preventDefault();
        }
        // show field content
        theOutputText.text(parseInt(theText.val())+{{ str_replace(',00', '', str_replace('.', '', Cart::subtotal())) }});
    }
});
    
  </script>
@endsection
@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Pesanan
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('/admin/pesanan') }}">Pesanan</a></li>
      <li class="active">Tambah Pesanan</li>
    </ol>
  </section>

  <!-- Main Content -->
  <section class="content">
  {{-- <form method="post" action="{{ url('/admin/pesanan/') }}/{{ $po }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
  {!! Form::open(array('route' => ['pesanan.update', $po],'method'=>'PUT')) !!}
    {{-- {!! Form::model(['method'=>'PATCH' ,'route' => ['pesanan.update', $po]]) !!} --}}
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">
        {{ $title }}
        </h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

    <!-- /.box-header -->
      <div class="box-body" style="display: block;">
        <div class="row">
          <div class="col-md-3">
            <!-- box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><span class="fa fa-group"></span> Pelanggan</h3>
              </div>
              <!-- box-body -->
              <div class="box-body">
                {{-- row 1 col 3 --}}
                <div class="form-group">
                  <label>Pelanggan</label> 
                  <select class="form-control" id="get_id" onchange="tampilkan_id()" disabled="">
                    <option value="">{{ $fullname }}</option>
                  </select>
                </div>
                {{-- /.form-group --}}
                <div class="form-group">
                  <label>No Hp/Phone</label>
                  <input class="form-control" type="text" value="{{ $phone }}" disabled>
                </div>
                <!-- /.form-group -->
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" type="text" value="{{ $email }}" disabled>
                </div>
                
                <div class="form-group">
                  <label>Kota</label>
                  <input class="form-control" type="text" value="{{ $kota }}" disabled>
                </div>
                <div class="form-group">
                  <label>Kode Pos</label>
                  <input class="form-control" type="text" value="{{ $postcode }}" disabled>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" disabled>{{ $alamat }}</textarea>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Tanggal</label>
                  <input class="form-control" type="text" value="<?= date('Y/m/d'); ?>" disabled>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- ./box-body -->
            </div>
            <!-- ./box -->

            <div class="box box-primary">
              <div class="box-body">
              <label for="">Catatan</label>
                <textarea name="notes" class="form-control">{{ $notes }}</textarea>
              </div>
            </div>
            
          </div>
          <!-- /.col-md-3 -->
          <div class="col-md-9">
            <!-- box -->
            <div class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Produk</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body" style="display: block;">

                <div class="row"><b>
                  <div class="col-md-1"> # </div>
                  <div class="col-md-4"> Nama Produk </div>
                  <div class="col-md-2"> Harga </div>
                  <div class="col-md-2"> Jumlah </div>
                  <div class="col-md-2"> Total </div>
                  <div class="col-md-1"></div></b>
                </div>
                <hr>
                @foreach ($orders as $order)
                  <div class="row">
                    <div class="col-md-1"> {{ ++$i }} </div>
                    <div class="col-md-4"> {{ $order->name }} </div>
                    <div class="col-md-2"> Rp {{ number_format($order->product_price, '2', ',', '.') }} </div>
                    <div class="col-md-2"> {{ $order->qty }} </div>
                    <div class="col-md-2"> Rp {{ number_format($order->total, '2', ',', '.') }} </div>
                    <div class="col-md-1"></div>
                  </div>
                @endforeach <hr> 
                <div class="row">
                  <div class="col-md-9"> Sub Total </div>
                  <div class="col-md-3"> Rp {{ $subtotal }} </div>
                </div><hr>
                <div class="row">
                  {{-- <div class="col-md-3">
                    <div class="form-group">
                      <label>Discount Type</label>
                      <select class="form-control" name="discount" id="">
                        <option value="">Rp</option>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div> --}}
                  <!-- /.col-md-3 -->
                  {{-- <div class="col-md-3">
                    <div class="form-group">
                      <label>Discount Nominal</label>
                      {{ Form::text('discount_normal', null, array('class' => 'form-control')) }}
                    </div>
                    <!-- /.form-group -->
                  </div> --}}
                  <!-- /.col-md-3 -->
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Ekspedisi</label>
                      <select class="form-control" name="ekspedisi" id="">
                      <option value="">Pilih Ekspedisi</option>
                      @foreach ($ekspedisi as $ekspe)
                        <option value="{{ $ekspe->name }}" {{ ($ekspe->name==$eksped) ? 'selected' : '' }}>{{ $ekspe->name }}</option>
                      @endforeach
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col-md-3 -->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Paket</label>
                      <select class="form-control" name="paket" id="">
                        <option value="">Pilih Paket</option>
                        <option value="SS" {{ ($paket=='SS') ? 'selected' : '' }}>SS</option>
                        <option value="YES" {{ ($paket=='YES') ? 'selected' : '' }}>YES</option>
                        <option value="REG" {{ ($paket=='REG') ? 'selected' : '' }}>REG</option>
                        <option value="OKE" {{ ($paket=='OKE') ? 'selected' : '' }}>OKE</option>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col-md-3 -->
                  <div class="col-md-2">
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label>Berat Kg</label>
                      <input class="form-control" type="text" name="berat" value="{{ ($berat=='') ? 0 : $berat }}">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col-md-3 -->
                  <div class="col-md-3">
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label>Biaya Kirim</label>
                      <input id="theText" class="form-control" type="text" name="ongkir" size="10" value="{{ ($ongkir) }}" />
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col-md-3 -->
                </div>
                <!-- /.row -->
                <hr>
                <div class="form-group">
                  <h4>Total Bayar</h4>
                  <h3>Rp {{ number_format(str_replace(',00', '', str_replace('.', '', $subtotal))+$ongkir, 0,',','.') }}</h3>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box box-warning box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Pembayaran</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Status Bayar</label>
                      <select class="form-control" name="pembayaran" id="">
                      {{-- @foreach ($orders as $order) --}}
                        <option value="">-Pilih Status-</option>
                        <option value="batalbayar">Batal dibayar</option>
                        <option value="belumbayar" {{ ($pembayaran == 'belumbayar') ? 'selected' : ''}}>Belum Bayar</option>
                        <option value="sudahbayar" {{ ($pembayaran == 'sudahbayar') ? 'selected' : ''}}>Sudah Dibayar</option>
                      {{-- @endforeach --}}
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div> 

                </div>
              </div>
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col-md-9 -->
        </div>
        <!-- /.row -->
      </div>

      <div class="box-footer">
        <a href="{{ url('/admin/pesanan') }}" class="btn btn-danger"><span class="fa fa-arrow-left"></span> Kembali</a>
        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-save"></span> Simpan</button>
      </div>
    </div>
    </form>
    {{-- {!! Form::close() !!} --}}
  </section>
  <!-- /.content -->

  <!-- Page script -->

@endsection
