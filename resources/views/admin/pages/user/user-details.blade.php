@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>{{ $data['users_details']['name'] . ' ' . $data['users_details']['last_name'] . ' ' . 'Pass Details' }} </h2>
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
                    <div class="row">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-6" style="margin-bottom: 10px;">
                            <a href="{{ route('admin.user.getbusPasscode', $data['users_details']['id']) }}"
                                class="btn btn-md btn-primary" style="padding: 1rem;">Bus Pass &nbsp;<i
                                    class="fa far fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subscription No</th>
                            <th>Plan Name</th>
                            <th>Buy Date</th>
                            <th>Expiry Date</th>
                            <th>Duration</th>
                            <th>Daily Ride</th>
                            <th>Total Ride</th>
                            <th>User</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data['subscription']) > 0)
                            @foreach ($data['subscription'] as $key => $value)
                                <tr>
                                    <td style="padding: 14px;">
                                        @if (\Carbon\Carbon::now()->gt($value?->expiry_date))
                                            <p class="text-danger font-weight-bold"
                                                style="transform: rotate(-20deg); background-color: #f8d7da; padding: 6px; border-radius: 5px;">
                                                <strong>Expired</strong>
                                            </p>
                                        @else
                                            <p class="text-success font-weight-bold"
                                                style="transform: rotate(-20deg); background-color: #f8d7da; padding: 6px; border-radius: 5px;">
                                                <strong>Validate</strong>
                                            </p>
                                        @endif
                                    </td>
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
                                                {{-- <a href="{{ route('admin.user.details', $value?->userDetails?->id) }}"><i
                                                        class="fa fa-eye" style="font-size: 16px ; text-align: center"></i>
                                                </a> --}}
                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        @if ($value?->status == 1)
                                            <a href="javascript:void(0)" data-table="subscriptions" data-status="0"
                                                data-key="id" data-id="{{ $value?->id }}"
                                                class="btn btn-md btn-success change-status p-1"
                                                data-action="{{ route('admin.status.change') }}">Active</a>
                                        @else
                                            <a href="javascript:void(0)" data-table="subscriptions" data-status="1"
                                                data-key="id" data-id="{{ $value?->id }}"
                                                class="btn btn-md btn-danger change-status p-1"
                                                data-action="{{ route('admin.status.change') }}">Block</a>
                                        @endif
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
