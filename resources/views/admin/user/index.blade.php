@extends('layouts.admin.base')
@section('admin_content')
    @include('layouts.components.notification')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                List Users
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Active</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Users as $index => $user)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td><img src="{{ Vite::asset('resources/images/user_avatar.png') }}" height="40" width="40"></td>
                                <td>
                                    <h4>{{ $user->user_name }}</h4>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    <span class="text-ellipsis">
                                        @if ($user->status === \App\Models\User::ACTIVATED)
                                            <a href="{{ route('users.update.status', ['id' => $user->id]) }}">
                                                <span class="text-approve approved">Activated</span>
                                            </a>
                                        @elseif ($user->status === \App\Models\User::BLOCKED)
                                            <a href="{{ route('users.update.status', ['id' => $user->id]) }}">
                                                <span class="text-approve not-approved">Blocked</span>
                                            </a>
                                        @elseif ($user->status === \App\Models\User::INACTIVATED)
                                            <p>
                                                <span class="text-approve inactivated">Inactivated</span>
                                            </p>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <form onclick="return confirm('Are you sure delete this user?')"
                                        action="{{ route('users.destroy', ['id' => $user]) }}" class="active"
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
