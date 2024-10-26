@extends('user.layouts.master')

@section('content')
    <!-- Container content -->
    <main>
        <section class="section-b-space pt-0">
            <div class="heading-banner">
                <div class="custom-container container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Forgot Password</h4>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ul class="breadcrumb float-end">
                                <li class="breadcrumb-item"> <a href="index.html">Home </a></li>
                                <li class="breadcrumb-item active"> <a href="#">Forgot Password</a></li>
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
                                <p>Forgot your password</p>
                            </div>
                            <div class="login-box">
                                <form id="form-forgot" action="{{ route('forgot-processing') }}" class="row g-3"
                                    method="POST">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" type="email" placeholder="name@example.com"
                                                value="{{ old('email') }}"><label for="floatingInputValue">Enter Your
                                                Email</label>
                                            {{-- Hiển thị thông báo lỗi --}}
                                            <span class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input class="btn login btn_black sm" type="submit" value="Send">
                                    </div>
                                </form>
                            </div>
                            <div class="other-log-in"></div>
                            <div class="sign-up-box">
                                <a class="text-decoration-underline" href="{{ route('login') }}">Back To Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Button trigger modal -->
        <button type="button" id="notification" style="display: none;" data-bs-toggle="modal"
            data-bs-target="#modal-forgot"></button>

        {{-- Modal logout --}}
        <div class="modal theme-modal fade confirmation-modal" id="modal-forgot" tabindex="-1" role="dialog"
            aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"> <img class="img-fluid" src="{{ asset('assets/images/gif/success-notification.gif') }}"
                            alt="">
                        <h4>Notification</h4>
                        <p>New password has been sent to your email.</p>
                        <div class="submit-button"> <button class="btn" type="submit" data-bs-dismiss="modal"
                                aria-label="Close">Ok</button><a class="btn" href="{{ route('login') }}">Login</a></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End logout --}}
    </main>
    <!-- End container content -->
@endsection

@section('script-libs')
    <script>
        $(document).ready(function() {
            $('#form-forgot').on('submit', function(event) {
                event.preventDefault();

                let email = $('input[name="email"]').val().trim();
                let _token = $('input[name="_token"]').val();
                let url = $(this).attr('action');

                // Xóa các lỗi cũ
                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        email: email,
                        _token: _token,
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Hiển thị modal thông báo thành công
                        $('#notification').click();
                        // Reset form sau khi gửi thành công
                        $('#form-forgot')[0].reset();
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            let errors = error.responseJSON.errors;
                            for (let key in errors) {
                                let input = $('input[name="' + key + '"]');
                                let errMsg = errors[key][0];

                                // Hiển thị thông báo lỗi ngay bên dưới input
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    input.closest('.form-floating').find('.invalid-feedback').text(errMsg);
                                }
                            }
                        } else {
                            console.error("Error occurred, but no error data returned.");
                        }
                    }
                });
            });
        });
    </script>
@endsection