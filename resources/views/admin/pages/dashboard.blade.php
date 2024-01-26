@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Dashboard</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class=""></i></a>
        </div>
    </header>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions"></div>
            <h2 class="panel-title"></h2>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Welcome to Island Bus Admin</h1>
                </div>

                <div class="col-md-4">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Passes</label>
                        <p class="card-text">{{ $data['total_passes'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Users</label>
                        <p class="card-text">{{ $data['total_user'] }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Subscriptions</label>
                        <p class="card-text">{{ $data['total_subscription'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Routes</label>
                        <p class="card-text">{{ $data['total_routes'] }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Bus Stops</label>
                        <p class="card-text">{{ $data['total_bus_stops'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="dashboard-box-items">
                        <label for="" class="card-title">Total Buses</label>
                        <p class="card-text">{{ $data['total_buses'] }}</p>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
