@extends('layouts.admin.base')
@section('admin_content')
    @include('layouts.components.notification')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin.title_list_user') }}
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
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th>{{ __('admin.number') }}</th>
                            <th>{{ __('admin.avatar') }}</th>
                            <th>{{ __('admin.user_name') }}</th>
                            <th>{{ __('admin.email') }}</th>
                            <th>{{ __('admin.phone') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td><img src="{{ Vite::asset('resources/images/user_avatar.png') }}" height="40" width="40"></td>
                                <td>
                                    <h4>{{ $user->user_name }}</h4>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    <span class="text-ellipsis">
                                        <a href="{{ route('users.update.status', ['id' => $user->id]) }}">
                                            <span class="text-approve {{ $user->status === \App\Models\User::ACTIVATED ? 'approved' 
                                                : ($user->status === \App\Models\User::BLOCKED ? 'not-approved' : 'inactivated') }}"
                                            >
                                                {{ $user->status_name }}</span>
                                        </a>
                                    </span>
                                </td>
                                <td>
                                    <form onclick="return confirm('Are you sure delete this user?')"
                                        action="{{ route('users.destroy', ['id' => $user]) }}" class="active"
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
