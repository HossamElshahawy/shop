@extends('dashboard.layout.master')
@section('content')
    @include('dashboard.alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>
                <form method="post" action="{{ route('category.update', $category->slug) }}">
                    @csrf
                    @method('PUT') <!-- Use the PUT method for updating the category -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $category->title }}">
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary3" name="is_parent" value="{{$category->is_parent}}" @if($category->is_parent == 1) checked @endif>
                                <label for="checkboxPrimary3">
                                    is_parent
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6" id="parentCategorySelect">
                            <div class="form-group">
                                <label>Select Parent Category</label>
                                <select class="select2" name="parent_id" data-placeholder="Select Parent Category" style="width: 100%;">
                                    <option value="" >No Parent</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) selected @endif>{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>

    <script>
        const isParentCheckbox = document.getElementById('checkboxPrimary3');
        const parentCategorySelect = document.getElementById('parentCategorySelect');

        isParentCheckbox.addEventListener('change', function () {
            parentCategorySelect.style.display = this.checked ? 'none' : 'block';
        });

        parentCategorySelect.style.display = isParentCheckbox.checked ? 'none' : 'block';
    </script>
@endsection
