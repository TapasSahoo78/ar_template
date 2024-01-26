@extends('admin.layouts.app', ['withOutHeaderSidebar' => true])

@section('content')
    <header class="page-header">
        <h2>Driver Management</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="/">
                        <i class="fa fa-home"></i> Driver
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
            <form class="adminFrm" data-action="{{ route('admin.driver.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Driver Name.">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Enter Driver Phone.">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter Driver Email.">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Driver Password.">
                        </div>
                    </div>
                    {{-- <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Gender</label>
                            <!-- <input type="text" class="form-control float-number" name="longitude" id="longitude"> -->
                            <select name="gender" id="gender" class="form-control float-number">
                                <option>---Select Gender---</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Image</label>
                            <input type="file" class="form-control float-number" name="img" id="img">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Authorization No.</label>
                            <input type="text" class="form-control" name="authozation_no" id="authozation_no"
                                placeholder="Enter Authorization No.">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Reg No.</label>
                            <input type="text" class="form-control" name="reg_no" id="reg_no"
                                placeholder="Enter Reg No.">
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
@endpush
