@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Bus Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>bus</span></li>
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
                            <th>Bus Name</th>
                            <th>Vehicle No</th>
                            <th>Route</th>
                            <th>Departure time</th>
                            <th>Arrival time</th>
                            <th>Assigned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buses as $key => $bus)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $bus->name }}</td>
                                <td>{{ $bus->vehicle_no }}</td>
                                <td>{{ $bus?->getRoute?->name ?? '' }}</td>
                                <td>{{ $bus->from_time }}</td>
                                <td>{{ $bus->to_time }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary driver" data-toggle="modal"
                                        data-target="#exampleModal" data-id="{{ $bus?->id }}"
                                        data-route="{{ $bus?->getRoute?->id }}" data-whatever="@mdo">Driver</button>
                                </td>
                                <td> <a href="{{ route('admin.bus.edit', Crypt::encrypt($bus->id)) }}"><i
                                            class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-table="buses" data-status="2" data-key="id"
                                        data-id="{{ $bus->id }}" class="text-warning change-status"
                                        data-action="{{ route('admin.bus.delete') }}"><i class="fa fa-trash"
                                            style="color: red"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-modal.driver.assigned-driver />
@endsection
@push('scripts')
    <script>
        $(document).on("click", ".driver", function() {
            var stId = $(this).data('id');
            var routeId = $(this).data('route');
            $(".busId").val(stId);
            $(".routeId").val(routeId);
        });
    </script>
@endpush
