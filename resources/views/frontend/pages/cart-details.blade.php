@extends('frontend.layouts.master')
@section('title')
    {{ $generalSetting->site_name }} | Cart
@endsection
@section('content')
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>cart View</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">cart view</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                BREADCRUMB END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->


    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                CART VIEW PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            product item
                                        </th>

                                        <th class="wsus__pro_name">
                                            product details
                                        </th>

                                        <th class="wsus__pro_tk">
                                            price
                                        </th>

                                        <th class="wsus__pro_status">
                                            Total
                                        </th>
                                        <th class="wsus__pro_select">
                                            quantity
                                        </th>
                                        <th class="wsus__pro_icon">
                                            <a href="#" class="common_btn clear_cart">clear cart</a>
                                        </th>
                                    </tr>

                                    @foreach ($cartItems as $cartItem)
                                        <tr class="d-flex">
                                            <td class="wsus__pro_img"><img src="{{ asset($cartItem->options->image) }}"
                                                    alt="product" class="img-fluid w-100">
                                            </td>

                                            <td class="wsus__pro_name">
                                                <p>{{ $cartItem->name }}</p>

                                                @foreach ($cartItem->options->variants as $variantName => $variant)
                                                    <span>{{ $variantName }}:
                                                        {{ $variant['name'] }}({{ $generalSetting->currency_icon . '' . number_format($variant['price'], 2) }})</span>
                                                @endforeach
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6>${{ number_format($cartItem->price, 2) }}</h6>
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6 id="{{ $cartItem->rowId }}">
                                                    ${{ number_format(($cartItem->price + $cartItem->options->variant_total_price) * $cartItem->qty, 2) }}
                                                </h6>
                                            </td>

                                            <td class="wsus__pro_select">
                                                <div class="product_qty_wrapper">
                                                    <button class="btn btn-danger product-decrement">-</button>
                                                    <input class="product-qty" data-rowid="{{ $cartItem->rowId }}"
                                                        type="text" min="1" max="100"
                                                        value="{{ $cartItem->qty }}" readonly />
                                                    <button class="btn btn-success product-increment">+</button>
                                                </div>
                                            </td>

                                            <td class="wsus__pro_icon">
                                                <a href="{{ route('cart.remove-product', $cartItem->rowId) }}"><i
                                                        class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (count($cartItems) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center ">
                                                <h4>Your cart is empty</h4>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span
                                class="cart-total">{{ $generalSetting->currency_icon }}{{ getCartTotal() }}</span></p>

                        <p>Coupon(-): <span
                                id="cart_discount">{{ $generalSetting->currency_icon }}{{ getCartDiscount() }}</span></p>
                        <p class="total"><span>total:</span> <span
                                id="cart_total">{{ $generalSetting->currency_icon }}{{ getMainCartTotal() }}</span></p>

                        <form id="coupon_form">
                            <input type="text" placeholder="Coupon Code" name="coupon_code"
                                value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="{{ route('user.checkout') }}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{ route('home') }}"><i
                                class="fab fa-shopify"></i> go shop</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_2.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_3.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  CART VIEW PAGE END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Product Increment
            $('.product-increment').on('click', function() {

                let input = $(this).siblings('.product-qty');
                let currentQty = parseInt(input.val());
                let newQty = currentQty + 1;
                let rowId = input.data('rowid');
                input.val(newQty);

                $.ajax({
                    url: "{{ route('cart.update-quantity') }}",
                    method: 'POST',
                    data: {
                        qty: newQty,
                        rowId: rowId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let priceCell = $('#' + rowId);
                            priceCell.text('$' + response.product_total.toFixed(2));
                            getCartTotal();
                            calculateCouponDiscount();
                            toastr.success(response.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message)
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            })

            // Product Decrement
            $('.product-decrement').on('click', function() {
                let input = $(this).siblings('.product-qty');
                let currentQty = parseInt(input.val());
                let rowId = input.data('rowid');
                if (currentQty > 1) {
                    let newQty = currentQty - 1;
                    input.val(newQty);

                    $.ajax({
                        url: "{{ route('cart.update-quantity') }}",
                        method: 'POST',
                        data: {
                            qty: newQty,
                            rowId: rowId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                let priceCell = $('#' + rowId);
                                priceCell.text('$' + response.product_total.toFixed(2));
                                getCartTotal();
                                calculateCouponDiscount();
                                toastr.success(response.message);
                            } else if (data.status === 'error') {
                                toastr.error(data.message)
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                }
            })

            // Clear Cart
            $('.clear_cart').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: 'get',
                            url: "{{ route('cart.clear') }}",
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire('Cleared!', data.message);
                                    window.location.reload();
                                } else if (data.status == 'error') {
                                    Swal.fire('Cant Clear ',
                                        data.message,
                                        'error');
                                }

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });

                    }
                });
            })


            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize().split('=')[1];

                $.ajax({
                    method: 'GET',
                    url: "{{ route('cart.apply-coupon') }}",
                    data: {
                        coupon_code: formData
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            toastr.success(data.message);
                            calculateCouponDiscount();
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {

                    }
                })

            });


            function calculateCouponDiscount() {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('coupon-calculation') }}',
                    success: function(data) {
                        if (data.status === 'success') {
                            $('#cart_total').text('{{ $generalSetting->currency_icon }}' + data
                                .cart_total.toFixed(2));
                            $('#cart_discount').text('{{ $generalSetting->currency_icon }}' + data
                                .discount.toFixed(2));
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }

        });
    </script>
@endpush
