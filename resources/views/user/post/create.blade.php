@vite(['resources/js/post.js'])
@extends('layouts.user.app')
@section('content')
    <div class="layout-form-post update">
        <form action="" method="" enctype="multipart/form-data" class="form-create-blog update">
            <div class="form-head-create">
                <h2>{{ __('home.title_create_blog') }}</h2>
                <button class="btn-submit">{{ __('home.btn_create') }}</button>
            </div>
            <label>{{ __('home.categories_label_sidebar') }}<span>*</span></label>
            <div id="list1" class="dropdown-categories" tabindex="100">
                <span class="anchor">{{ __('home.placeholder_input_category') }}</span>
                <ul class="items">
                    @foreach ($categories as $category)
                        <li>
                            <input type="checkbox" name="category[]" value="{{ $category->id }}">
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <label>{{ __('home.title_label_sidebar') }}<span>*</span></label>
            <input name="title" type="text" placeholder="{{ __('home.placeholder_title') }}" class="form-blog-title update">
            <label>{{ __('home.label_upload_image') }}<span>*</span></label>
            <p id="btnImage" class="form-create-image update">{{ __('home.label_upload_image') }}</p>
            <input type="file" name="image" id="inputImage" class="input-create-image update">
            <div id="imagePreview" class="image-create-preview">
                <img src="jj" alt="">
            </div>
            <label>{{ __('home.label_description') }}<span>*</span></label>
            <textarea name="content" rows="25" cols="70" class="form-blog-content update" placeholder="{{ __('home.placeholder_description') }}"></textarea>
        </form>
    </div>
@endsection
