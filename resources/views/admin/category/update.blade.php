@extends('layouts.admin.base')

@section('admin_content')
    @include('layouts.components.notification')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('admin.title_update_category') }}
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Update category: </label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="category_name" value="{{ $category->name }}">
                                @error('category_name')
                                    <p class="notify-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info">{{ __('admin.text_btn_update') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    @endsection
