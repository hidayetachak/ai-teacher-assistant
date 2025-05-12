
@extends('layouts.app')

@section('content')
    <style>
        #register-body {
            display: flex;
            min-height: calc(100vh - 200px); /* Adjust for header/footer */
            align-items: stretch; /* Ensure children stretch to full height */
            margin: 0;
          
        }
        #register-section {
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
            flex: 1; /* Take 50% of the space */
       
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
        #signin-text {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }
        #signin-text a {
            color: #1a1a1a;
            font-weight: 500;
        }
        #signin-text a:hover {
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
            #register-body {
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
            #register-section {
                width: 100%;
                border-radius: 0 0 15px 15px;
                padding: 1.5rem;
            }
            #nameBox, #emailBox, #passBox, #passConfirmBox {
                font-size: 18px !important;
            }
            h1 {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 576px) {
            #register-section {
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

    <div id="register-body">
        <div class="bg-img">
            <img src="{{ asset('assets/login.jpg') }}" alt="Register Background">
        </div>

        <div id="register-section">
            <h1>Sign Up</h1>
            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf

                @if (session('message'))
                    <p class="alert alert-danger bg-danger text-white fw-bold">{{ session('message') }}</p>
                @endif
                <div class="honeypot-field" style="position: absolute !important; left: -9999px !important; width: 1px; height: 1px; overflow: hidden;">
                        <label for="website"></label>
                        <input type="text" name="website" id="website" value="" autocomplete="off">
                </div>

                <input id="nameBox" class="mb-0 form-control @error('name') is-invalid @enderror" type="text" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input id="emailBox" class="mb-0 mt-3 form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                
                <div class="password-container">
                    <input id="passBox" class="mb-0 mt-3 form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="new-password">
                    <i id="togglePassword" class="fa fa-eye-slash" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 24px; transition: all 0.3s ease;"></i>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="password-container">
                    <input id="passConfirmBox" class="mb-0 mt-3 form-control" type="password" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                    <i id="toggleConfirmPassword" class="fa fa-eye-slash" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 24px; transition: all 0.3s ease;"></i>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
                <p id="signin-text">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Toggle password visibility for Password field
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

            // Toggle password visibility for Confirm Password field
            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                const confirmPasswordField = document.getElementById('passConfirmBox');
                const icon = document.getElementById('toggleConfirmPassword');

                if (confirmPasswordField.type === 'password') {
                    confirmPasswordField.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    confirmPasswordField.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
@endsection