@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Route Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $key => $route)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $route->name }}</td>
                                <td>
                                    <a href="{{ route('admin.route.edit', Crypt::encrypt($route->id)) }}"><i
                                            class="fa fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-table="routes" data-status="2" data-key="id"
                                        data-id="{{ $route->id }}" class="text-warning change-status"
                                        data-action="{{ route('admin.route.delete') }}"><i class="fa fa-trash"
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
