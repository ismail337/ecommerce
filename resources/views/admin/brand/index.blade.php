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
                            <h4>All brands</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.brand.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create
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
                    url: "{{ route('admin.brand.change-status') }}",
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
