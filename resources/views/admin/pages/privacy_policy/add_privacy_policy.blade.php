@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Help & Support</h2>
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
            <form class="adminFrm" data-action="{{ route('admin.privacy.policy.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label required-s">Description</label>
                            <textarea type="text" class="form-control" rows="5" name="description" id="description"></textarea>
                        </div>
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
    <script src="{{ asset('assets/custom/common.js') }}"></script>
@endpush
