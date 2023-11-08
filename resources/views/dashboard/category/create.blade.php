@extends('dashboard.layout.master')
@section('content')
    @include('dashboard.alerts')


    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('category.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title">
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary3" name="is_parent" value="1" @if(old('is_parent')) checked @endif>
                                <label for="checkboxPrimary3">
                                    is_parent
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6" id="parentCategorySelect">
                            <div class="form-group">
                                <label>Select Parent Category</label>
                                <select class="select2" name="parent_id" data-placeholder="Select Parent Category" style="width: 100%;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
    </div>


@endsection

@section('scripts')
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>

    <script>
        // Get references to the checkbox and select element
        const isParentCheckbox = document.getElementById('checkboxPrimary3');
        const parentCategorySelect = document.getElementById('parentCategorySelect');

        // Add an event listener to the checkbox to toggle the select element's visibility
        isParentCheckbox.addEventListener('change', function () {
            parentCategorySelect.style.display = this.checked ? 'none' : 'block';
        });

        // Initialize the select element's visibility based on the initial state of the checkbox
        parentCategorySelect.style.display = isParentCheckbox.checked ? 'none' : 'block';
    </script>

@endsection
