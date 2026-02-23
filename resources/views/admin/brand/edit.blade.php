@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Brand</h1>
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
                            <h4>Create Brand</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <p>Preview</p>
                                    <img src="{{ asset($brand->logo) }}" alt="banner" width="200px">
                                </div>
                                <div class="form-group">
                                    <label>Brand Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>

                                <div class="form-group">
                                    <label>Brand Name</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ $brand->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="is_featured">Is Featured</label>
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="1" {{ $brand->is_featured == 1 ? 'selected' : '' }}>yes</option>
                                        <option value="0" {{ $brand->is_featured == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select name="status" id="inputState" class="form-control">
                                        <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
