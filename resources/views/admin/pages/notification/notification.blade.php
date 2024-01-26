@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Notification</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>Notification</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class=""></i></a>
        </div>
    </header>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>
            <h2 class="panel-title">Notifications</h2>
        </header>
        <div class="panel-body">
            <form class="adminFrm" data-action="" id="addPlanForm" method="post"
                data-class="requiredCheck">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Notification Title</label>
                            <input type="text" class="form-control" name="notification_title" id="notification_title">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <div class="form-group">
                        <label class="control-label required-s">Notification message</label>
                        <textarea type="text" class="form-control" rows="5" name="notification_message" id="notification_message"></textarea>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Send Notification</button>
                        <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/custom/package.js') }}"></script>
    <script src="{{ asset('assets/custom/common.js') }}"></script>
@endpush
