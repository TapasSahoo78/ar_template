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
            <form class="adminFrm" data-action="{{ route('admin.driver.edit', $driver->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Driver Name." value="{{ $driver->name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Enter Driver Phone." value="{{ $driver->phone }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter Driver Email." value="{{ $driver->email }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Driver Password." value="">
                        </div>
                    </div>
                    {{-- <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Gender</label>
                            <!-- <input type="text" class="form-control float-number" name="longitude" id="longitude"> -->
                            <select name="gender" id="gender" class="form-control float-number">
                                <option>---Select Gender---</option>
                                <option value="male" {{ $driver->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $driver->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $driver->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Image</label>
                            <input type="file" class="form-control float-number" name="img" id="img">
                        </div>
                        <img src="{{ asset('upload/profile/' . $driver->image) }}" width="50" height="50"
                            alt="no img">
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Authorization No.</label>
                            <input type="text" class="form-control" name="authozation_no" id="authozation_no"
                                placeholder="Enter Authorization No." value="{{ $driver->authozation_no }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label required-s">Reg No.</label>
                            <input type="text" class="form-control" name="reg_no" id="reg_no"
                                placeholder="Enter Reg No." value="{{ $driver->reg_no }}">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4 mt-sm">
                        <button type="submit" class="btn btn-primary hidden-xs">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/custom/package.js') }}"></script>
@endpush
