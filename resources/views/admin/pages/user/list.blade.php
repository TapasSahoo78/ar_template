@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>User Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>user</span></li>
            </ol>
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
                    <div class="row">
                        <div class="col-md-5">

                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.user.newCustomer') }}" class="btn btn-md btn-primary"
                                style="padding: 1rem;">New User &nbsp;<i class="fa far fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                    <thead>
                        <tr>
                            <th>Sl. No.</th>
                            <th>Customer Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($data); --}}
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->customer_id ?? 'None' }}</td>
                                <td>{{ $user->first_name ?? 'None' }}</td>
                                <td>{{ $user->last_name ?? 'None' }}</td>

                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'None' }}</td>
                                <td>
                                    <a href="{{ route('admin.user.details', $user->id) }}"
                                        class="btn btn-md btn-primary">Pass Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </section>
@endsection
