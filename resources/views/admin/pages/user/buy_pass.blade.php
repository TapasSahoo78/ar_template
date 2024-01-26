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

            <div class="row">
                @foreach ($data['plans'] as $plan)
                    <div class="col-md-4 mb-4">
                        <div class="card custom-card">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title bg-success text-center" style="padding: 3px;">
                                    <strong>{{ $plan->title }}</strong>
                                </h5>
                                <input type="hidden" name="user_id" value="{{ $data['buyer_id'] }}">
                                <input type="hidden" name="pass_id" value="{{ $plan['id'] }}">
                                <div class="d-flex justify-content-between">
                                    <p class="card-text"><strong>Total Rides:</strong>
                                        <span>{{ $plan->total_ride }}</span>
                                    </p>
                                    <p class="card-text"><strong>Price:</strong> <span>₹
                                            &nbsp;{{ $plan->price }}</span>
                                    </p>
                                </div>
                                <a href="{{ route('admin.user.buyPasscodePage', [$data['buyer_id'], $plan['id']]) }}"
                                    class="btn btn-primary mt-auto">Buy Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/custom/package.js') }}"></script>
@endpush
