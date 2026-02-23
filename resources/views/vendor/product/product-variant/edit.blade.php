@extends('vendor.layouts.master')

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Create Variant</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('vendor.product-variant.update', $productVariant->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label>Product Variant Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $productVariant->name }}" required>
                                        <input type="hidden" name="product" value="{{ $productVariant->product_id }}">
                                    </div>


                                    <div class="form-group mt-2">
                                        <label for="inputState">Status</label>
                                        <select name="status" id="inputState" class="form-control">
                                            <option value="1" {{ $productVariant->status == 1 ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0" {{ $productVariant->status == 0 ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Update Product Variant</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
