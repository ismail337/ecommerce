@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Child Category</h1>
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
                            <h4>Create Child Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.child-category.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select class="form-control main_category" name="category_id" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Select Sub Category</label>
                                    <select class="form-control" name="subcategory_id" required>
                                        <option value="" disabled selected>Select Sub Category</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>


                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select name="status" id="inputState" class="form-control">
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
                console.log('changed');
                let category_id = $(this).val();
                console.log(category_id);

                $.ajax({
                    url: "{{ route('admin.child-category.get-subcategories', '') }}/" + category_id,
                    method: 'GET',
                    data: {
                        category_id: category_id,
                    },
                    success: function(data) {
                        let subcategoryOptions =
                            '<option value="" disabled selected>Select Sub Category</option>';
                        data.subcategories.forEach(function(subcategory) {
                            subcategoryOptions +=
                                `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                        $('select[name="subcategory_id"]').html(subcategoryOptions);
                    },
                    error: function(data) {
                        toastr.error('Something went wrong!');
                    }
                })
            });

        });
    </script>
@endpush
