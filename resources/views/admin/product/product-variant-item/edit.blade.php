@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Variant Item update</h1>
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
                            <h4>Update Product Variant Item</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.product-variant-item.update', $variantItem->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Variant Name</label>
                                    <input type="text" class="form-control" name="variant_name"
                                        value="{{ $variantItem->productVariant->name }}" readonly>
                                </div>


                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $variantItem->name }}">
                                </div>

                                <div class="form-group">
                                    <label>Price <code>(Set 0 for make it free)</code></label>
                                    <input type="text" class="form-control" name="price"
                                        value="{{ $variantItem->additional_price }}">
                                </div>


                                <div class="form-group">
                                    <label for="inputState">Is Default</label>
                                    <select id="inputState" class="form-control" name="is_default">
                                        <option value="">Select</option>
                                        <option value="1" {{ $variantItem->is_default == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $variantItem->is_default == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select name="status" id="inputState" class="form-control">
                                        <option value="1" {{ $variantItem->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $variantItem->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Product Variant Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
