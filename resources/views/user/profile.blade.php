@vite(['resources/js/app.js'])
@vite(['resources/js/profile.js'])
@extends('layouts.user.app')
@section('content')
    <div class="profile-form">
        <form class="profile-body" method="POST" action="{{ route('user.update.profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <img id="profileAvatar" class="profile-avatar" src="{{ Storage::url($user->avatar) }}">
            <input type="file" class="avatar-input" name="image" id="inputAvatar">
            <label for="avatar-input">
                <i class="fa-solid fa-pencil avatar-edit" id="btnEditAvatar"></i>
            </label>
            <p id="imageAvatar" class="notify-error"></p>
            <div class="profile-user-name">
                <p>{{ $user->user_name }}</p>
            </div>
            <div class="profile-post">
                <p class="total-post">{{ $user->posts()->count() }} {{ __('home.text_posts') }}</p>
                <p class="total-post like">{{ $user->postLikes()->count() }} {{ __('home.text_likes') }}</p>
            </div>
            <table>
                <tr>
                    <td>
                        <h3>{{ __('home.text_created') }}:</h3>
                    </td>
                    <td class="text-info">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td></td>
                </tr>
                <tr class="row-notify"></tr>
                <tr>
                    <td>
                        <h3>{{ __('home.text_user_name') }}:</h3>
                    </td>
                    <td>
                        <p class="user-name-text text-info">{{ $user->user_name }}</p>
                        <input type="text" class="edit-input" id="inputUserName" name="user_name"
                            value="{{ $user->user_name }}">
                    </td>
                    <td><i class="fa-solid fa-pencil" id="btnEditUserName"></i></td>
                </tr>
                <tr class="row-notify">
                    <td></td>
                    <td>
                        @error('user_name')
                            <p class="notify-error">{{ $message }}</p>
                        @enderror
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <h3>{{ __('home.text_email') }}:</h3>
                    </td>
                    <td class="text-info">{{ $user->email }}</td>
                    <td></td>
                </tr>       
                <tr class="row-notify"></tr>
                <tr>
                    <td>
                        <h3>{{ __('home.text_phone_number') }}:</h3>
                    </td>
                    <td>
                        <p class="phone-number-text text-info">{{ $user->phone_number }}</p>
                        <input type="text" class="edit-input" id="inputPhoneNumber" name="phone_number"
                            value="{{ $user->phone_number }}">
                    </td>
                    <td><i class="fa-solid fa-pencil" id="btnEditPhoneNumber"></i></td>
                </tr>
                <tr class="row-notify">
                    <td></td>
                    <td>
                        @error('phone_number')
                            <p class="notify-error">{{ $message }}</p>
                        @enderror
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <h3>{{ __('home.text_gender') }}:</h3>
                    </td>
                    <td>
                        <p class="gender-text text-info gender">{{ $user->getNameGenders() }}</p>
                        <div class="user-gender" id="inputGender">
                            @foreach ($user->getGenders() as $key => $label)
                                <input type="radio" id="gender_{{ $key }}" name="gender" class="edit-input"
                                    value="{{ $key }}" {{ $user->gender == $key ? 'checked' : '' }}>
                                <label for="gender_{{ $key }}">{{ $label }}</label>
                            @endforeach
                        </div>
                    </td>
                    <td><i class="fa-solid fa-pencil" id="btnEditGender"></i></td>
                </tr>
                <tr class="row-notify">
                    <td></td>
                    <td>
                        @error('gender')
                            <p class="notify-error">{{ $message }}</p>
                        @enderror
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button class="btn-submit-profile" type="submit">{{ __('home.btn_update') }}</button></td>
                    <td></td>
                </tr>
            </table>
        </form>
    </div>
@endsection
