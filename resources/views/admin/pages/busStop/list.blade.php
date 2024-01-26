@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])
@push('styles')
@endpush
@section('content')
    <header class="page-header">
        <h2>Bus Stop Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>Bus Stop</span></li>
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
                    <tbody>
                        @foreach ($busStops as $key => $busStop)
                            <tr>
                                <td colspan="7">
                                    <center>
                                        <h3 class="text-primary"><strong>{{ getRouteById($key) }}</strong></h3>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <th>Sl No.</th>
                                <th>Bus Stop Name</th>
                                <th>Location</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($busStop as $key => $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value?->name }}</td>
                                    <td>{{ $value?->location }}</td>
                                    <td>{{ $value?->latitude }}</td>
                                    <td>{{ $value?->longitude }}</td>
                                    <td>
                                        <a href="{{ route('admin.bus.stop.edit', Crypt::encrypt($value->id)) }}"><i
                                                class="fa fa-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-table="bus_stops" data-status="2" data-key="id"
                                            data-id="{{ $value->id }}" class="text-warning change-status"
                                            data-action="{{ route('admin.bus.stop.delete') }}"><i class="fa fa-trash"
                                                style="color: red"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
