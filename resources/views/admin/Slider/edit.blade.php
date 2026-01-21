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
                            <form action="{{ route('admin.slider.update', $slider->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <p>Preview</p>
                                    <img src="{{ asset($slider->banner) }}" alt="banner" width="200px">
                                </div>
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input name="banner" type="file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <input name="type" type="text" class="form-control" value="{{ $slider->type }}">
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input name="title" type="text" class="form-control" value="{{ $slider->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Starting Price</label>
                                    <input name="starting_price" type="text" class="form-control"
                                        value="{{ $slider->starting_price }}">
                                </div>
                                <div class="form-group">
                                    <label>Button Url</label>
                                    <input name="btn_url" type="text" class="form-control"
                                        value="{{ $slider->btn_url }}">
                                </div>

                                <div class="form-group">
                                    <label>Serial</label>
                                    <input name="serial" type="text" class="form-control" value="{{ $slider->serial }}">
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select name="status" id="inputState" class="form-control">
                                        <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
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
