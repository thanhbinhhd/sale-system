@extends('user.layout.master')
@section('customCss')
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    @endsection
@section('content')

    <!-- Title Page -->
    <section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(/user/images/heading-pages-01.jpg);">
        <h2 class="l-text2 t-center">
            Cart
        </h2>
    </section>

    <!-- Cart -->
    <section class="cart bgwhite p-t-70 p-b-100" id="app">
        <div class="container">
            <!-- Cart item -->
            <div class="container-table-cart pos-relative">
                <div class="wrap-table-shopping-cart bgwhite">
                    <table class="table-shopping-cart">
                        <tr class="table-head">
                            <th class="column-1"></th>
                            <th class="column-2">Product</th>
                            <th class="column-3">Price</th>
                            <th class="column-4 p-l-70">Quantity</th>
                            <th class="column-5">Total</th>
                        </tr>

                        <tr class="table-row" v-for="(item, index) in items" :key="index">
                            <td class="column-1">
                                <div class="cart-img-product b-rad-4 o-f-hidden">
                                    <img :src="item.attributes.image_path" alt="IMG-PRODUCT">
                                </div>
                            </td>
                            <td class="column-2">@{{item.name}}</td>
                            <td class="column-3">@{{item.price}}$</td>
                            <td class="column-4">
                                <div class="flex-w bo5 of-hidden w-size17">
                                    <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2" @click="minusQty(item)" :disable="item.quantity === 1">
                                        <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                                    </button>

                                    <input class="size8 m-text18 t-center num-product" type="number" name="num-product1" v-bind:value="item.quantity">

                                    <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2" @click="plusQty(item)">
                                        <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="column-5">@{{item.price * item.quantity}}$</td>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
                <div class="flex-w flex-m w-full-sm">
                    <div class="size11 bo4 m-r-10">
                        <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
                    </div>

                    <div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
                        <!-- Button -->
                        <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
                            Apply coupon
                        </button>
                    </div>
                </div>

                <div class="size10 trans-0-4 m-t-10 m-b-10">
                    <!-- Button -->
                    <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
                        Update Cart
                    </button>
                </div>
            </div>

            <!-- Total -->
            <div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
                <h5 class="m-text20 p-b-24">
                    Cart Totals
                </h5>

                <!--  -->
                <div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

                    <span class="m-text21 w-size20 w-full-sm">
						@{{ details.sub_total }}$
					</span>
                </div>

                <!--  -->
                <div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Shipping:
					</span>

                    <div class="w-size20 w-full-sm">
                        <p class="s-text8 p-b-23">
                            There are no shipping methods available. Please double check your address, or contact us if you need any help.
                        </p>

                        <span class="s-text19">
							Calculate Shipping
						</span>

                        <div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-t-8 m-b-12">
                            <select class="selection-2" name="country">
                                <option>Select a country...</option>
                                <option>US</option>
                                <option>UK</option>
                                <option>Japan</option>
                            </select>
                        </div>

                        <div class="size13 bo4 m-b-12">
                            <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="state" placeholder="State /  country">
                        </div>

                        <div class="size13 bo4 m-b-22">
                            <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="postcode" placeholder="Postcode / Zip">
                        </div>

                        <div class="size14 trans-0-4 m-b-10">
                            <!-- Button -->
                            <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
                                Update Totals
                            </button>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

                    <span class="m-text21 w-size20 w-full-sm">
						@{{ details.total }}$
					</span>
                </div>

                <div class="size15 trans-0-4">
                    <!-- Button -->
                    <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script src="https://unpkg.com/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/vue.resource/1.3.1/vue-resource.min.js"></script>

    <script type="text/javascript">
        $(".selection-1").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect1')
        });

        $(".selection-2").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect2')
        });

        (function($) {

          let _token = '<?php echo csrf_token() ?>';

          $(document).ready(function() {

            let app = new Vue({
              el: '#app',
              data() {
                return {
                  details: {
                    sub_total: 0,
                    total: 0,
                    total_quantity: 0
                  },
                  itemCount: 0,
                  items: [],
                  item: {
                    id: '',
                    name: '',
                    price: 0.00,
                    qty: 1
                  },
                  cartCondition: {
                    name: '',
                    type: '',
                    target: '',
                    value: '',
                    attributes: {
                      description: 'Value Added Tax'
                    }
                  },

                  options: {
                    target: [
                      {label: 'Apply to SubTotal', key: 'subtotal'},
                      {label: 'Apply to Total', key: 'total'}
                    ]
                  }
                }
              },

              watch: {

              },

              mounted:function(){
                this.loadItems();
              },
              methods: {
                sum(a,b) {
                  return (b.quantity * b.price) + a;
                },

                addItem: function() {

                  let _this = this;

                  axios.post('/cart',{
                    _token:_token,
                    id:_this.item.id,
                    name:_this.item.name,
                    price:_this.item.price,
                    qty:_this.item.qty
                  }).then(function(success) {
                    _this.loadItems();
                  }, function(error) {
                    console.log(error);
                  });
                },
                addCartCondition: function() {

                  let _this = this;

                  axios.post('/cart/conditions',{
                    _token:_token,
                    name:_this.cartCondition.name,
                    type:_this.cartCondition.type,
                    target:_this.cartCondition.target,
                    value:_this.cartCondition.value,
                  }).then(function(success) {
                    _this.loadItems();
                  }, function(error) {
                    console.log(error);
                  });
                },
                clearCartCondition: function() {

                  let _this = this;

                  axios.delete('/cart/conditions?_token=' + _token).then(function(success) {
                    _this.loadItems();
                  }, function(error) {
                    console.log(error);
                  });
                },
                removeItem: function(id) {

                  let _this = this;

                  axios.delete('/cart/'+id,{
                    params: {
                      _token:_token
                    }
                  }).then(function(success) {
                    _this.loadItems();
                  }, function(error) {
                    console.log(error);
                  });
                },
                loadItems: function() {

                  let _this = this;

                  axios.get('/cart',{
                    params: {
                      limit:10
                    }, headers: {
                      'X-Requested-With': 'XMLHttpRequest',
                    }
                  }).then(function(success) {
                    console.log(success);
                    _this.items = success.data.data;
                    _this.itemCount = success.data.data.length;
                    _this.loadCartDetails();
                  }, function(error) {
                    console.log(error);
                  });
                },
                loadCartDetails() {

                  let _this = this;

                  axios.get('/cart/details').then(function(success) {
                    _this.details = success.data.data;
                  }, function(error) {
                    console.log(error);
                  });
                },

                minusQty(item) {
                  if(item.quantity > 1){
                    item.quantity--;
                    this.details.sub_total = this.details.total = this.items.reduce(this.sum, 0);
                    this.details.total_quantity --;
                  }
                },

                plusQty(item) {
                  item.quantity++;
                  this.details.sub_total = this.details.total = this.items.reduce(this.sum, 0);
                  this.details.total_quantity ++;
                }
              }
            });

          });

        })(jQuery);
    </script>
@endsection
