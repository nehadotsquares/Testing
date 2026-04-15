@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Blogs</h1>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary">Create New Blog</a>
</div>

<table class="table table-bordered table-striped" id="blogs-table">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(function() {
    $('#blogs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('blogs.index') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'author', name: 'user.name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
