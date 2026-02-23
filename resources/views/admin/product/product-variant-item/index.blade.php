@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product: {{ $product->name }}</h1>
            <h1 class="ml-2 mr-2">|</h1>
            <h1>Variant: {{ $product_variant->name }}</h1>
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
                            <h4>All Variant Item</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.product-variant-item.create', [$product->id, $product_variant->id]) }}"
                                    class="btn btn-primary">
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
                    url: "{{ route('admin.product-variant-item.change-status') }}",
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
