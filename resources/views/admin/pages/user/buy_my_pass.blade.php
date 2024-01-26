@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])
@push('styles')
    <style>
        .custom-card {
            border: 2px solid #3498db;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .custom-card:hover {
            transform: scale(1.05);
        }
    </style>
@endpush
@section('content')
    <header class="page-header">
        <h2>Buy Pass</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Admin
                    </a>
                </li>
                <li><span>pass</span></li>
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

            <form class="adminFrm" data-action="{{ route('admin.user.buyPasscode') }}" method="post"
                data-class="requiredCheck">
                @csrf
                <div class="row">
                    <input type="hidden" name="plan_id" value="{{ $plan_id }}">
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <input type="hidden" name="currency" value="usd">
                    {{-- <input type="hidden" name="subtotal" value="{{ $subtotal }}"> --}}
                    <input type="hidden" name="subtotal" value="100">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Buy Date</label>
                            <input type="date" class="form-control" name="buy_date" id="buy_date">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Card Number</label>
                            <input type="text" class="form-control float-number" name="number" id="number">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Exp Month</label>
                            <input type="text" class="form-control float-number" name="exp_month" id="exp_month">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Exp Year</label>
                            <input type="text" class="form-control float-number" name="exp_year" id="exp_year">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">CVC</label>
                            <input type="text" class="form-control" name="cvc" id="cvc">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Buy Pass</button>
                        <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Buy Pass</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/custom/package.js') }}"></script>
@endpush
