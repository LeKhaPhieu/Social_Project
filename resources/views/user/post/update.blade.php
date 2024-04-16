@vite(['resources/js/post.js'])
@extends('layouts.user.app')
@section('content')
    @include('layouts.components.notification')
    <div class="layout-form-post update">
        <form action="{{ route('users.post.update', ['id' => $post->id]) }}" method="POST" enctype="multipart/form-data"
            class="form-create-blog update">
            @csrf
            @method('PUT')
            <div class="form-head-create">
                <h2>{{ __('home.text_btn_update') }}</h2>
                <button class="btn-submit">{{ __('home.btn_update') }}</button>
            </div>
            <label>{{ __('home.categories_label_sidebar') }}<span>*</span></label>
            <div id="list1" class="dropdown-categories" tabindex="100">
                <span class="anchor">{{ __('home.placeholder_input_category') }}</span>
                <ul class="items update">
                    @foreach ($categories as $category)
                        <li>
                            <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
                @error('category')
                    <p class="notify-error">{{ $message }}</p>
                @enderror
            </div>
            <label>{{ __('home.title_label_sidebar') }}<span>*</span></label>
            <input name="title" type="text" value="{{ $post->title }}" class="form-create-title update">
            @error('title')
                <p class="notify-error">{{ $message }}</p>
            @enderror
            <label>{{ __('home.label_upload_image') }}<span>*</span></label>
            <p id="btnImage" class="form-create-image update">{{ __('home.label_upload_image') }}</p>
            <input type="file" name="image" id="inputImage" class="input-create-image update">
            <div id="imagePreview" class="image-create-preview update">
                <img src="{{ Storage::url($post->image) }}" alt="">
            </div>
            <label>{{ __('home.label_description') }}<span>*</span></label>
            <textarea name="content" rows="25" cols="70" class="form-blog-content update"
                placeholder="{{ __('home.placeholder_description') }}">{{ $post->content }}</textarea>
            @error('content')
                <p class="notify-error">{{ $message }}</p>
            @enderror
        </form>
    </div>
@endsection
