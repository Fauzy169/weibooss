<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Weiboo Fashion Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
        }

        .register-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side - Logo/Image */
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, #d51243 0%, #8b0a2e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: movePattern 20s linear infinite;
        }

        @keyframes movePattern {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        .logo-container {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .logo-container h1 {
            font-size: 72px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 20px;
            text-shadow: 2px 4px 8px rgba(0,0,0,0.2);
            letter-spacing: -2px;
        }

        .logo-container .tagline {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .decorative-icon {
            position: relative;
            z-index: 1;
            margin-top: 40px;
            font-size: 120px;
            color: rgba(255,255,255,0.2);
        }

        /* Right Side - Form */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #ffffff;
        }

        .form-container {
            width: 100%;
            max-width: 480px;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 15px;
            color: #666;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #d51243;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 14px 48px 14px 45px;
            font-size: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #d51243;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(213, 18, 67, 0.1);
        }

        .form-control.error {
            border-color: #dc3545;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            padding: 14px 16px 14px 45px;
        }

        .error-message {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 16px;
            transition: color 0.3s;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #d51243;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #d51243;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #b00f39;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(213, 18, 67, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #d51243;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 968px) {
            .register-container {
                flex-direction: column;
            }

            .left-side {
                min-height: 300px;
                padding: 40px;
            }

            .logo-container h1 {
                font-size: 48px;
            }

            .decorative-icon {
                font-size: 80px;
                margin-top: 20px;
            }

            .right-side {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side - Logo/Branding -->
        <div class="left-side">
            <div class="logo-container">
                <h1>WEIBOO</h1>
                <p class="tagline">Fashion Store</p>
            </div>
            <i class="fas fa-shopping-bag decorative-icon"></i>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="right-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Daftar sekarang untuk mulai berbelanja</p>
                </div>

                @if($errors->any())
                    <div style="background: #fee; border: 1px solid #fcc; color: #c00; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin: 8px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.perform') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="name" name="name" class="form-control @error('name') error @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Handphone <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') error @enderror" value="{{ old('phone') }}" placeholder="08xx xxxx xxxx" required>
                        </div>
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat Lengkap <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-map-marker-alt input-icon" style="top: 20px;"></i>
                            <textarea id="address" name="address" class="form-control @error('address') error @enderror" placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="form-control @error('password') error @enderror" placeholder="Minimal 8 karakter" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('password')" title="Tampilkan/Sembunyikan Password"></i>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation')" title="Tampilkan/Sembunyikan Password"></i>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.parentElement.querySelector('.password-toggle');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
