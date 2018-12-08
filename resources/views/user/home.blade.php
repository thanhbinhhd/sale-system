@extends('user.layout.master')
@section('customCss')
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/lightbox.min.css">
    <!--===============================================================================================-->

@endsection
@section('content')

    <section class="slide1">
        <div class="wrap-slick1">
            <div class="slick1">
                @foreach($slides as $slide)
                <div class="item-slick1 item1-slick1" style="background-image: url({{$slide->link}});">
                    <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                        <h2 class="caption1-slide1 xl-text2 t-center bo14 p-b-6 animated visible-false m-b-22" data-appear="fadeInUp">
                            {{$slide->title}}
                        </h2>

                        {{--<span class="caption2-slide1 m-text1 t-center animated visible-false m-b-33" data-appear="fadeInDown">--}}
							{{--New Collection 2018--}}
						{{--</span>--}}

                        <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
                            <!-- Button -->
                            <a href="/shop" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Our product -->
    <section class="bgwhite p-t-45 p-b-58">
        <div class="container">
            <div class="sec-title p-b-22">
                <h3 class="m-text5 t-center">
                    Our Products
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#best-seller" role="tab">Best Seller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#new" role="tab">New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#hot" role="tab">Hot!</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-35">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                        <div class="row">
                            @foreach($cheaps as $cheap)
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
                                        <img src="{{$cheap->image_path}}" alt="IMG-PRODUCT">

                                        <div class="block2-overlay trans-0-4">
                                            <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                                                <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                                <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                            </a>

                                            <div class="block2-btn-addcart w-size1 trans-0-4">
                                                <!-- Button -->
                                                <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 product-add-button" id="product-{{$cheap->id}}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="/product/{{$cheap->id}}}" class="block2-name dis-block s-text3 p-b-5">
                                            {{$cheap->name}}
                                        </a>

                                        <span class="block2-price m-text6 p-r-5 product-price">
											{{$cheap->price}}
										</span>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                        </div>
                    </div>

                    <!-- - -->
                    <div class="tab-pane fade" id="new" role="tabpanel">
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
                                        <img src="{{$product->image_path}}" alt="IMG-PRODUCT-NO">
                                        <div class="block2-overlay trans-0-4">
                                            <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                                                <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                                <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                            </a>

                                            <div class="block2-btn-addcart w-size1 trans-0-4">
                                                <!-- Button -->
                                                <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 product-add-button" id="product-{{$product->id}}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="/product/{{$product->id}}" class="block2-name dis-block s-text3 p-b-5">
                                            {{$product->name}}
                                        </a>
                                        <span class="block2-price m-text6 p-r-5 product-price">
											{{$product->price}}
										</span>
                                        {{--<span class="block2-oldprice m-text7 p-r-5">--}}
											{{--$29.50--}}
										{{--</span>--}}

                                        {{--<span class="block2-newprice m-text8 p-r-5">--}}
											{{--$15.90--}}
										{{--</span>--}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!--  -->
                    <div class="tab-pane fade" id="hot" role="tabpanel">
                        <div class="row">
                            @foreach($views as $view)
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                                <!-- Block2 -->
                                <div class="block2">
                                    <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
                                        <img src="{{$view->image_path}}" alt="IMG-PRODUCT">

                                        <div class="block2-overlay trans-0-4">
                                            <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                                                <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                                <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                            </a>

                                            <div class="block2-btn-addcart w-size1 trans-0-4">
                                                <!-- Button -->
                                                <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 product-add-button" id="product-{{$view->id}}">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block2-txt p-t-20">
                                        <a href="/product/{{$view->id}}" class="block2-name dis-block s-text3 p-b-5">
                                            Herschel supply co 25l
                                        </a>

                                        <span class="block2-price m-text6 p-r-5 product-price">
											{{$view->price}}
										</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Blog -->
    <section class="blog bgwhite p-t-94 p-b-65">
        <div class="container">
            <div class="sec-title p-b-52">
                <h3 class="m-text5 t-center">
                    Our Blog
                </h3>
            </div>

            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-sm-10 col-md-4 p-b-30 m-l-r-auto">
                    <!-- Block3 -->
                    <div class="block3">
                        <a href="/blog/{{$blog->id}}" class="block3-img dis-block hov-img-zoom">
                            <img src="{{$blog->image}}" alt="IMG-BLOG">
                        </a>

                        <div class="block3-txt p-t-14">
                            <h4 class="p-b-7">
                                <a href="/blog/{{$blog->id}}" class="m-text11">
                                    {{$blog->title}}
                                </a>
                            </h4>

                            <span class="s-text6">By</span> <span class="s-text7">{{$blog->author}}</span>
                            <span class="s-text6">on</span> <span class="s-text7">{{$blog->create_at}}</span>

                            <p class="s-text8 p-t-16">
                                {{$blog->description}}
                            </p>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </section>


    <!-- Shipping -->
    <section class="shipping bgwhite p-t-62 p-b-46">
        <div class="flex-w p-l-15 p-r-15">
            <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
                <h4 class="m-text12 t-center">
                    Free Delivery Worldwide
                </h4>

                <a href="#" class="s-text11 t-center">
                    Click here for more info
                </a>
            </div>

            <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 bo2 respon2">
                <h4 class="m-text12 t-center">
                    30 Days Return
                </h4>

                <span class="s-text11 t-center">
					Simply return it within 30 days for an exchange.
				</span>
            </div>

            <div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
                <h4 class="m-text12 t-center">
                    Store Opening
                </h4>

                <span class="s-text11 t-center">
					Shop open from Monday to Sunday
				</span>
            </div>
        </div>
    </section>
    @endsection

@section('customJs')
    <script type="text/javascript">
        $(".selection-1").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect1')
        });
    </script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/slick.min.js"></script>
    <script type="text/javascript" src="/user/js/slick-custom.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/lightbox.min.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.block2-btn-addcart').each(function(){
            var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
            $(this).on('click', function(){
                swal(nameProduct, "is added to cart !", "success");
            });
        });

        $('.block2-btn-addwishlist').each(function(){
            var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
            $(this).on('click', function(){
                swal(nameProduct, "is added to wishlist !", "success");
            });
        });

        $('.product-price').each((index, item) => {
          $(item)[0].innerText = formatMoney($(item)[0].innerText);
          $(item)[0].innerText += '$'
        })

        function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
          try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
          } catch (e) {
            console.log(e)
          }
        }

        $('.product-add-button').on('click', function() {
          let attr_id = $(this).attr('id');
          let id = attr_id.split('-')[1];
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
              quantity: 1,
            },
            success: function (response) {
              console.log('res: ', response);
              if (!response.error) {
              }
              else {
                toastr.warning('Something error when uploading!');
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {

            }
          });

        })

    </script>

    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/parallax100.js"></script>
    <script type="text/javascript">
        $('.parallax100').parallax100();
    </script>
    @endsection
