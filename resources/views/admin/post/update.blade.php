@vite(['resources/scss/update_post_admin.scss'])
@vite(['resources/js/post.js'])
@extends('layouts.admin.base')

@section('admin_content')
    @include('layouts.components.notification')
    <div class="layout-form update">
        <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data"
            class="form-blog update">
            @csrf
            @method('PUT')
            <h2>{{ __('admin.title_update_post') }}</h2>
            <label>{{ __('admin.label_category') }}<span>*</span></label>
            <div id="list1" class="dropdown-check-list" tabindex="100">
                <span class="anchor">Categories</span>
                <ul class="items">
                    @foreach ($categories as $category)
                        <li>
                            <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <label>{{ __('admin.label_title') }}<span>*</span></label>
            <input name="title" type="text" value="{{ $post->title }}" class="form-blog-title update">
            <label>{{ __('admin.label_upload_img') }}<span>*</span></label>
            <p id="btnImage" class="form-blog-image update">{{ __('admin.label_upload_img') }}</p>
            <input type="file" name="image" id="inputImage" class="input-image-blog update">
            <div id="imagePreview" class="image-preview update">
                <img src="{{ Storage::url($post->image) }}" alt="">
            </div>
            <label>{{ __('admin.label_description') }}<span>*</span></label>
            <textarea name="content" rows="8" cols="70" class="form-blog-content update">{{ $post->content }}</textarea>
            <button class="form-blog-submit">{{ __('admin.text_btn_update') }}</button>
        </form>
    </div>
@endsection
