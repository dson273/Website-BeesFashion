@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Sign Up</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Sign Up</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <section class="section-b-space pt-0 login-bg-img">
            <div class="custom-container container login-page">
                <div class="row align-items-center">
                    <div class="col-xxl-7 col-6 d-none d-lg-block">
                        <div class="login-img"> <img class="img-fluid"
                                src="https://themes.pixelstrap.net/katie/assets/images/login/1.svg" alt=""></div>
                    </div>
                    <div class="col-xxl-4 col-lg-6 mx-auto">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h4>Welcome To BeesFashion</h4>
                                <p>Create New Account</p>
                            </div>
                            {{-- Form register --}}
                            <div class="login-box">
                                <form class="row g-3" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('username') is-invalid @enderror"
                                                id="floatingInputValue" type="text" name="username"
                                                placeholder="User Name" value="{{ old('username') }}">
                                            <label for="floatingInputValue">Enter User Name</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('email') is-invalid @enderror"
                                                id="floatingInputValue1" type="email" name="email"
                                                placeholder="name@example.com" value="{{ old('email') }}">
                                            <label for="floatingInputValue1">Enter Your Email</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                id="floatingInputValue2" type="password" name="password"
                                                placeholder="Password">
                                            <label for="floatingInputValue2">Enter Your Password</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="floatingInputValue3" type="password" name="password_confirmation"
                                                placeholder="Re-Password">
                                            <label for="floatingInputValue3">Re-enter Your Password</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <div>
                                                <input class="custom-checkbox me-2" id="category1" type="checkbox"
                                                    name="text">
                                                <label for="category1">I agree with <span>Terms</span> and
                                                    <span>Privacy</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn login btn_black sm" type="submit" data-bs-dismiss="modal"
                                            aria-label="Close">Register</button>
                                    </div>
                                </form>
                            </div>

                            <div class="other-log-in">
                                <h6>OR</h6>
                            </div>
                            <div class="log-in-button">
                                <ul>
                                    <li> <a href="https://www.google.com/" target="_blank"> <i
                                                class="fa-brands fa-google me-2"> </i>Google</a></li>
                                    <li> <a href="https://www.facebook.com/" target="_blank"><i
                                                class="fa-brands fa-facebook-f me-2"></i>Facebook </a></li>
                                </ul>
                            </div>
                            <div class="other-log-in"></div>
                            <div class="sign-up-box">
                                <p>Already have an account?</p><a href="{{ route('login') }}">Log In </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End container content -->
@endsection
