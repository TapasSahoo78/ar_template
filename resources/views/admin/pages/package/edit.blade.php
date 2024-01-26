@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Pass Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>title</span></li>
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
            <form class="adminFrm" data-action="{{ route('admin.passcode.update') }}" id="addPlanForm" method="post"
                data-class="requiredCheck">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Pass Name</label>
                            <input type="hidden" name="plan_id" value="{{ $plans->id }}">
                            <input type="text" class="form-control requiredCheck" value="{{ $plans->title }}"
                                name="title" id="title">
                            {{-- <select class="form-control requiredCheck" data-check="Type" name="title" id="duration">
                                {{ getPackageNameList('') }}
                            </select> --}}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label required-s">Duration(Number of days)</label>
                            <input type="text" class="form-control float-number requiredCheck"
                                value="{{ $plans->duration }}" name="duration" id="duration">
                            {{-- <select class="form-control requiredCheck" data-check="Type" name="duration" id="duration">
                                {{ getPackageDurationList('') }}
                            </select> --}}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label required-s">Daily Ride</label>
                            <input type="text" class="form-control float-number" name="daily_ride"
                                value="{{ $plans->daily_ride }}" id="daily_ride">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Price</label>
                            <input type="text" class="form-control float-number" multiple name="price" id="price"
                                value="{{ $plans->price }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Total Ride</label>
                            <input type="text" class="form-control float-number" multiple name="total_ride"
                                id="total_ride" value="{{ $plans->total_ride }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="control-label required-s">Description</label>
                            <textarea class="form-control id="description" name="description" rows="4" cols="50">{{ $plans->description }}</textarea>
                        </div>
                    </div>
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
@endpush
