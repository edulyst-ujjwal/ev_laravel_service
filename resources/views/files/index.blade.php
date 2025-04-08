@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Files</h1>
    <a href="{{ route('files.create') }}" class="btn btn-primary">Upload New File</a>

    <!-- Form for dynamic limit and ordering -->
    <form method="GET" action="{{ route('files.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <label for="limit">Items per page:</label>
                <select name="limit" id="limit" class="form-control" onchange="this.form.submit()">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="order_by">Order by:</label>
                <select name="order_by" id="order_by" class="form-control" onchange="this.form.submit()">
                    <option value="title" {{ request('order_by') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Created At</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="order_direction">Order direction:</label>
                <select name="order_direction" id="order_direction" class="form-control" onchange="this.form.submit()">
                    <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Files Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>URL</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td>{{ $file->title }}</td>
                <td>
                    <input type="text" id="url-{{ $file->id }}" value="{{ $file->url }}" readonly class="form-control" style="width: 300px;">
                </td>
                <td>{{ $file->created_at }}</td>
                <td>
                    <button onclick="copyUrl('url-{{ $file->id }}')" class="btn btn-secondary">Copy URL</button>
                    <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $files->appends(request()->query())->links() }}
    </div>
</div>

<script>
    function copyUrl(elementId) {
        const inputElement = document.getElementById(elementId);
        inputElement.select();
        inputElement.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(inputElement.value)
            .then(() => {
                alert('URL copied to clipboard: ' + inputElement.value);
            })
            .catch((error) => {
                console.error('Failed to copy URL: ', error);
                alert('Failed to copy URL. Please try again.');
            });
    }
</script>
@endsection