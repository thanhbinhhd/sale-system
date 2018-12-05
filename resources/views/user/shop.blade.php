@extends('user.layout.master')
@section('customCss')
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/user/css/nouislider.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .quantity{
            color: white;
            text-align: center;
            margin-bottom: 50px;
        }
        .fix-height{
            height: 360px;
            overflow: hidden;
        }
    </style>
    @endsection
@section('content')
    <section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(/user/images/heading-pages-02.jpg);">
        <h2 class="l-text2 t-center">
            Women
        </h2>
        <p class="m-text13 t-center">
            New Arrivals Women Collection 2018
        </p>
    </section>


    <!-- Content page -->
    <section class="bgwhite p-t-55 p-b-65">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                    <div   class="leftbar p-r-20 p-r-0-sm">
                        <!--  -->
                        <form action="{{route('filter', ['category' => $categoryName])}}" method="get" >
                        <h4 class="m-text14 p-b-7">
                            Categories
                        </h4>
                        <div class="pre-scrollable">
                        <ul class="p-b-54">
                            <li class="p-t-4">
                                <a href="/shop/All" class="s-text13 active1" style="font-size: x-large;">
                                    All
                                </a>
                            </li>
                            @foreach (\App\Model\Category::all() as $category)
                            <li class="p-t-4">
                                <a href="/shop/{{$category->name}}" @if ($category->name == $categoryName)style="color: #e65540;"@endif class="s-text13 active1">
                                    {{$category->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        </div>
                        <!--  -->
                        <h4 class="m-text14 p-b-32">
                            Filters
                        </h4>
                        <div class="search-product pos-relative bo4 of-hidden">
                            <input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search Products...">

                            <button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
                                <i class="fs-12 fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="filter-price p-t-22 p-b-50 bo3">
                            <div class="m-text15 p-b-17">
                                Tag
                            </div>
                            <div>
                                <select class="form-control" multiple id="inputTag" name="tag[]">
                                    @foreach(\App\Model\Tag::all() as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="filter-color p-t-22 p-b-50 bo3">
                            <div class="m-text15 p-b-12">
                                Color
                            </div>
                            <ul class="flex-w">
                                @foreach(range(1,7) as $i)
                                <li class="m-r-10">
                                    <input value="{{$i}}" class="checkbox-color-filter" id="color-filter{{$i}}" type="checkbox" name="color[]">
                                    <label class="color-filter color-filter{{$i}}" for="color-filter{{$i}}"></label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="filter-price p-t-22 p-b-50 bo3">
                            <div class="m-text15 p-b-17">
                                Price
                            </div>

                            <div class="wra-filter-bar">
                                <div id="filter-bar"></div>
                            </div>

                            <div class="flex-sb-m flex-w p-t-16">
                                <div class="w-size11">
                                    <!-- Button -->
                                    <button type="submit" class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4">
                                        Filter
                                    </button>
                                </div>
                                <input type="hidden" id="price-min" name="price-min">
                                <input type="hidden" id="price-max" name="price-max">
                                <div class="s-text3 p-t-10 p-b-10">
                                    Range: $<span id="value-lower">610</span> - $<span id="value-upper">980</span>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
                    <!--  -->
                    <div class="flex-sb-m flex-w p-b-35">
                        <div class="flex-w">
                            <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                <select id="sle1" class="selection-2" name="sorting">
                                    <option value="default" >Default Sorting</option>
                                    <option value="popular">Popularity</option>
                                    <option value="asc">Price: low to high</option>
                                    <option value="desc">Price: high to low</option>
                                </select>
                            </div>

                            <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                <select id="sel2" class="selection-2" name="sorting">
                                    <option>Price</option>
                                    <option value="price-min=0&price-max=50">$0.00 - $50.00</option>
                                    <option value="price-min=50&price-max=100">$50.00 - $100.00</option>
                                    <option value="price-min=100&price-max=150">$100.00 - $150.00</option>
                                    <option value="price-min=150&price-max=200">$150.00 - $200.00</option>
                                    <option value="price-min=200">$200.00+</option>

                                </select>
                            </div>
                        </div>

                        <span class="s-text8 p-t-5 p-b-5">
							@if($products != null) Showing {{$products->firstItem()}}–{{$products->lastItem()}} of {{$products->total()}} results @endif
						</span>
                    </div>

                    <!-- Product -->
                    <div class="row">
                        @if ($products == null or $products->isEmpty())
                            <h2>No product in this category</h2>
                        @else
                        @foreach($products as $product)
                        <div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew fix-height">
                                    <img src="{{$product->image_path}}" alt="IMG-PRODUCT">

                                    <div class="block2-overlay trans-0-4">
                                        <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                                            <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                            <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                        </a>
                                        <div class="block2-btn-addcart w-size1 trans-0-4">
                                            <p class="quantity">@if ($product->quantity > 0) Quantity: {{$product->quantity}} @else Out of stock @endif</p>
                                            <!-- Button -->
                                            <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="block2-txt p-t-20">
                                    <a href="product/{{$product->name}}" class="block2-name dis-block s-text3 p-b-5">
                                        {{$product->name}}
                                    </a>

                                    <span class="block2-price m-text6 p-r-5">
										${{$product->price}}
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
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="pagination flex-m flex-w p-t-26">
                        @if($products != null){{ $products->appends(Illuminate\Support\Facades\Input::except('page'))->links()}}@endif
                        {{--<a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>--}}
                        {{--<a href="#" class="item-pagination flex-c-m trans-0-4">2</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#inputTag").select2();
        });
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
    </script>

    <!--===============================================================================================-->
    <script type="text/javascript" src="/user/js/nouislider.min.js"></script>
    <script type="text/javascript">
        /*[ No ui ]
        ===========================================================*/
        var filterBar = document.getElementById('filter-bar');

        noUiSlider.create(filterBar, {
            start: [ 0, 200000 ],
            connect: true,
            range: {
                'min': 0,
                'max': 200000
            }
        });

        var skipValues = [
            document.getElementById('value-lower'),
            document.getElementById('value-upper')
        ];
        var inputValues = [
            $('#price-min'),
            $('#price-max'),
        ];
        filterBar.noUiSlider.on('update', function( values, handle ) {
            skipValues[handle].innerHTML = Math.round(values[handle]) ;
            inputValues[handle].val(Math.round(values[handle]));
        });
        $('#sle1').on('change', function () {
            var url = window.location.href;
            if(url.indexOf('filter?') === -1)
                url = '/shop/{{$categoryName}}/filter?order=' + $(this).val();
            else if(document.location.href.indexOf('order=') !== -1)
                url = url.substring(0, document.location.href.indexOf('order=')) + 'order=' +  $(this).val();
            else
                url += '&order=' + $(this).val();
            location.href = url;
        });

        $('#sel2').on('change', function () {
            var url = window.location.href;
            if(url.indexOf('filter?') === -1)
                url = '/shop/{{$categoryName}}/filter?' + $(this).val();
            else if(document.location.href.indexOf('price-min=') !== -1)
                url = url.substring(0, document.location.href.indexOf('price-min=')) +  $(this).val();
            else
                url += $(this).val();
            location.href = url;
        });
    </script>
@endsection
