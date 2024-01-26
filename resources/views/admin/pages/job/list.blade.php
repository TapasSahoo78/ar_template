@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
<header class="page-header">
    <h2>Job Management</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="/">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li><span>Job</span></li>
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
                        <th>Name</th>
                        <th>Vehicle No</th>
                        <th>Departure time</th>
                        <th>Arrival time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $key => $job)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $bus->name }}</td>
                        <td>{{ $bus->vehicle_no }}</td>
                        <td>{{ $bus->from_time }}</td>
                        <td>{{ $bus->to_time }}</td>
                        <td>
                            <a href="{{ route('admin.bus.edit', Crypt::encrypt($bus->id)) }}"><i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ route('admin.bus.delete', Crypt::encrypt($bus->id)) }}"><i class="fa fa-trash" style="color: red"></i> </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
