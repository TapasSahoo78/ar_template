@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Subscription Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> subscription
                    </a>
                </li>
            </ol>
        </div>
    </header>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>
            {{-- <input type="text" placeholder="Search......"> --}}
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Subscription No</th>
                            <th>Plan Name</th>
                            <th>Buy Date</th>
                            <th>Expiry Date</th>
                            <th>Duration</th>
                            <th>Daily Ride</th>
                            <th>Total Ride</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($subscription) > 0)
                            @foreach ($subscription as $key => $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value?->subscription_no ?? '' }}</td>
                                    <td>{{ $value?->passCodePlan?->title ?? '' }}</td>
                                    <td>{{ $value?->buy_date ?? '' }}</td>
                                    <td>{{ $value?->expiry_date ?? '' }}</td>
                                    <td>{{ $value?->duration ?? '' }}</td>
                                    <td>{{ $value?->daily_ride ?? '' }}</td>
                                    <td>{{ $value?->total_ride ?? '' }}</td>
                                    <td>
                                        <p>{{ $value?->userDetails?->name . ' ' . $value?->userDetails?->last_name }}&nbsp;<span>[
                                                {{ $value?->userDetails?->customer_id ?? '' }} ]</span>&nbsp;
                                            <span>
                                                <a href="{{ route('admin.user.details', $value?->userDetails?->id) }}"><i
                                                        class="fa fa-eye" style="font-size: 16px ; text-align: center"></i>
                                                </a>
                                            </span>
                                        </p>
                                    </td>
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
