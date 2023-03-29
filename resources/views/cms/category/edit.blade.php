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
                        <h3 class="card-title">Edit Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        @csrf
                        <div class="card-body">
                        <div class="form-group">
                            <label>User</label>
                            <select class="form-control" id="user_id" >
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_title">Title</label>
                            <input type="text" class="form-control" id="category_title"
                                placeholder="Enter title"  value="{{ $category->title }}">
                        </div>
                        <div class="form-group">
                            <label for="category_info">Info</label>
                            <input type="text" class="form-control" id="category_info" placeholder="Enter info"
                             value="{{ $category->info }}">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="active"
                                    {{-- @checked($category->active)  --}} @if ($category->active)
                                        checked
                                    @endif>
                                <label class="custom-control-label" for="active">Active</label>
                            </div>
                        </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" onclick="updateCategory('{{ $category->id }}')" class="btn btn-primary">Submit</button>
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
    function updateCategory(id) {
            // axios.put('/cms/admin/categories/' + id, {
            axios.put(`/cms/admin/categories/${id}`, {
                    title: document.getElementById('category_title').value,
                    info: document.getElementById('category_info').value,
                    active: document.getElementById('active').checked,
                    user_id: document.getElementById('user_id').value
                 }).then(function(response) {
                     //showMessage(response.data.icon, response.data.message);
                    window.location.href = '/cms/admin/categories';
                })
                .catch(function(error) {
                    showMessage(error.response.data.icon, error.response.data.message);
                })
        }

        function showMessage(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 1500
            })
        }
</script>
@endsection

