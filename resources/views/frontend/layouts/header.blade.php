 <header>
     <div class="container">
         <div class="row">
             <div class="col-2 col-md-1 d-lg-none">
                 <div class="wsus__mobile_menu_area">
                     <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                 </div>
             </div>
             <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                 <div class="wsus_logo_area">
                     <a class="wsus__header_logo" href="index.html">
                         <img src="{{ asset('frontend/images/logo_2.png') }}" alt="logo" class="img-fluid w-100">
                     </a>
                 </div>
             </div>
             <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                 <div class="wsus__search">
                     <form>
                         <input type="text" placeholder="Search...">
                         <button type="submit"><i class="far fa-search"></i></button>
                     </form>
                 </div>
             </div>
             <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                 <div class="wsus__call_icon_area">
                     <div class="wsus__call_area">
                         <div class="wsus__call">
                             <i class="fas fa-user-headset"></i>
                         </div>
                         <div class="wsus__call_text">
                             <p>example@gmail.com</p>
                             <p>+569875544220</p>
                         </div>
                     </div>
                     <ul class="wsus__icon_area">
                         <li><a href="wishlist.html"><i class="fal fa-heart"></i><span>05</span></a></li>
                         <li><a href="compare.html"><i class="fal fa-random"></i><span>03</span></a></li>
                         <li><a class="wsus__cart_icon" href="#"><i class="fal fa-shopping-bag"></i><span
                                     id="cart-count">{{ Cart::content()->count() }}</span></a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <div class="wsus__mini_cart">
         <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
         <ul class="mini_cart_wrapper">
             {{-- <li>
                 <div class="wsus__cart_img">
                     <a href="#"><img src="{{ asset('frontend/images/tab_2.jpg') }}" alt="product"
                             class="img-fluid w-100"></a>
                     <a class="wsis__del_icon" href="#"><i class="fas fa-minus-circle"></i></a>
                 </div>
                 <div class="wsus__cart_text">
                     <a class="wsus__cart_title" href="#">apple 9.5" 7 serise tab with full view display</a>
                     <p>$140 <del>$150</del></p>
                 </div>
             </li> --}}

             @foreach (Cart::content() as $item)
                 <li id="mini_cart_{{ $item->rowId }}">
                     <div class="wsus__cart_img">
                         <a href="#"><img src="{{ asset($item->options->image) }}" alt="product"
                                 class="img-fluid w-100"></a>
                         <a class="wsis__del_icon remove_sidebar_product" data-id="{{ $item->rowId }}"
                             href="#"><i class="fas fa-minus-circle"></i></a>
                     </div>
                     <div class="wsus__cart_text">
                         <a class="wsus__cart_title"
                             href="{{ route('product-details', $item->options->slug) }}">{{ $item->name }}</a>
                         <p>{{ $generalSetting->currency_icon }}{{ $item->price }} </p>
                         <small>Variants
                             total:{{ $generalSetting->currency_icon }}{{ $item->options->variant_total_price }}</small>
                     </div>
                 </li>
             @endforeach
         </ul>
         <h5>sub total <span class="cart-total">{{ $generalSetting->currency_icon }}{{ getCartTotal() }}</span></h5>
         <div class="wsus__minicart_btn_area">
             <a class="common_btn" href="{{ route('cart-details') }}">view cart</a>
             <a class="common_btn" href="check_out.html">checkout</a>
         </div>
     </div>

 </header>
 @push('scripts')
     <script>
         function fetchSidebarCartProducts() {
             $.ajax({
                 method: 'GET',
                 url: "{{ route('cart.products') }}",
                 success: function(data) {
                     console.log(data);
                     $('.mini_cart_wrapper').html("");
                     var html = '';
                     for (let item in data.cart_items) {
                         let product = data.cart_items[item];
                         html += `
                        <li id="mini_cart_${product.rowId}">
                            <div class="wsus__cart_img">
                                <a href="{{ url('product-detail') }}/${product.options.slug}"><img src="{{ asset('/') }}${product.options.image}" alt="product" class="img-fluid w-100"></a>
                                <a class="wsis__del_icon remove_sidebar_product" data-id="${product.rowId}" href=""><i class="fas fa-minus-circle"></i></a>
                            </div>
                            <div class="wsus__cart_text">
                                <a class="wsus__cart_title" href="{{ url('product-detail') }}/${product.options.slug}">${product.name}</a>
                                <p>{{ $generalSetting->currency_icon }}${product.price}</p>
                                <small>Variants total: {{ $generalSetting->currency_icon }}${product.options.variant_total_price}</small>
                                <br>
                                <small>Qty: ${product.qty}</small>
                            </div>
                        </li>`
                     }

                     $('.mini_cart_wrapper').html(html);

                     getCartTotal();

                 },
                 error: function(data) {

                 }
             })
         }

         function getCartTotal() {
             $.ajax({
                 method: 'GET',
                 url: "{{ route('cart.total') }}",
                 success: function(data) {
                     $('.cart-total').text('{{ $generalSetting->currency_icon }}' + data);
                 },
                 error: function(data) {

                 }
             })
         }

         $('body').on('click', '.remove_sidebar_product', function(e) {
             console.log('clicked');
             e.preventDefault();
             var rowId = $(this).data('id');
             $.ajax({
                 method: 'GET',
                 url: "{{ route('cart.remove-sidebar-product') }}",
                 data: {
                     rowId: rowId
                 },
                 success: function(data) {
                     if (data.status === 'success') {
                         $('#mini_cart_' + rowId).remove();
                         getCartCount();
                         getCartTotal();
                         toastr.success(data.message);
                     }
                 },
                 error: function(data) {

                 }
             })
         });
     </script>
 @endpush
