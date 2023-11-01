@extends('dashboard.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">General</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('permission.update',$permission->id)}}">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="inputName">Project Name</label>
                        <input type="text" name="name" id="inputName" class="form-control" value="{{$permission->name}}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

@endsection
