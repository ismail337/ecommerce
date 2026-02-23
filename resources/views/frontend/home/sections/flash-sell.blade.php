   <section id="wsus__flash_sell" class="wsus__flash_sell_2">
       <div class=" container">
           <div class="row">
               <div class="col-xl-12">
                   <div class="offer_time" style="background: url(frontend/images/flash_sell_bg.jpg)">
                       <div class="wsus__flash_coundown">
                           <span class=" end_text">flash sell</span>
                           <div class="simply-countdown simply-countdown-one"></div>
                           <a class="common_btn" href="#">see more <i class="fas fa-caret-right"></i></a>
                       </div>
                   </div>
               </div>
           </div>
           <div class="row flash_sell_slider">
               @foreach ($flashSaleItems as $flashSaleItem)
                   <div class="col-xl-3 col-sm-6 col-lg-4">
                       <div class="wsus__product_item">
                           {{-- <span class="wsus__new">New</span> --}}
                           @if ($flashSaleItem->product->product_type)
                               <span class="wsus__new">{{ productType($flashSaleItem->product->product_type) }}</span>
                           @endif
                           @if (isDiscountActive($flashSaleItem->product))
                               <span
                                   class="wsus__minus">-{{ getDiscountedPrice($flashSaleItem->product->price, $flashSaleItem->product->offer_price) }}%</span>
                           @endif
                           <a class="wsus__pro_link"
                               href={{ route('product-details', $flashSaleItem->product->slug) }}>">
                               <img src="{{ asset($flashSaleItem->product->thumb_image) }}" alt="product"
                                   class="img-fluid w-100 img_1" />
                               <img src="{{ asset($flashSaleItem->product->thumb_image) }}" alt="product"
                                   class="img-fluid w-100 img_2" />
                           </a>
                           <ul class="wsus__single_pro_icon">
                               <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                           class="far fa-eye"></i></a></li>
                               <li><a href="#"><i class="far fa-heart"></i></a></li>
                               <li><a href="#"><i class="far fa-random"></i></a>
                           </ul>
                           <div class="wsus__product_details">
                               <a class="wsus__category"
                                   href="#">{{ $flashSaleItem->product->category->name }}</a>
                               <p class="wsus__pro_rating">
                                   <i class="fas fa-star"></i>
                                   <i class="fas fa-star"></i>
                                   <i class="fas fa-star"></i>
                                   <i class="fas fa-star"></i>
                                   <i class="fas fa-star-half-alt"></i>
                                   <span>(133 review)</span>
                               </p>
                               <a class="wsus__pro_name" href="#">{{ $flashSaleItem->product->name }}</a>

                               @if (isDiscountActive($flashSaleItem->product))
                                   <p class="wsus__price">${{ $flashSaleItem->product->offer_price }}
                                       <del>${{ $flashSaleItem->product->price }}</del>
                                   </p>
                               @else
                                   <p class="wsus__price">${{ $flashSaleItem->product->price }}</p>
                               @endif

                               </p>
                               <a class="add_cart" href="#">add to cart</a>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
       </div>
   </section>
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
       </script>
   @endpush
