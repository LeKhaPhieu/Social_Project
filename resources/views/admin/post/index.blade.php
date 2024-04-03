@extends('layouts.admin.base')
@section('admin_content')
    @include('layouts.components.notification')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                List Blog
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Category</th>
                            <th>Active</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Posts as $index => $post)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td><img src="dsdf" height="100" width="100"></td>
                                <td>
                                    <h4>{{ $post->title }}</h4>
                                </td>
                                <td>{!! nl2br(e(Str::limit($post->content, 100))) !!}</td>
                                <td>{{ $post->category }}</td>
                                <td>
                                    <span class="text-ellipsis">
                                        @if ($post->status === \App\Models\Post::APPROVED)
                                            <a href="{{ route('posts.update.status', ['id' => $post->id]) }}"><span class="text-approve approved">Approved</span></a>
                                        @else
                                            <a href="{{ route('posts.update.status', ['id' => $post->id]) }}"><span class="text-approve not-approved">Unapproved</span></a>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="" class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
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
