@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Seller Products</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
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

            $('body').on('change', '.is_approve', function(e) {
                let id = $(this).attr('data-id');
                let value = $(this).val();

                $.ajax({
                    url: "{{ route('admin.change-approve-status') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        is_approved: value,
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                    error: function(data) {
                        toastr.error('Something went wrong!');
                    }
                });
            })

        });
    </script>
@endpush
