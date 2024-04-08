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
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Search</button>
                        </span>
                    </div>
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
                            <th>{{ __('admin.category') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Posts as $index => $post)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td><img src="{{ Storage::url($post->image) }}" height="100" width="100"></td>
                                <td>
                                    <h4>{{ $post->title }}</h4>
                                </td>
                                <td>{!! nl2br(e(Str::limit($post->content, 100))) !!}</td>
                                <td>{{ $post->name }}</td>
                                <td>
                                    <span class="text-ellipsis">
                                        @if ($post->status === \App\Models\Post::APPROVED)
                                            <a href="{{ route('posts.update.status', ['id' => $post->id]) }}"><span class="text-approve approved">{{ __('admin.status_approved') }}</span></a>
                                        @else
                                            <a href="{{ route('posts.update.status', ['id' => $post->id]) }}"><span class="text-approve not-approved">{{ __('admin.status_unapproved') }}</span></a>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('posts.edit', ['post' => $post]) }}" class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                    </a>
                                    <form onclick="return confirm('Are you sure delete this category?')"
                                        action="{{ route('posts.destroy', ['id' => $post]) }}" class="active"
                                        method="POST" ui-toggle-class="">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-category">
                                            <i class="fa fa-times text-danger text"></i>
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
