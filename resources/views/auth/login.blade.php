@extends('layouts.home')
@section('content')
    
<div class="main-wrapper login-body" style="background-color: rgb(2, 9, 27)">
    <div class="login-wrapper">
    <div class="container">
        
    {{-- <img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo"> --}}
    <div class="loginbox">
       
    <div class="login-right">
    <div class="login-right-wrap">
        <marquee behavior="" direction="right" ><h1 style="color:  rgb(255, 38, 0)">SCHOOL MANAGER</h1></marquee>
    <h1>Login</h1>
    <p class="account-subtitle">Access to our school manager</p>
    <form method="POST" action="login">
        @csrf
    <div class="form-group">
    <label class="form-control-label">Email Address</label>
    <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
    <label class="form-control-label">Password</label>
    <div class="pass-group">
    <input name="password" type="password" class="form-control pass-input">
    <span class="fas fa-eye toggle-password"></span>
    </div>
    </div>
    <div class="form-group">
    <div class="row">
    <div class="col-6">
    <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="cb1">
    <label class="custom-control-label" for="cb1">Remember me</label>
    </div>
    </div>
    <div class="col-6 text-end">
    <a class="forgot-link" href="forgot-password">Forgot Password ?</a>
    </div>
    </div>
    </div>
    <button class="btn btn-lg btn-block btn- w-100 text-white" style="background-color: rgb(255, 38, 0)" type="submit">Login</button>
    {{-- <div class="login-or">
    <span class="or-line"></span>
    <span class="span-or">or</span>
    </div> --}}
    
    <div class="social-login mb-3">
    {{-- <span>Login with</span> --}}
    {{-- <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a> --}}
    </div>
    
    {{-- <div class="text-center dont-have">Don't have an account yet? <a href="register.html">Register</a></div> --}}
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection