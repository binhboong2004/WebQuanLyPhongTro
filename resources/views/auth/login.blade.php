<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập | Quản lý phòng trọ</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">
</head>
<body>
    <div class="background">
        <div class="login-box">
            <h2>Đăng nhập</h2>

            {{-- Thông báo lỗi tổng quát từ Laravel nếu đăng nhập sai --}}
            @if ($errors->has('login_error'))
                <div class="error-msg" style="text-align: center; margin-bottom: 15px;">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf {{-- Bắt buộc phải có để tránh lỗi 419 Page Expired --}}

                {{-- Email Input --}}
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}" 
                           placeholder="admin@smartrent.com" 
                           required 
                           autofocus>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- Password Input --}}
                <div class="input-group">
                    <label for="password">Mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               placeholder="********" 
                               required>
                        <i class="fa-solid fa-eye" id="togglePassword" title="Hiện/Ẩn mật khẩu"></i>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Options: Remember me & Forgot Password --}}
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                        Nhớ mật khẩu
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                    @endif
                </div>

                {{-- Login Button --}}
                <button type="submit" class="login-btn">
                    <span>Đăng nhập</span>
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/auth/script.js') }}"></script>
</body>
</html>