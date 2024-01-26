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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    @foreach ($timetables as $key => $timetable)
                        <tr>
                            <td colspan="9">
                                <center>
                                    <h3 class="text-primary"><strong>{{ getRouteById($key) }}</strong></h3>
                                </center>
                            </td>
                        </tr>

                        @foreach ($timetable as $key => $busVal)
                            {{-- <tr> --}}
                                <td colspan="9">
                                    <center>
                                        <h3 class="text-primary"><strong>{{ getBusById($key) }}</strong></h3>
                                    </center>
                                </td>
                            {{-- </tr> --}}
                            {{-- <tr> --}}
                                {{-- <th>Sl No.</th>
                                <th>Bus Stop Name</th>
                                <th>Timetable</th> --}}
                            {{-- </tr> --}}
                            <tr>
                                @foreach ($busVal as $key => $value)
                                    {{-- <td>{{ ++$key }}</td> --}}
                                    <td>{{ $value?->getBusStop?->name }}</td>
                                    <td>{{ $value?->bus_time }}
                                        <a href="#" data-toggle="modal"
                                            data-target="#timetableModal-{{ $value->id }}"><i class="fa fa-pencil"></i>
                                        </a>
                                    </td>

                                    <!--Timetable Modal -->
                                    <div class="modal fade" id="timetableModal-{{ $value->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                value="{{ $value?->bus_time }}" name="bus_time">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
