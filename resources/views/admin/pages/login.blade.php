@extends('admin.layouts.app', ['withOutHeaderSidebar' => false])

@section('content')
    <!-- start: page -->
    <section class="body-sign">
        <div class="center-sign">
            <a href="/" class="logo pull-left">
                <img src="{{asset('assets/images/logo.png')}}" height="54" alt="ARC Admin" />
            </a>

            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                </div>
                <div class="panel-body">
                    <form data-action="{{ route('admin.login.post') }}" class="adminFrm" method="POST"
                        data-class="requiredCheck">
                        @csrf
                        <div class="form-group mb-lg">
                            <label>Username</label>
                            <div class="input-group input-group-icon">
                                <input name="email" id="email" type="text" data-check="Email"
                                    class="form-control input-lg requiredCheck" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-lg">
                            <div class="clearfix">
                                <label class="pull-left">Password</label>
                                {{-- <a href="/lost-password" class="pull-right">Lost Password?</a> --}}
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" id="password" type="password"
                                    class="form-control input-lg requiredCheck" data-check="Password" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 ">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign
                                    In</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <p class="text-center text-muted mt-md mb-md">&copy; Copyright {{ date('Y') }}. All Rights Reserved.</p>

        </div>
    </section>
    <!-- end: page -->
@endsection
