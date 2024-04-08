@extends('layouts.admin.base')
@section('admin_content')
    @include('layouts.components.notification')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin.title_list_category') }}
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <form class="input-group" action="">
                        <input type="text" class="input-sm form-control" name="key">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Search</button>
                        </span>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>{{ __('admin.number') }}</th>
                            <th>{{ __('admin.category') }}</th>
                            <th>{{ __('admin.create_at') }}</th>
                            <th style="width:75px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $category->name }}</td>
                                <td><span class="text-ellipsis">{{ $category->created_at }}</span></td>
                                <td class="form-inline">
                                    <a href="{{ route('categories.edit', ['category' => $category]) }}" class="active styling-edit form-group"
                                        ui-toggle-class="">
                                        <i class="fa fa-edit text-success text-active"></i>
                                    </a>
                                    <form onclick="return confirm('Are you sure delete this category?')"
                                        action="{{ route('categories.destroy', ['id' => $category]) }}" class="active form-group pull-right"
                                        method="POST" ui-toggle-class="">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-category">
                                            <i class="fa fa-trash-o text-danger text"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('layouts.components.pagination')
    </div>
@endsection
