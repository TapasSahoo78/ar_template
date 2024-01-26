@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Booking Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>booking</span></li>
            </ol>
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
                            <th>Booking No</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>Bus</th>
                            <th>Route</th>
                            <th>Bus Stop</th>
                            <th>Booking Date</th>
                            <th>Booking Time</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data['booking']) > 0)
                            @foreach ($data['booking'] as $key => $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value?->booking_no ?? '' }}</td>
                                    @if ($value?->is_validate == 0)
                                        <td class="text-danger">Not Waiting</td>
                                    @else
                                        <td class="text-success">I am Waiting</td>
                                    @endif


                                    <td>
                                        <p>Name :
                                            {{ $value?->users?->name . '' . $value?->users?->last_name . '(' . $value?->users?->customer_id . ')' }}
                                        </p>
                                        <p>Email : {{ $value?->users?->email }}</p>
                                        <p>Phone : {{ $value?->users?->phone }}</p>
                                    </td>

                                    <td>{{ $value?->bus?->name ?? '' }}</td>
                                    <td>{{ $value?->busRout?->name ?? '' }}</td>
                                    <td>{{ $value?->busStop?->name ?? '' }}</td>

                                    <td>{{ $value?->date ?? '' }}</td>
                                    <td>{{ $value?->time ?? '' }}</td>
                                    {{-- <td>
                                        <a href=""><i class="fa fa-trash" style="color: red"></i> </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <h5>Data not found!</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </section>
@endsection
