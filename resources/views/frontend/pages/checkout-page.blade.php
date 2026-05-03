@extends('frontend.layouts.master')

@section('title')
    {{ $generalSetting->site_name }} | Checkout
@endsection
@section('content')
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Check Out</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">Check out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                        CHECK OUT PAGE START
                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="wsus__check_form">
                        <h5>Billing Details <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">add
                                new address</a></h5>
                        <div class="row">
                            @foreach ($userAddresses as $userAddress)
                                <div class="col-xl-6">
                                    <div class="wsus__checkout_single_address">
                                        <div class="form-check">
                                            <input class="form-check-input shipping_address" type="radio"
                                                name="flexRadioDefault" id="flexRadioDefault{{ $userAddress->id }}"
                                                data-id="{{ $userAddress->id }}">
                                            <label class="form-check-label" for="flexRadioDefault{{ $userAddress->id }}">
                                                Select Address
                                            </label>
                                        </div>
                                        <ul>
                                            <li><span>Name :</span> {{ $userAddress->name }}</li>
                                            <li><span>Phone :</span> {{ $userAddress->phone }}</li>
                                            <li><span>Email :</span> {{ $userAddress->email }}</li>
                                            <li><span>Country :</span> {{ $userAddress->country }}</li>
                                            <li><span>City :</span> {{ $userAddress->city }}</li>
                                            <li><span>Zip Code :</span> {{ $userAddress->zip }}
                                            <li><span>Address :</span> {{ $userAddress->address }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="wsus__order_details" id="sticky_sidebar">
                        <p class="wsus__product">shipping Methods</p>

                        @foreach ($shippingAddress as $rule)
                            @if ($rule->type === 'min_cost' && getMainCartTotal() >= $rule->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="shipping_method"
                                        value="{{ $rule->id }}" data-id="{{ $rule->cost }}"
                                        id="{{ $rule->type }}">
                                    <label class="form-check-label" for="{{ $rule->type }}">
                                        {{ $rule->name }}
                                        <span>Cost:{{ $generalSetting->currency_icon }}{{ $rule->cost }}</span>
                                    </label>
                                </div>
                            @endif
                            @if ($rule->type === 'flat_cost')
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="shipping_method"
                                        value="{{ $rule->id }}" data-id="{{ $rule->cost }}"
                                        id="{{ $rule->type }}">
                                    <label class="form-check-label" for="{{ $rule->type }}">
                                        {{ $rule->name }}
                                        <span>Cost:{{ $generalSetting->currency_icon }}{{ $rule->cost }}</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach

                        <div class="wsus__order_details_summery">
                            <p>subtotal: <span>{{ $generalSetting->currency_icon }}{{ getCartTotal() }}</span></p>
                            <p>Coupon: <span>{{ $generalSetting->currency_icon }}{{ getCartDiscount() }}</span></p>
                            <p>shipping fee(+): <span id="shipping_fee">{{ $generalSetting->currency_icon }}0</span>
                            </p>
                            {{-- <p>tax: <span>{{ $generalSetting->currency_icon }}{{ $tax }}</span></p> --}}
                            <p><b>total:</b>
                                <span><b id="total_amount"
                                        data-id="{{ getMainCartTotal() }}">{{ $generalSetting->currency_icon }}{{ getMainCartTotal() }}</b></span>
                            </p>
                        </div>
                        <div class="terms_area">
                            <div class="form-check">
                                <input class="form-check-input agree_term" type="checkbox" value=""
                                    id="flexCheckChecked3" checked>
                                <label class="form-check-label" for="flexCheckChecked3">
                                    I have read and agree to the website <a href="#">terms and conditions *</a>
                                </label>
                            </div>
                        </div>
                        <form action="" id="checkOutForm">
                            <input type="hidden" name="shipping_method_id" value="" id="shipping_method_id">
                            <input type="hidden" name="shipping_address_id" value="" id="shipping_address_id">

                        </form>
                        <a href="javascript:void(0)" id="submitCheckoutForm" class="common_btn">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{ route('user.checkout.add-address') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="First Name" name="name"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="country">
                                                <option value="AL">Country / Region *</option>
                                                <option>Select</option>
                                                @foreach (config('settings.country_list') as $country)
                                                    <option value="{{ $country }}"
                                                        {{ old('country') == $country ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="address" placeholder="Street Address *"
                                                value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="city" placeholder="Town / City *"
                                                value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="state" placeholder="State *"
                                                value="{{ old('state') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="zip" placeholder="Zip *"
                                                value="{{ old('zip') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="phone" placeholder="Phone *"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" name="email" placeholder="Email *"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====================================-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#shipping_method_id').val("");
                $('#shipping_address_id').val("");
                $('input[type="radio"]').prop('checked', false);

                $('.shipping_method').on('click', function() {
                    $('#shipping_method_id').val($(this).val());
                    $('#shipping_fee').text('{{ $generalSetting->currency_icon }}' + $(this).data('id'));
                    let total_amount = parseFloat($('#total_amount').data('id')) + parseFloat($(this).data(
                        'id'));
                    $('#total_amount').text('{{ $generalSetting->currency_icon }}' + total_amount);
                });

                $('.shipping_address').on('click', function() {
                    $('#shipping_address_id').val($(this).data('id'));
                });

                $('#submitCheckoutForm').on('click', function(e) {
                    e.preventDefault();

                    if ($('#shipping_method_id').val() === "") {
                        toastr.error('Please select a shipping method');
                    } else if ($('#shipping_address_id').val() === "") {
                        toastr.error('Please select a shipping address');
                    } else if (!$('.agree_term').prop('checked')) {
                        toastr.error('You have to agree website terms and conditions');
                    } else {
                        $.ajax({
                            url: "{{ route('user.checkout.form-submit') }}", // Fixed: Added quotes around route
                            method: 'POST',
                            data: $('#checkOutForm').serialize(),
                            beforeSend: function() {
                                $('#submitCheckoutForm').html(
                                    '<i class="fas fa-spinner fa-spin fa-1x"></i>');
                            },
                            success: function(response) {
                                $('#submitCheckoutForm').text('Place Order');
                                if (response.status === 'success') {
                                    toastr.success(response.message);
                                    // console.log(response.redirect_url);
                                    window.location.href = response.redirect_url;
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
