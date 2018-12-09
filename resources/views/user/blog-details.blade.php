@extends('user.layout.master')
@section('customCss')
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    <style>
        .overflow-hidden {
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <!-- breadcrumb -->
	<div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
		<a href="/" class="s-text16">
			Home
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="/blog" class="s-text16">
			Blog
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<span class="s-text17">
            {{$blog->title}}
		</span>
	</div>

    <!-- content page -->
    <section class="bgwhite p-t-60">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-75 overflow-hidden">
                    <div class="p-r-50 p-r-0-lg">
                        <!-- item blog -->
                        <div class="item-blog p-b-80">
                            <a href="#" class="item-blog-img pos-relative dis-block hov-img-zoom">
                                <img src="{{$blog->thumbnail_path}}" alt="IMG-BLOG">

                                <span class="item-blog-date dis-block flex-c-m pos1 size17 bg4 s-text1">
                                    @php ($createdTime = date('d M, Y', strtotime($blog->created_at)))
                                    {{$createdTime}}
								</span>
                            </a>

                            <div class="item-blog-txt p-t-33">
                                <h4 class="p-b-11">
                                    <a href="#" class="m-text24">
                                        {{$blog->title}}
                                    </a>
                                </h4>

                                <div class="s-text8 flex-w flex-m p-b-21">
									<span>
										By {{$blog->author}}
										<span class="m-l-3 m-r-6">|</span>
									</span>

                                    <span>
                                        @if ($blog->category)
                                            {{$blog->category->name}}
                                            <span class="m-l-3 m-r-6">|</span>
                                        @endif
									</span>

                                    <span>
                                        @foreach(\App\Model\Tag::all() as $tag)
                                            @if (in_array($tag->id, array_column($blog->taggables()->get()->toArray(), 'tag_id'))) 
                                                #{{$tag->name}}
                                            @endif
                                        @endforeach
									</span>
                                </div>

                                <p class="p-b-12">
                                    {{$blog->description}}
                                </p>

                                <p class="p-b-25">
                                    {!! $blog->content !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-75">
                    <div class="rightbar">
                        <!-- Search -->
                        <div class="pos-relative bo11 of-hidden">
                            <input class="s-text7 size16 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search">

                            <button class="flex-c-m size5 ab-r-m color1 color0-hov trans-0-4">
                                <i class="fs-13 fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>

                        <!-- Categories -->
                        <h4 class="m-text23 p-t-56 p-b-34">
                            Categories
                        </h4>

                        <ul>
                            @foreach($categories as $category)
                            <li class="p-t-6 p-b-8 bo7">
                                <a href="#" class="s-text13 p-t-5 p-b-5">
                                    {{$category->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Featured Products -->
                        <h4 class="m-text23 p-t-65 p-b-34">
                            Featured Products
                        </h4>

                        <ul class="bgwhite">
                            @foreach($products as $product)
                            <li class="flex-w p-b-20">
                                <a href="/product/{{$product->id}}" class="dis-block wrap-pic-w w-size22 m-r-20 trans-0-4 hov4">
                                    <img src="{{$product->image_path}}" alt="IMG-PRODUCT">
                                </a>

                                <div class="w-size23 p-t-5">
                                    <a href="/product/{{$product->id}}" class="s-text20">
                                        {{$product->name}}
                                    </a>

                                    <span class="dis-block s-text17 p-t-6">
                                        ${{$product->price}}
									</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Tags -->
                        <h4 class="m-text23 p-t-50 p-b-25">
                            Tags
                        </h4>

                        <div class="wrap-tags flex-w">
                            @foreach($tags as $tag)
                            <a href="#" class="tag-item">
                                {{$tag->name}}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
