<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Teacher Assistant - Your Smart Teaching Assistant</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.159.0/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
   <!-- Header -->
   <header>
        <nav class="navbar">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-brain"></i>
                AI Teacher Assistant
            </a>
            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#benefits">Benefits</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#faq">FAQ</a></li>
                @auth
                <li><a href="{{ route('login') }}" class="btn btn-outline">Dashboard</a></li>
                @endauth
                @guest
                <li><a href="{{ route('login') }}" class="btn btn-outline">Log In</a></li>

                @endguest
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
           
        </nav>
    </header>
    @yield('content')
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">
                    <i class="fas fa-brain"></i>
                    AI Teacher Assistant
                </div>
                <p>Empowering educators with intelligent tools to create extraordinary learning experiences. Our AI-powered platform helps teachers save time, personalize learning, and engage students more effectively.</p>
                <div class="social-links">
                    <!-- <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a> -->
                </div>
            </div>
            <!-- <div class="footer-links">
                <h3>Product</h3>
                <ul>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Updates</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Webinars</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="#">Training</a></li>
                </ul>
            </div> -->
          
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 AI Teacher Assistant. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>