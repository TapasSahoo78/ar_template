@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Timetable Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('admin.timetable.list') }}">
                        <i class="fa fa-home"></i> Timetable
                    </a>
                </li>
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
            <form class="adminFrm" data-action="{{ route('admin.timetable.store') }}" method="post"
                data-class="requiredCheck">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Route</label>
                                <select class="form-control requiredCheck" data-check="Type" name="route_id"
                                    id="route-dropdown">
                                    {{ getRoute('') }}
                                </select>
                            </div>
                        </div>

                        <!----------------------------- Bus List ------------------------------------------->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Bus</label>
                                <select class="form-control requiredCheck" data-check="Type" name="bus_id"
                                    id="bus-dropdown">

                                </select>
                            </div>
                        </div>
                    </div>
                    <!----------------------------------------------------------------------------------->
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label required-s">Week Day</label>
                                <select name="week_days" id="week-dropdown" class="form-control">
                                    <option value="">Select Week Day</option>
                                    {{ getWeekDays(strtolower(now()->format('l'))) }}
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label required-s">Departure time</label>
                            <input type="time" class="form-control" id="start_time" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label required-s">Arrival time</label>
                            <input type="time" class="form-control" id="end_time" readonly>
                        </div>
                    </div> --}}

                    <!-------------------------- Start and End Time -------------------------------------->

                    <!------------------------------------------------------------------------------------>

                    <!-------------------------------- Bus Stop with Time -------------------------------->
                    <div id="busStop" style="display: none;">

                    </div>
                    <!------------------------------------------------------------------------------------>

                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Save</button>
                        <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/custom/package.js') }}"></script>
    <script>
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $(document).ready(function() {
            let idRoute, idBus;
            /* Route Dropdown Change Event */
            $('#route-dropdown').on('change', function() {
                idRoute = this.value;

                if (idRoute === '') {
                    //$("#start_time, #end_time").val("");
                    $('#busStop').html("");
                }

                $("#bus-dropdown").html('');
                $.ajax({
                    url: "{{ route('ajax.fetch.bus') }}",
                    type: "POST",
                    data: {
                        route_id: idRoute,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#bus-dropdown').html('<option value="">-- Select Bus --</option>');

                        var busOptions = result.bus.map(function(value) {
                            return '<option value="' + value.id + '">' + value.name +
                                '</option>';
                        });

                        $("#bus-dropdown").append(busOptions.join(''));

                        var htmlBody = result.bus_stop.map(function(value, key) {
                            return `
                    <div class="col-sm-12">
                    <div class="col-sm-2">
                        <span>${key + 1}</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <input type="text" class="form-control" value="${value.name}" readonly>
                            <input type="hidden" class="form-control" name="bus_stop_id[]" value="${value.id}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="time" class="form-control" name="time_with_stop[]">
                        </div>
                    </div>
                    </div>`;
                        });

                        $('#busStop').html(htmlBody.join(''));
                    }
                });
            });
            /* Bus Dropdown Change Event */
            $('#bus-dropdown').on('change', function() {
                idBus = this.value;

                if (idBus === '') {
                    // $("#start_time, #end_time").val("");
                    $('#busStop').html("");
                }

                $.ajax({
                    url: "{{ route('ajax.fetch.bus.time') }}",
                    type: "POST",
                    data: {
                        bus_id: idBus,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        // $("#start_time").val(res.bus_time.from_time);
                        // $("#end_time").val(res.bus_time.to_time);

                        $("#busStop").css("display", "block");
                    }
                });
            });
            /* Route Change Event  and Bus Change Event*/
            $('#route-dropdown,#bus-dropdown,#week-dropdown').on('change', function() {
                // Get the selected values:
                var route = $('#route-dropdown').val();
                var bus = $('#bus-dropdown').val();
                var week = $('#week-dropdown').val();
                // Use the values for further processing:
                console.log("Selected values: Route:", route, "Bus:", bus, "Week:", week);

                // Example: Send values to a server-side script
                $.ajax({
                    url: "{{ route('ajax.fetch.time.table') }}",
                    type: 'POST',
                    data: {
                        route: route,
                        bus: bus,
                        week: week,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.timetable.length);

                        if (response.timetable.length == 0) {
                            $("#busStop").css("display", "block");
                        } else {
                            $("#busStop").css("display", "none");
                            $.alert({
                                icon: 'fa fa-warning',
                                title: "Warning!",
                                content: "You have already added time this route with bus stop.Please go to list and update or chnage your time!",
                                type: 'orange',
                                typeAnimated: true
                            });
                        }
                    }
                });

            });
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    </script>
@endpush
