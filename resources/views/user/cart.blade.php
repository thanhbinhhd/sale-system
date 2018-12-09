@extends('user.layout.master')
@section('customCss')
    <link rel="stylesheet" type="text/css" href="/user/css/slick.css">
    <style>
        .border-input {
            border: 1px solid #ced4da !important;
        }
    </style>
    @endsection
@section('content')

    <!-- Title Page -->
    <section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(/user/images/slide-banner.jpg);">
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
                            <th>Action</th>
                        </tr>

                        <tr class="table-row" v-for="(item, index) in items" :key="index">
                            <td class="column-1">
                                <div class="cart-img-product b-rad-4 o-f-hidden">
                                    <img :src="item.attributes.image_path" alt="IMG-PRODUCT">
                                </div>
                            </td>
                            <td class="column-2">@{{item.name}}</td>
                            <td class="column-3">@{{formatMoney(item.price)}}$</td>
                            <td class="column-4">
                                <div class="flex-w bo5 of-hidden w-size17">
                                    <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2" @click="minusQty(item)" :disable="item.quantity === 1">
                                        <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                                    </button>

                                    <input class="size8 m-text18 t-center num-product"
                                           type="number"
                                           name="num-product1"
                                           v-model="item.quantity"
                                           @keyup="checkFinishInput(item)">

                                    <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2" @click="plusQty(item)">
                                        <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="column-5">@{{formatMoney(item.price * item.quantity)}}$</td>
                            <td class="px-3 ">
                                <button class="btn btn-danger" @click="removeItem(item.id)">
                                    Remove
                                </button>
                            </td>
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
						@{{ formatMoney(details.sub_total) }}$
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
                    </div>
                </div>

                <!--  -->
                <div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

                    <span class="m-text21 w-size20 w-full-sm">
						@{{ formatMoney(details.total) }}$
					</span>
                </div>

                <div class="size15 trans-0-4">
                    <!-- Button -->
                    <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4"
                            data-toggle="modal"
                            data-target="#showOrder"
                    >
                        Proceed to Checkout
                    </button>
                </div>
            </div>
            <div class="modal fade" id="showOrder" tabindex="-1" role="dialog" aria-labelledby="showOrder" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-3">
                        <table class="table" style="background: white;">
                            <thead>
                            <tr>
                                <th scope="col" class="col-1">STT</th>
                                <th scope="col" class="col-2">Product Name</th>
                                <th scope="col" class="col-2">Product Image</th>
                                <th scope="col" class="col-1">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items" :key="index">
                                    <td>@{{index + 1}}</td>
                                    <td>@{{item.name}}</td>
                                    <td>
                                        <div class="cart-img-product b-rad-4 o-f-hidden">
                                            <img :src="item.attributes.image_path" alt="IMG-PRODUCT">
                                        </div>
                                    </td>
                                    <td>@{{item.quantity}}</td>
                                    <td>@{{formatMoney(item.price)}}$</td>
                                </tr>

                                <tr>
                                    <th colspan="4">Total</th>
                                    <td style="color: red;font-weight: bold">@{{formatMoney(details.total)}}$</td>
                                </tr>
                                <tr>
                                    <button class="btn btn-primary">
                                        CheckOut
                                    </button>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="address-order">Address:</label>
                            <input class="form-control border-input" id="address-order" v-model="address"/>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber-order">Phone Number:</label>
                            <input class="form-control border-input" id="phoneNumber-order" v-model="phoneNumber"/>
                        </div>
                        <div class="form-group">
                            <label for="comment">Note:</label>
                            <textarea class="form-control" rows="4" id="comment" v-model="noteOrder"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success float-right"  @click="order">
                                <span>Check Out</span>
                            </button>
                        </div>
                    </div>
                </div>
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
                  address: '',
                  phoneNumber: '',
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
                  noteOrder: '',

                  options: {
                    target: [
                      {label: 'Apply to SubTotal', key: 'subtotal'},
                      {label: 'Apply to Total', key: 'total'}
                    ]
                  },



                  timer: null,
                  updateSuccess: true,
                }
              },

              watch: {
                updateSuccess: function() {
                  if(this.updateSuccess === false) {
                    console.log(22);
                    this.loadItems();
                  }
                }
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
                formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
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

                order() {
                  let url = '/order';
                  let payload = {
                    note: this.noteOrder,
                    address: this.address,
                    phoneNumber: this.phoneNumber
                  }
                  axios.post(url, payload).then((res) => {
                    if(res.data.success) {
                      toastr.success('Check out success!! Thank you!!');
                    } else {
                      toastr.fail('Something occured!!')
                    }
                  }).catch((err) => {
                    console.log(err);
                  }).finally(() => {
                    $('#showOrder').modal('toggle');
                    this.loadItems();
                  })
                },

                removeItem: function(id) {
                  let _this = this;
                  let url = '/cart/' + id;
                  axios.delete(url).then(function(success) {
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
                  }).finally(() => {
                    this.updateSuccess = true;
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

                updateCart(item, quantity) {
                  let url = '/cart/update';
                  console.log(item.quantity);
                  console.log(quantity);
                  let payload = {
                    product_id: item.id,
                    quantity: (item.quantity) + parseInt(quantity)
                  }
                  axios.put(url, payload).then(function(success) {
                    if(success.data.success) {
                      item.quantity = parseInt(item.quantity) + parseInt(quantity);

                    } else {
                      this.updateSuccess = false;
                    }
                  }, function(error) {
                    console.log(error);
                    toastr.warning('Something error!: ', error);
                  }).finally(() => {
                    this.details.sub_total = this.details.total = this.items.reduce(this.sum, 0);
                    this.details.quantity = parseInt(this.details.quantity);
                  });
                },

                minusQty(item) {
                  if(item.quantity > 1) {
                    this.updateCart(item, -1);
                  }
                },

                plusQty(item) {
                  this.updateCart(item, 1);
                },

                checkFinishInput(item) {
                  clearTimeout(this.timer);
                  this.timer = setTimeout(this.updateQuantity(item), 1000)
                },

                updateQuantity(item) {
                  if(item.quantity > 0) {
                    this.updateCart(item, 0)
                    this.details.sub_total = this.details.total = this.items.reduce(this.sum, 0);
                    let sumQty = (a, b) => {
                      return a + b.quantity;
                    }
                    this.details.total_quantity = this.items.reduce(sumQty, 0);
                  }
                }
              }
            });

          });

        })(jQuery);
    </script>
@endsection
