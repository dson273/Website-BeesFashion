<h2>Xin chào {{$email}}</h2>
    <p>Chúc mừng bạn đã đăng ký thành công tài khoản</p>
    <p>Mời bấm xác nhận để tiếp tục sử dụng</p>
    <button>
        <a href="{{route('verifyEmail', $token)}}">Xác thực tài khoản</a>
    </button>
