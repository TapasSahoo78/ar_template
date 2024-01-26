@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Driver Management</h2>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="custDataTable">
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Driver Id</th>
                            <th>Name</th>
                            <th>Phone</th>

                            <th>Authozation No</th>
                            <th>Reg no</th>

                            <th>Email</th>
                            {{-- <th>Image</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $key => $driver)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $driver->customer_id }}</td>
                                <td>{{ $driver->name }}</td>
                                <td>{{ $driver->phone }}</td>
                                <td>{{ $driver->authozation_no ?? 'None' }}</td>
                                <td>{{ $driver->reg_no ?? 'None' }}</td>
                                <td>{{ $driver->email }}</td>
                                {{-- <td>{{ $driver->image }}</td> --}}
                                <td>
                                    <a href="{{ route('admin.driver.edit', Crypt::encrypt($driver->id)) }}"><i
                                            class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.driver.delete', Crypt::encrypt($driver->id)) }}"><i
                                            class="fa fa-trash" style="color: red"></i> </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
