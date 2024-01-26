@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Pass Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>title</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class=""></i></a>
        </div>
    </header>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Pass Name</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Daily Ride</th>
                            <th>Total Ride</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $key => $plan)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $plan->title }}</td>
                                <td>{{ $plan->duration }}</td>
                                <td>{{ $plan->price }}</td>
                                <td>{{ $plan->daily_ride }}</td>
                                <td>{{ $plan->total_ride }}</td>
                                <td>
                                    <a href="{{ route('admin.passcode.edit', Crypt::encrypt($plan->id)) }}"><i
                                            class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-table="plans" data-status="2" data-key="id"
                                        data-id="{{ $plan->id }}" class="text-warning change-status"
                                        data-action="{{ route('admin.passcode.delete') }}"><i class="fa fa-trash"
                                            style="color: red"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
