@extends('layouts.app')

@section('content')
 @include('layouts.left-sidebar')
<div style="width: 50%; margin: 40px auto; padding: 20px; background-color: #f5f5f5; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h1 style="font-size: 2em; color: #333; margin-bottom: 30px; text-align: center;">Upload File</h1>
    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        <div style="display: flex; flex-direction: column;">
            <label for="title" style="font-size: 1.1em; color: #444; margin-bottom: 8px;">Title</label>
            <input type="text" name="title" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#007bff';" onblur="this.style.borderColor='#ccc';">
        </div>
        <div style="display: flex; flex-direction: column;">
            <label for="file" style="font-size: 1.1em; color: #444; margin-bottom: 8px;">File</label>
            <input type="file" name="file" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; background-color: white;">
        </div>
        <button type="submit" style="padding: 12px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 1.1em; cursor: pointer; transition: background-color 0.3s; width: 200px; margin: 0 auto;" onmouseover="this.style.backgroundColor='#0056b3';" onmouseout="this.style.backgroundColor='#007bff';">Upload</button>
    </form>
</div>
@endsection