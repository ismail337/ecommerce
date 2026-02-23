@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product gallery</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary">
                <i class="fas fa-backward"></i> Back to Product List
            </a>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product: {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.product-image-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="image">Image <code>Multiple image supported</code> </label>
                                    <input type="file" name="image[]" class="form-control" multiple>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Image</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.product-image-gallery.create') }}" class="btn btn-primary">
                                    + Create
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {

            $('body').on('click', '.change-status', function(e) {
                let id = $(this).attr('data-id');
                let isChecked = $(this).is(':checked')
                $.ajax({
                    url: "{{ route('admin.product.change-status') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        status: isChecked,
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                    error: function(data) {
                        toastr.error('Something went wrong!');
                    }
                });
            });

        });
    </script>
@endpush
