@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
<header class="page-header">
    <h2>Driver Assigned Management</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="/">
                    <i class="fa fa-home"></i> Bus Stop
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
        <form class="adminFrm" data-action="{{ route('admin.driver.assigneDriver') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-s">Driver</label>
                        <select name="driver_id" id="driver_id" class="form-control">
                            {{getDriver('')}}
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label required-s">Bus</label>
                        <select name="bus_id" id="bus_id" class="form-control">
                            {{getBus('')}}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Save</button>
                    </div>
                </div>
        </form>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('assets/custom/package.js') }}"></script>
@endpush