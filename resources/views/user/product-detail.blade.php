@extends('user.layout.master')
@section('customCss')
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/lightbox.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/fixed-size.css"/>
@endsection
@section('content')
    <div class="container bgwhite p-t-35 p-b-80">
        <div class="flex-w flex-sb">
            <div class="w-size13 p-t-30 respon5">
                <div class="wrap-slick3 flex-sb flex-w">
                    <div class="wrap-slick3-dots"></div>

                    <div class="slick3">
                        <div class="item-slick3" data-thumb="images/thumb-item-01.jpg">
                            <div class="wrap-pic-w">
                                <img src="{{$product->image_path}}" alt="IMG-PRODUCT">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-size14 p-t-30 respon5">
                <h4 class="product-detail-name m-text16 p-b-13">
                    {{$product->name}}
                </h4>

                @if($product->discount() > 0)
                    <span class="block2-oldprice m-text17 p-r-5 product-price">
                        {{$product->price}}$
                    </span>

                    <span class="block2-newprice m-text17 p-r-5 product-price">
                        {{$product->price - $product->price * $product->discount() / 100}}$
                    </span>
                @else
                    <span class="block2-price m-text17 p-r-5 product-price">
                        {{$product->price}}$
                    </span>
                @endif

                <p class="s-text8 p-t-10">
                    {{$product->description}}
                </p>

                <!--  -->
                <div class="p-t-33 p-b-60">

                    <div class="flex-r-m flex-w p-t-10">
                        <div class="w-size16 flex-m flex-w">
                            <div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
                                <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                                    <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                                </button>

                                <input class="size8 m-text18 t-center num-product" type="number" name="num-product" value="1" id="numberProduct">

                                <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                                    <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
                                <!-- Button -->
                                <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 product-add-button" id="shop-{{$product->id}}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-b-45">
                    <span class="s-text8 m-r-35">SKU: MUG-01</span>
                    <span class="s-text8">Categories: Mug, Design</span>
                </div>

                <!--  -->
                <div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                        Description
                        <i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
                        <i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

                    <div class="dropdown-content dis-none p-t-15 p-b-23">
                        <p class="s-text8">
                            {{$product->description}}
                        </p>
                    </div>
                </div>

                <div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
                    <h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
                        Additional information
                        <i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
                        <i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
                    </h5>

                    <div class="dropdown-content dis-none p-t-15 p-b-23">
                        <p class="s-text8">
                            Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('customJs')
    <script type="text/javascript">
      $('.product-add-button').on('click', function() {
        let attr_id = $(this).attr('id');
        let id = attr_id.split('-')[1];
        console.log($('#numberProduct'));
        let quantity = $('#numberProduct').val();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
        });
        $.ajax({
          type: 'POST',
          url: '/add-cart',
          async: true,
          data: {
            product_id: id,
            quantity: quantity,
          },
          success: function (response) {
            console.log('res: ', response);
            if (!response.error) {
              toastr.success('Add to cart success!');
            }
            else {
              toastr.warning('Something error when uploading!');
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {

          }
        });
      });
    </script>
    @endsection
