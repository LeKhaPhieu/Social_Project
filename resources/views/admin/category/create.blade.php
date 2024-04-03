@extends('layouts.admin.base')

@section('admin_content')
    @include('layouts.components.notification')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('admin.title_create_category') }}
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('categories.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category name: </label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="category_name">
                                @error('category_name')
                                    <p class="notify-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info">{{ __('admin.text_btn_create') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
