@extends('layouts.admin.base')
@section('admin_content')
    @include('layouts.components.notification')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin.title_list_post') }}
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <form id="status-filter-form" action="{{ route('posts.index') }}" method="GET">
                        <select id="status-filter" name="status" class="input-sm form-control w-sm inline v-middle">
                            <option value="">All Posts</option>
                            @foreach (App\Models\Post::getStatus() as $key => $status)
                                <option value="{{ $key }}" {{ $key == request()->status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                    </form>
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
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th>{{ __('admin.number') }}</th>
                            <th>{{ __('admin.image') }}</th>
                            <th>{{ __('admin.title') }}</th>
                            <th>{{ __('admin.content') }}</th>
                            <th>{{ __('admin.created_at') }}</th>
                            <th>{{ __('admin.like') }}</th>
                            <th>{{ __('admin.comment') }}</th>
                            <th class="w-sm">{{ __('admin.category') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th style="width:75px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($posts as $index => $post)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>
                                    <a href="{{ route('detail', ['post' => $post]) }}">
                                        <img src="{{ Storage::url($post->image) }}" height="100" width="100">
                                    </a>
                                </td>
                                <td>
                                    <h4>{{ $post->title }}</h4>
                                </td>
                                <td>{!! nl2br(e(Str::limit($post->content, 100))) !!}</td>
                                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                <td>{{ $post->likes()->count() }}</td>
                                <td>{{ $post->comments()->count() }}</td>
                                <td>
                                    @foreach ($post->categories as $category)
                                        {{ $category->name }},
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="text-ellipsis">
                                        <a href="{{ route('posts.update.status', ['id' => $post->id]) }}">
                                            <span
                                                class="text-approve {{ $post->status === \App\Models\Post::APPROVED
                                                    ? 'approved'
                                                    : ($post->status === \App\Models\Post::NOT_APPROVED
                                                        ? 'not-approved'
                                                        : 'inactivated') }}">
                                                {{ $post->status_name }}</span>
                                        </a>
                                    </span>
                                </td>
                                <td class="form-inline">
                                    <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                        class="active styling-edit form-group" ui-toggle-class="">
                                        <i class="fa fa-edit text-success text-active"></i>
                                    </a>
                                    <form onclick="return confirm('Are you sure delete this category?')"
                                        action="{{ route('posts.destroy', ['id' => $post]) }}"
                                        class="active form-group pull-right" method="POST" ui-toggle-class="">
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
        <div class="pagine">
            {{ $posts->withQueryString()->links('layouts.components.pagination') }}
        </div>
    </div>
@endsection
