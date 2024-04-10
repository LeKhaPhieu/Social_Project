@vite(['resources/scss/create_update_post.scss'])
@vite(['resources/js/post.js'])
@extends('layouts.admin.base')

@section('admin_content')
    @include('layouts.components.notification')
    <div class="layout-form update">
        <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data"
            class="form-blog update">
            @csrf
            @method('PUT')
            <h2>Update Post</h2>
            <label>Category <span>*</span></label>
            <select name="category_id" class="form-blog-categories update">
                <option value="0">Categories</option>
                <option value="1">Kinh tế</option>
                <option value="2">Chính trị</option>
                <option value="3">Xã hội</option>
                <option value="4">Giáo dục</option>
            </select>
            <label>Title <span>*</span></label>
            <input name="title" type="text" value="{{ $post->title }}"
                class="form-blog-title update">
            <label>Upload image <span>*</span></label>
            <p id="btnImage" class="form-blog-image update">Upload image</p>
            <input type="file" name="image" id="inputImage" class="input-image-blog update">
            <div id="imagePreview" class="image-preview update">
                <img src="{{ Storage::url($post->image) }}" alt="">
            </div>
            <label>Description <span>*</span></label>
            <textarea name="content" rows="8" cols="70" class="form-blog-content update">{{ $post->content }}</textarea>
            <button class="form-blog-submit">Update blog</button>
        </form>
    </div>
@endsection
