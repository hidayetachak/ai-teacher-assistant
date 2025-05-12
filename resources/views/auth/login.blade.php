
@extends('layouts.app')

@section('content')
    <style>
        #login-body {
            display: flex;
            min-height: calc(100vh - 200px); /* Adjust for header/footer */
            align-items: stretch; /* Ensure children stretch to full height */
            margin: 0;
        }
        #login-section {
            flex: 1; /* Take 50% of the space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            background: white;
            border-radius: 0 15px 15px 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        .bg-img {
            flex: 1; 
            position: relative;
            border-radius: 15px 0 0 15px;
          
        }
        .bg-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        .form-control {
            height: 40px;
            padding: 6px 12px;
            font-size: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 10px rgba(26, 26, 26, 0.2);
        }
        .password-container {
            margin-top: 10px;
            position: relative;
        }
        .under-inputs {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;     
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: transform 0.2s ease, background 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }
        .btn-primary:hover {
            background-color: var(--primary);
            color: white;   
            transform: translateY(-2px);
        }
        .btn-link {
            color: #1a1a1a;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        #signup-text {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }
        #signup-text a {
            color: #1a1a1a;
            font-weight: 500;
        }
        #signup-text a:hover {
            text-decoration: underline;
        }
        .text-danger {
            font-size: 0.9rem;
            margin-top: 0.5rem;
            animation: slideIn 0.5s ease;
        }
        .home-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10000;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 5px;
            transition: transform 0.3s ease;
        }
        .home-icon:hover {
            transform: scale(1.1);
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #login-body {
                flex-direction: column;
                min-height: auto;
                padding: 1rem;
            }
            .bg-img {
                width: 100%;
                height: 300px; /* Increased for better visibility */
                border-radius: 15px 15px 0 0;
            }
            .bg-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            #login-section {
                width: 100%;
                border-radius: 0 0 15px 15px;
                padding: 1.5rem;
            }
            #emailBox, #passBox {
                font-size: 18px !important;
            }
            .under-inputs {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .forgot-password {
                margin-top: 0;
            }
            h1 {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 576px) {
            #login-section {
                padding: 1rem;
            }
            .btn-primary {
                padding: 0.75rem;
            }
            .home-icon {
                top: 5px;
                left: 5px;
            }
        }
    </style>

    <div id="login-body">
        <div class="bg-img">
            <img src="{{ asset('assets/login.jpg') }}" alt="Login Background">
        </div>

        <div id="login-section">
            <h1>Log in</h1>
            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

                @if (session('message'))
                    <p class="alert alert-danger bg-danger text-white fw-bold">{{ session('message') }}</p>
                @endif

                <input id="emailBox" class="mb-0 form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="password-container">
                    <input id="passBox" class="mb-0 mt-3 form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="current-password">
                    <i id="togglePassword" class="fa fa-eye-slash" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 24px; transition: all 0.3s ease;"></i>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="under-inputs">
                    @if (Route::has('password.request'))
                    <p class="forgot-password mt-3">
                        <a href="{{ route('password.request') }}" class="text-black">Forgot Password</a>
                    </p>

                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Continue</button>
                <p id="signup-text">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.getElementById("loginForm");
            const emailField = document.getElementById("emailBox");
            const passwordField = document.getElementById("passBox");

            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordField = document.getElementById('passBox');
                const icon = document.getElementById('togglePassword');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
@endsection
