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
            <form class="adminFrm" data-action="{{ route('admin.help.support.update') }}" id="addPlanForm" method="post"
                data-class="requiredCheck">
                @csrf
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="hidden" name="help_and_support_id" value="{{ $helpAndSupports->id }}">
                            <label class="control-label required-s">Question</label>
                            <input type="text" class="form-control" multiple name="questions" id="questions" value="{{  $helpAndSupports->questions }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label required-s">Answer</label>
                            <textarea type="text" class="form-control" multiple name="answers" id="answers">{{ $helpAndSupports->answers}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Update</button>
                        <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Update</button>
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
