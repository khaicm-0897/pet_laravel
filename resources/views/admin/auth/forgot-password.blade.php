@extends('admin.auth.main')
@section('content')
    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
        <span>We will send you a link to reset password.</span>
    </h6>
</div>

<div class="card-content">
    <div class="card-body">
        <form class="form-horizontal" action="login-simple.html" novalidate>
            <fieldset class="form-group position-relative has-icon-left">
                <input type="email" class="form-control form-control-lg" id="user-email"
                placeholder="Your Email Address" required>
                <div class="form-control-position">
                    <i class="ft-mail"></i>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-outline-primary btn-lg btn-block">
                <i class="ft-unlock"></i> Recover Password
            </button>
        </form>
    </div>
</div>

<div class="card-footer border-0">
    <p class="float-sm-left text-center">
        <a href="{{route('admin.login')}}" class="card-link">Đăng nhập</a>
    </p>
    <p class="float-sm-right text-center">
        New to Stack ? <a href="{{route('admin.register')}}" class="card-link">Đăng ký tài khoản</a>
    </p>
</div>
@endsection
