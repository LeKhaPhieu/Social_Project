@vite(['resources/js/app.js'])
@extends('layouts.admin.base')

@section('admin_content')
    <section class="wrapper dashboard">
        <div class="market-updates">
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-2 clearfix">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-book"> </i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>{{ __('admin.posts') }}</h4>
                        <h3>{{ $countPost }}</h3>
                        <p>{{ __('admin.approved') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-1 clearfix">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>{{ __('admin.users') }}</h4>
                        <h3>{{ $countUser }}</h3>
                        <p>{{ __('admin.status_activated') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-3 clearfix">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>{{ __('admin.likes') }}</h4>
                        <h3>{{ $countLike }}</h3>
                        <p>{{ __('admin.post_approved') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-4 clearfix">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-comment" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>{{ __('admin.comments') }}</h4>
                        <h3>{{ $countComment }}</h3>
                        <p>{{ __('admin.post_approved') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <form autocomplete="off">
                @csrf
                <label style="margin-left: 30px; margin-top: 70px;">Start Date:</label>
                <input type="date" id="startDatePost" name="start_date">
                <label style="margin-left: 20px;">End Date:</label>
                <input type="date" id="endDatePost" name="end_date">
                <button style="margin-left: 20px; font-weight: 700;" class="btn btn-info btn-sm" id="btnApplyChartPost"
                    type="button">Apply Chart</button>
                <div class="panel-body">
                    <div class="col-md-12 w3ls-graph">
                        <div class="agileinfo-grap">
                            <div class="agileits-box">
                                <header class="agileits-box-header clearfix">
                                    <h3>{{ __('admin.chart_name_post') }}</h3>
                                    <div class="toolbar"></div>
                                </header>
                                <div class="agileits-box-body clearfix">
                                    <div id="posts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row" style="margin-top: 50px;">
            <form autocomplete="off">
                @csrf
                <label style="margin-left: 30px;">Start Date:</label>
                <input type="date" id="startDateUser" name="start_date">
                <label style="margin-left: 20px;">End Date:</label>
                <input type="date" id="endDateUser" name="end_date">
                <button style="margin-left: 20px; font-weight: 700;" class="btn btn-info btn-sm" id="btnApplyChartUser"
                    type="button">Apply Chart</button>
                <div class="panel-body">
                    <div class="col-md-12 w3ls-graph">
                        <div class="agileinfo-grap">
                            <div class="agileits-box">
                                <header class="agileits-box-header clearfix">
                                    <h3>{{ __('admin.chart_name_user') }}</h3>
                                    <div class="toolbar"></div>
                                </header>
                                <div class="agileits-box-body clearfix">
                                    <div id="users"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
