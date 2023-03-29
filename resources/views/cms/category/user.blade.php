@extends('cms.parent')

@section('title', 'Users')

@section('css_content')
<link rel="stylesheet" href="{{ asset('cms/css/style.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Info</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $category)
                                        <tr id="category_{{ $category->id }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>{{ $category->info }}</td>
                                            <td>
                                                @if ($category->active)
                                                    <span style="font-weight: bold; color: green">Active</span>
                                                @else
                                                    <span style="color: red">Not Active</span>
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at ?? '--' }}</td>
                                            <td class="options">
                                                <a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                                                <button class="delete-btn" type="button"
                                                onclick="deleteCategory('{{ $category->id }}')"
                                                style="color: red">Delete</button>
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
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_content')
<script>
    function deleteCategory(id) {
        axios.delete(`/cms/admin/categories/${id}`)
            .then(function(response) {
                document.getElementById(`category_${id}`).remove();
                showMessage('success', response.data.message);
            })
            .catch(function(error) {
                showMessage('error', error.response.data.message);
            })
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
