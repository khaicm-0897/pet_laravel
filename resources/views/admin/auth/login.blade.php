@extends('admin.auth.main')
@section('content')
<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
<span>Easily Using</span>
</h6>
</div>
<div class="card-content">
<div class="text-center">
<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
<span class="fa fa-facebook"></span>
</a>
<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">
<span class="fa fa-twitter"></span>
</a>
<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin">
<span class="fa fa-linkedin font-medium-4"></span>
</a>
<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github">
<span class="fa fa-github font-medium-4"></span>
</a>
</div>
<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
<span>OR Using Account Details</span>
</p>
<div class="card-body">
@if (session('message'))
<div class="alert-danger notification">
<ul style="list-style: none;text-align: center;">
<li>{{ session('message') }}</li>
</ul>
</div>
@elseif (session('message-success'))
<div class="alert-success notification">
<ul style="list-style: none;text-align: center;">
<li>{{ session('message-success') }}</li>
</ul>
</div>
@endif
<form method="POST" class="form-horizontal" action="{{route('admin.login-post')}}" novalidate>
@csrf
<fieldset class="form-group position-relative has-icon-left">
<input type="text" name="phone" class="form-control" id="user-name" placeholder="Số điện thoại" required>
<div class="form-control-position">
<i class="ft-user"></i>
</div>
</fieldset>
<fieldset class="form-group position-relative has-icon-left">
<input type="password" name="password" class="form-control" id="user-password" placeholder="Nhập mật khẩu" required>
<div class="form-control-position">
<i class="fa fa-key"></i>
</div>
</fieldset>
<div class="form-group row">
<div class="col-md-6 col-12 text-center text-sm-left">
<fieldset>
<input type="checkbox" id="remember-me" class="chk-remember">
<label for="remember-me"> Nhớ mật khẩu</label>
</fieldset>
</div>
<div class="col-md-6 col-12 float-sm-left text-center text-sm-right">
    <a href="{{route('admin.forgot-password')}}" class="card-link">Quên mật khẩu?</a>
</div>
</div>
<button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> Đăng nhập</button>
</form>
</div>
<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
<span>New to Stack ?</span>
</p>
<div class="card-body">
<a href="{{route('admin.register')}}" class="btn btn-outline-danger btn-block"><i class="ft-user"></i> Đăng ký</a>
</div>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
</div>
@endsection
