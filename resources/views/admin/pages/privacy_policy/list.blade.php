@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Privacy policy</h2>
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
            <div class="panel-check">
                <a href="{{ route('admin.privacy.policy.add') }}" class="btn btn-md btn-primary">Add+</a>
            </div>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($privacypolicies as $key => $privacypolicy)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $privacypolicy->title }}</td>
                                <td>{{ $privacypolicy->description }}</td>
                                <td>
                                    <a href="{{ route('admin.privacy.policy.edit', $privacypolicy->id) }}"><i
                                            class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-table="privacy_policies" data-status="2"
                                        data-key="id" data-id="{{ $privacypolicy->id }}" class="text-warning change-status"
                                        data-action="{{ route('admin.privacy.policy.delete') }}"><i class="fa fa-trash"
                                            style="color: red"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
