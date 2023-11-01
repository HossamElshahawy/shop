@extends('dashboard.layout.master')
@section('content')
    @include('dashboard.alerts')

    <div class="row">
        <div class="col-12">
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions</h3>
                    <a href="{{ route('role.create') }}" class="btn btn-primary float-right">Create Role</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Controller</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    {{$role->name}}
                                </td>
                                <td>
                                    @foreach($role->permissions as $permissions)

                                    <li>{{$permissions->name}}</li>

                                    @endforeach
                                </td>

                                <td class="project-actions text-right">

                                    <a class="btn btn-info btn-sm" href="{{route('role.edit',$role->id)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm role-delete" data-id="{{ $role->id }}">
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

    <script>
        $(document).ready(function() {
            $('.role-delete').click(function() {
                let roleId = $(this).data('id');
                if (confirm('Are you sure you want to delete this Role?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/role/' + roleId,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Handle success, for example, remove the item from the page
                            // alert('Role deleted successfully');
                            window.location.reload();
                            // You may want to reload the page or update the UI in some way
                        },
                        error: function(err) {
                            // Handle errors, such as displaying an error message
                            console.log(err);
                        }
                    });
                }
            });
        });
    </script>
@endsection
