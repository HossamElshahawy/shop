@extends('dashboard.layout.master')
@section('content')
    @include('dashboard.alerts')

    <div class="row">
        <div class="col-12">
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    <a href="{{ route('category.create') }}" class="btn btn-primary float-right">Create</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th>Title</th>
                            <th>is Parent?</th>
                            <th>parent</th>

                            <th>Status</th>

                            <th>Controller</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{$category->title}}
                                </td>
                                <td>
                                    @if($category->is_parent)
                                        true
                                    @else
                                        false
                                    @endif

                                </td>
                                <td>
                                    @if (!$category->is_parent && isset($categoryNames[$category->id]))
                                        {{ $categoryNames[$category->id] }}
                                    @else
                                        No Parent
                                    @endif

                                </td>
                                <td>
                                    <input type="checkbox" name="toggle" value="{{$category->id}}" data-toggle="switchbutton" {{$category->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="small" data-onstyle="success" data-offstyle="danger">
                                </td>
                                <td class="project-actions text-right">

                                    <a class="btn btn-info btn-sm" href="{{route('category.edit',$category->slug)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm category-delete" data-id="{{ $category->slug }}">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>


@endsection

@section('scripts')
    {{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "paging": true,
                "pageLength": 5, // Specify the number of items per page
                "page": 'page_number', // Specify the name of the page parameter
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>

    //delete script
    <script>
        $(document).ready(function() {
            $('.category-delete').click(function() {
                let categoryId = $(this).data('id');
                if (confirm('Are you sure you want to delete this Category?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/category/' + categoryId,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Handle success, for example, remove the item from the page
                            alert('Category deleted successfully');
                            window.location.reload();
                            // You may want to reload the page or update the UI in some way
                        },
                        error: function(err) {
                            // Handle errors, such as displaying an error message
                            alert('Category Not Found or Not a Parent');

                            console.log(err);
                        }
                    });
                }
            });
        });
    </script>

    // status switch
        <script>
            $('input[name=toggle]').change(function () {
            var mode = $(this).prop('checked');
            var id = $(this).val();


            $.ajax({
                url: "{{ route('category.status') }}", // Use the route name
                type: "POST",
                data:
                {
                _token: "{{ csrf_token() }}",
                mode: mode,
                id: id,
                },
                    success: function (response)
                    {
                    console.log(response.status);
                    },
            });
        });
    </script>

@endsection
