@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Slider</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
                                    + Create
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-5">
                            <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Category</label>
                                            <select class="form-control main_category" name="category_id" required>
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Sub Category</label>
                                            <select class="form-control sub_category" name="sub_category_id" required>
                                                <option value="" disabled selected>Select Sub Category</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select ChildCategory</label>
                                            <select class="form-control child_category" name="child_category_id" required>
                                                <option value="" disabled selected>Select child Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Brand</label>
                                    <select id="inputState" class="form-control" name="brand_id">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control" name="sku" value="{{ old('sku') }}">
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                </div>

                                <div class="form-group">
                                    <label>Offer Price</label>
                                    <input type="text" class="form-control" name="offer_price"
                                        value="{{ old('offer_price') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Offer Start Date</label>
                                            <input type="text" class="form-control datepicker" name="offer_start_date"
                                                value="{{ old('offer_start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Offer End Date</label>
                                            <input type="text" class="form-control datepicker" name="offer_end_date"
                                                value="{{ old('offer_end_date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Stock Quantity</label>
                                    <input type="number" min="0" class="form-control" name="qty"
                                        value="{{ old('qty') }}">
                                </div>

                                <div class="form-group">
                                    <label>Video Link</label>
                                    <input type="text" class="form-control" name="video_link"
                                        value="{{ old('video_link') }}">
                                </div>


                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea name="short_description" class="form-control"></textarea>
                                </div>


                                <div class="form-group">
                                    <label>Long Description</label>
                                    <textarea name="long_description" class="form-control summernote"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Product Type</label>
                                    <select id="inputState" class="form-control" name="product_type">
                                        <option value="">Select</option>
                                        <option value="new_arrival">New Arrival</option>
                                        <option value="featured_product">Featured</option>
                                        <option value="top_product">Top Product</option>
                                        <option value="best_product">Best Product</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Seo Title</label>
                                    <input type="text" class="form-control" name="seo_title"
                                        value="{{ old('seo_title') }}">
                                </div>

                                <div class="form-group">
                                    <label>Seo Description</label>
                                    <textarea name="seo_description" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('body').on('change', '.main_category', function(e) {
                let category_id = $(this).val();
                $.ajax({
                    url: "{{ route('admin.product.get-subcategories', '') }}/" + category_id,
                    method: 'GET',
                    data: {
                        category_id: category_id,
                    },
                    success: function(data) {
                        let subcategoryOptions =
                            '<option value="" disabled selected>Select Sub Category</option>';
                        data.forEach(function(subcategory) {
                            subcategoryOptions +=
                                `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                        $('.sub_category').html(subcategoryOptions);
                    },
                    error: function(data) {
                        toastr.error('Something went wrong!');
                    }
                })
            });


            $('body').on('change', '.sub_category', function(e) {
                let subcategory_id = $(this).val();
                $.ajax({
                    url: "{{ route('admin.product.get-childcategories', '') }}/" + subcategory_id,
                    method: 'GET',
                    data: {
                        subcategory_id: subcategory_id,
                    },
                    success: function(data) {
                        let subcategoryOptions =
                            '<option value="" disabled selected>Select Sub Category</option>';
                        data.forEach(function(subcategory) {
                            subcategoryOptions +=
                                `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                        $('.child_category').html(subcategoryOptions);
                    },
                    error: function(data) {
                        toastr.error('Something went wrong!');
                    }
                })
            });

        });
    </script>
@endpush
