@extends('layouts.app')

@section('content')
    <!-- Main Content -->
     @include('layouts.left-sidebar')
    <div style="padding: 20px; max-width: 1200px; margin: 0 auto;">
        <h1 style="font-size: 2em; margin-bottom: 20px;">Files</h1>
        <a href="{{ route('files.create') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Upload New File</a>

        <!-- Form for dynamic limit and ordering -->
        <form method="GET" action="{{ route('files.index') }}" style="margin-bottom: 20px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="limit" style="display: block; margin-bottom: 5px;">Items per page:</label>
                    <select name="limit" id="limit" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" onchange="this.form.submit()">
                        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label for="order_by" style="display: block; margin-bottom: 5px;">Order by:</label>
                    <select name="order_by" id="order_by" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" onchange="this.form.submit()">
                        <option value="title" {{ request('order_by') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Created At</option>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label for="order_direction" style="display: block; margin-bottom: 5px;">Order direction:</label>
                    <select name="order_direction" id="order_direction" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" onchange="this.form.submit()">
                        <option value="asc" {{ request('order_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Files Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Title</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">URL</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Created At</th>
                    <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                <tr>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">{{ $file->title }}</td>
                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        <input type="text" id="url-{{ $file->id }}" value="{{ $file->url }}" readonly style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </td>
                   <td style="padding: 12px; border: 1px solid #dee2e6;">
                        {{ $file->created_at->format('d-M-Y H:i:A') }}
                    </td>

                    <td style="padding: 12px; border: 1px solid #dee2e6;">
                        <button onclick="copyUrl('url-{{ $file->id }}')" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Copy URL</button>
                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 8px 16px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 5px;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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