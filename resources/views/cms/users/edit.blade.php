@extends('cms.parent')

@section('title', '')

@section('css_content')
@endsection

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('users.update' , $user->id) }}" method="POST" >
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Errors!</h5>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="user_name"
                                    placeholder="Enter name" value="{{ old('user_name') ?? $user->name}}">
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email address</label>
                                <input type="email" class="form-control" id="user_email" name="user_email"
                                    placeholder="Enter email" value="{{ old('user_email') ?? $user->email}}">
                            </div>
                            <div class="form-group">
                                <label for="user_address">Address</label>
                                <input type="text" class="form-control" id="user_address" name="user_address"
                                    placeholder="Enter address" value="{{ old('user_address') ?? $user->address}}">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" class="form-control" id="user_password" name="user_password"
                                    placeholder="Password" value="{{ old('user_password')}}">
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
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('js_content')
@endsection

