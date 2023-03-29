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
                        <h3 class="card-title">Create User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">
                        <div class="form-group">
                            <label>User</label>
                            <select class="form-control" id="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_title">Title</label>
                            <input type="text" class="form-control" id="category_title"
                                placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="category_info">Info</label>
                            <input type="text" class="form-control" id="category_info" placeholder="Enter info">
                        </div>
                        <div class="form-group">
                            <div
                                class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="active" name="active">
                                <label class="custom-control-label" for="active">Active</label>
                            </div>
                        </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="saveCategory()" class="btn btn-primary">Submit</button>
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
<script>
    function saveCategory() {
        axios.post('/cms/admin/categories' , {
            title: document.getElementById('category_title').value,
            info: document.getElementById('category_info').value,
            user_id: document.getElementById('user_id').value,
            active: document.getElementById('active').checked,
        }).then(function(response){
            showMessage(response.data.icon, response.data.message);
        })
        .catch(function(error){
            showMessage(error.response.data.icon, error.response.data.message);
        });
    }

    function showMessage(icon, message) {
            Swal.fire({
                position: 'center',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        }
</script>
@endsection

