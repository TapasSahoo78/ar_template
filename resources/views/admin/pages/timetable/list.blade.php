@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Timetable Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>timetable</span></li>
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

            <div class="row search-panel">
                <div class="col-sm-6"></div>
                <form action="{{ route('admin.timetable.list') }}" method="GET">
                    <div class="col-sm-4">
                        <select name="week_days" id="" class="form-control">
                            {{ getWeekDays(request('week_days') ?? strtolower(now()->format('l'))) }}
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-md btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable111">
                    @if (count($timetables) > 0)
                        @foreach ($timetables as $routeKey => $timetable)
                            <thead>
                                <tr>
                                    <th colspan="{{ count($timetable) }}">
                                        <div class="m-3 text-center">
                                            <h3 class="text-primary"><strong>{{ getRouteById($routeKey) }}</strong></h3>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    @foreach ($timetable as $busKey => $busVal)
                                        <th>{{ getBusById($busKey) }}
                                            {{-- <span class="m-2">
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#e5190b"
                                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                                </svg>
                                            </a>
                                        </span> --}}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    @foreach ($timetable as $busKey => $busVal)
                                        <td>
                                            @foreach ($busVal as $value)
                                                <div style="border: 1px solid #5f535370;padding: 5px;">
                                                    <p>{{ $value?->getBusStop?->name }}</p>
                                                    <p>{{ $value?->bus_time }}
                                                        <span>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#timetableModal-{{ $value->id }}"><i
                                                                    class="fa fa-pencil"></i></a>
                                                        </span>
                                                    </p>
                                                </div>

                                                <!--Timetable Modal -->
                                                <div class="modal fade" id="timetableModal-{{ $value->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    {{ $value?->getBusStop?->name }}
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form class="adminFrm"
                                                                data-action="{{ route('admin.timetable.edit', $value->id) }}"
                                                                method="post" data-class="requiredCheck">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <input type="time" class="form-control"
                                                                            value="{{ $value?->bus_time }}"
                                                                            name="bus_time">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        @endforeach
                    @else
                        <tbody>
                            <tr>
                                <td style="padding: 50px;">
                                    <center>No data found!</center>
                                </td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
