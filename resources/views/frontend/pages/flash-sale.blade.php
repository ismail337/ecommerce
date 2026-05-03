@extends('frontend.layouts.master')
@section('title')
    {{ $generalSetting->site_name }} | Flash Sale
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
                        <h4>offer detaila</h4>
                        <ul>
                            <li><a href="#">daily deals</a></li>
                            <li><a href="#">offer details</a></li>
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
                                                                                                                                                                                                        DAILY DEALS DETAILS START
                                                                                                                                                                                                    ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset('frontend/images/offer_banner_2.png') }}" alt="offrt img"
                                class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>apple watch</p>
                                <span>up 50% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset('frontend/images/offer_banner_3.png') }}" alt="offrt img"
                                class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>xiaomi power bank</p>
                                <span>up 37% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sell</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($flashSaleItems as $item)
                        <div class="col-xl-3">
                            <div class="wsus__offer_det_single">
                                <div class="wsus__product_item">
                                    <a class="wsus__pro_link" href="{{ route('product-details', $item->product->slug) }}">
                                        <img src="{{ asset($item->product->thumb_image) }}" alt="product"
                                            class="img-fluid w-100 img_1" />
                                        @if ($item->product->productImageGalleries->count() > 0)
                                            <img src="{{ asset($item->product->productImageGalleries[0]->image) }}"
                                                alt="product" class="img-fluid w-100 img_2" />
                                        @else
                                            <img src="{{ asset($item->product->thumb_image) }}" alt="product"
                                                class="img-fluid w-100 img_2" />
                                        @endif
                                    </a>
                                    <div class="wsus__product_details">
                                        <a class="wsus__category" href="#">{{ $item->product->category->name }}</a>
                                        <p class="wsus__pro_rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <span>(120 review)</span>
                                        </p>
                                        <a class="wsus__pro_name" href="#">{{ $item->product->name }}</a>

                                        @if (isDiscountActive($item->product))
                                            <p class="wsus__price">${{ $item->product->offer_price }}
                                                <del>{{ $generalSetting->currency_icon }}{{ $item->product->price }}</del>
                                            </p>
                                        @else
                                            <p class="wsus__price">
                                                {{ $generalSetting->currency_icon }}{{ $item->product->price }}</p>
                                        @endif
                                        <form class="shopping-cart-form">
                                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                            @foreach ($item->product->productVariants as $variant)
                                                @if ($variant->status != 0)
                                                    <div class="col-xl-6 col-sm-6">
                                                        <select class="d-none" name="variants_items[]">
                                                            @foreach ($variant->productVariantItems as $variantItem)
                                                                @if ($variantItem->status != 0)
                                                                    <option value="{{ $variantItem->id }}"
                                                                        {{ $variantItem->is_default == 1 ? 'selected' : '' }}>
                                                                        {{ $variantItem->name }}
                                                                        ({{ $generalSetting->currency_icon }}{{ $variantItem->additional_price }})
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <input name="qty" type="hidden" value="1" />
                                            <button type="submit" class="add_cart" href="#">add to cart</button>

                                        </form>
                                    </div>
                                </div>
                                <div class="wsus__offer_progress">
                                    <p><span>Sold 91</span> <span>Total 120</span></p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ getDiscountedPrice($item->product->price, $item->product->offer_price) }}%;"
                                            aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                            {{ getDiscountedPrice($item->product->price, $item->product->offer_price) }}%
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5">
                    @if ($flashSaleItems->hasPages())
                        {{ $flashSaleItems->links() }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                        DAILY DEALS DETAILS END
                                                                                                                                                                                                    ==============================-->
@endsection

@push('scripts')
    <script>
        var d = new Date(),
            countUpDate = new Date();
        d.setDate(d.getDate() + 90);

        // default example
        simplyCountdown('.simply-countdown-one', {
            year: {{ date('Y', strtotime($flashSaleDate->end_date)) }},
            month: {{ date('n', strtotime($flashSaleDate->end_date)) }},
            day: {{ date('j', strtotime($flashSaleDate->end_date)) }}
        });

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.shopping-cart-form').on('submit', function(e) {
                e.preventDefault();
                let formdata = $(this).serialize();

                $.ajax({
                    url: "{{ route('add-to-cart') }}",
                    method: 'POST',
                    data: formdata,
                    success: function(res) {
                        if (res.status === 'success') {
                            getCartCount();
                            fetchSidebarCartProducts();
                            toastr.success(res.message);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            });
        });
    </script>
@endpush
