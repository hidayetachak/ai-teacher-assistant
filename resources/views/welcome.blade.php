@extends('layouts.app')



@section('content')
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content" data-aos="fade-right">
            <h1>Transform Teaching with <span class="hero-highlight">AI-Powered</span> Assistance</h1>
            <p>AI Teacher Assistant helps teachers create engaging lessons, personalized assignments, and interactive quizzes in seconds - giving you more time to focus on what matters most: your students.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn">Get Started - It's Free</a>
               
            </div>
        </div>
        <div class="hero-image" data-aos="fade-left">
            <svg width="600" height="500" viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg">
                <!-- Background circle -->
                <circle cx="300" cy="250" r="200" fill="#f1f5fe" />
                
                <!-- Tablet/screen -->
                <rect x="190" y="130" width="220" height="300" rx="10" fill="#ffffff" stroke="#4361ee" stroke-width="4" />
                <rect x="200" y="140" width="200" height="260" rx="4" fill="#f1f3fa" />
                
                <!-- Screen content -->
                <!-- Header area -->
                <rect x="210" y="150" width="180" height="30" rx="4" fill="#4361ee" />
                <circle cx="225" cy="165" r="5" fill="#ffffff" />
                <rect x="240" y="160" width="70" height="10" rx="2" fill="#ffffff" />
                
                <!-- Content areas - lesson plan -->
                <rect x="210" y="190" width="180" height="15" rx="2" fill="#3a0ca3" opacity="0.7" />
                <rect x="210" y="215" width="120" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                <rect x="210" y="230" width="150" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                <rect x="210" y="245" width="130" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                
                <!-- Quiz area -->
                <rect x="210" y="270" width="180" height="40" rx="4" fill="#ffffff" stroke="#4cc9f0" stroke-width="2" />
                <rect x="220" y="280" width="120" height="8" rx="2" fill="#212529" opacity="0.8" />
                <rect x="220" y="295" width="80" height="8" rx="2" fill="#f72585" opacity="0.7" />
                
                <!-- Option buttons -->
                <rect x="210" y="320" width="85" height="25" rx="4" fill="#f8f9fa" stroke="#4361ee" stroke-width="1" />
                <rect x="305" y="320" width="85" height="25" rx="4" fill="#4361ee" />
                <rect x="222" y="330" width="60" height="6" rx="1" fill="#6c757d" />
                <rect x="317" y="330" width="60" height="6" rx="1" fill="#ffffff" />
                
                <!-- Progress indicators -->
                <rect x="210" y="355" width="180" height="10" rx="5" fill="#f8f9fa" />
                <rect x="210" y="355" width="120" height="10" rx="5" fill="#f72585" />
                
                <!-- AI brain icon -->
                <circle cx="300" cy="175" r="80" fill="#4361ee" opacity="0.1" />
                <g transform="translate(250, 95) scale(0.1)">
                    <!-- Brain outline -->
                    <path d="M500 900Q350 900 250 800T150 500Q150 350 250 250T500 150Q650 150 750 250T850 500Q850 650 750 750T500 900Z" fill="#4361ee" opacity="0.9" />
                    <!-- Brain connections -->
                    <path d="M350 350Q400 300 500 300T650 350Q700 400 700 500T650 650Q600 700 500 700T350 650Q300 600 300 500T350 350Z" fill="#ffffff" stroke="#4361ee" stroke-width="10" />
                    <path d="M400 400Q450 350 500 350T600 400Q650 450 650 500T600 600Q550 650 500 650T400 600Q350 550 350 500T400 400Z" fill="none" stroke="#ffffff" stroke-width="20" />
                    <path d="M450 450Q475 425 500 425T550 450Q575 475 575 500T550 550Q525 575 500 575T450 550Q425 525 425 500T450 450Z" fill="#f72585" />
                </g>
                
                <!-- Floating elements - paper, notes, etc. -->
                <g transform="translate(115, 290) rotate(-15)">
                    <rect width="70" height="90" rx="2" fill="#ffffff" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="20" x2="60" y2="20" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="35" x2="60" y2="35" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="50" x2="40" y2="50" stroke="#6c757d" stroke-width="1" />
                    <circle cx="15" cy="70" r="5" fill="#f72585" opacity="0.7" />
                </g>
                
                <g transform="translate(420, 210) rotate(10)">
                    <rect width="80" height="60" rx="2" fill="#ffffff" stroke="#6c757d" stroke-width="1" />
                    <rect x="10" y="10" width="60" height="8" rx="1" fill="#6c757d" opacity="0.5" />
                    <rect x="10" y="25" width="40" height="8" rx="1" fill="#6c757d" opacity="0.5" />
                    <rect x="55" y="40" width="15" height="15" rx="2" fill="#4cc9f0" opacity="0.7" />
                </g>
                
                <!-- Circular orbit elements -->
                <g opacity="0.6">
                    <ellipse cx="300" cy="250" rx="240" ry="80" fill="none" stroke="#4361ee" stroke-width="1" stroke-dasharray="5,5" />
                    <ellipse cx="300" cy="250" rx="80" ry="240" fill="none" stroke="#f72585" stroke-width="1" stroke-dasharray="5,5" />
                    
                    <!-- Orbiting elements -->
                    <circle cx="540" cy="250" r="15" fill="#4cc9f0" />
                    <circle cx="300" cy="490" r="15" fill="#f72585" />
                    <circle cx="60" cy="250" r="12" fill="#ffbe0b" />
                    <circle cx="300" cy="10" r="12" fill="#4361ee" />
                    
                    <!-- Small connecting elements -->
                    <circle cx="450" cy="360" r="8" fill="#3a0ca3" />
                    <circle cx="150" cy="140" r="8" fill="#4cc9f0" />
                    <circle cx="450" cy="140" r="8" fill="#f72585" />
                    <circle cx="150" cy="360" r="8" fill="#4361ee" />
                </g>
                
                <!-- Abstract data points and connections -->
                <g opacity="0.7">
                    <line x1="60" y1="250" x2="150" y2="140" stroke="#6c757d" stroke-width="1" />
                    <line x1="150" y1="140" x2="300" y2="10" stroke="#6c757d" stroke-width="1" />
                    <line x1="300" y1="10" x2="450" y2="140" stroke="#6c757d" stroke-width="1" />
                    <line x1="450" y1="140" x2="540" y2="250" stroke="#6c757d" stroke-width="1" />
                    <line x1="540" y1="250" x2="450" y2="360" stroke="#6c757d" stroke-width="1" />
                    <line x1="450" y1="360" x2="300" y2="490" stroke="#6c757d" stroke-width="1" />
                    <line x1="300" y1="490" x2="150" y2="360" stroke="#6c757d" stroke-width="1" />
                    <line x1="150" y1="360" x2="60" y2="250" stroke="#6c757d" stroke-width="1" />
                </g>
                
                <!-- Abstract math symbols -->
                <text x="110" y="200" font-family="monospace" font-size="20" fill="#3a0ca3">x²</text>
                <text x="470" y="300" font-family="monospace" font-size="16" fill="#f72585">∑</text>
                <text x="130" y="390" font-family="monospace" font-size="18" fill="#4cc9f0">π</text>
                <text x="460" y="180" font-family="monospace" font-size="22" fill="#ffbe0b">√</text>
                
                <!-- Small animation indicators -->
                <circle cx="370" cy="100" r="3" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle cx="390" cy="110" r="2" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.5s" repeatCount="indefinite" />
                </circle>
                <circle cx="380" cy="120" r="4" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="1.8s" repeatCount="indefinite" />
                </circle>
                
                <circle cx="220" cy="390" r="3" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="3s" repeatCount="indefinite" />
                </circle>
                <circle cx="200" cy="400" r="2" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.2s" repeatCount="indefinite" />
                </circle>
                <circle cx="210" cy="410" r="4" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.7s" repeatCount="indefinite" />
                </circle>
            </svg>
        </div>
        <div class="canvas-container" id="3d-animation"></div>
    </section>
    
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header" data-aos="fade-up">
            <h2>What AI Teacher Assistant Can Do For You</h2>
            <p>Our intelligent teaching assistant helps you create better educational content in less time, letting you focus on what matters most - your students.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Lesson Planning</h3>
                <p>Create detailed lesson plans for any subject and grade level in minutes. Our AI provides learning objectives, activities, resources, and assessment strategies tailored to your curriculum.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3>Assignment Creation</h3>
                <p>Generate engaging assignments, worksheets, and homework with differentiated options for various learning levels. Get creative ideas that align with your teaching goals.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>Quiz Generation</h3>
                <p>Build formative and summative assessments with a mix of question types. Create multiple-choice, short answer, essay questions and more for any topic or standard.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Progress Tracking</h3>
                <p>Monitor student performance with AI-powered analytics. Identify knowledge gaps and get suggestions for personalized interventions and support.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Differentiated Learning</h3>
                <p>Automatically adapt content for diverse learner needs. Support struggling students with scaffolded material while challenging advanced learners with enrichment options.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>AI Tutoring Support</h3>
                <p>Provide 24/7 tutoring support for your students. Our AI can answer questions, provide explanations, and guide students through problem-solving processes.</p>
            </div>
        </div>
    </section>
    
    <!-- Game Section -->
    <section class="game-section" id="demo">
        <div class="game-container">
            <div class="game-content" data-aos="fade-up">
                <h2>Experience Interactive Learning</h2>
                <p>See how AI Teacher Assistant creates engaging educational experiences for your students. Try out this sample quiz to see our platform in action.</p>
                <div class="game-interface" data-aos="zoom-in">
                    <div class="quiz-container">
                        <div class="quiz-question">
                            What is the primary function of mitochondria in cells?
                        </div>
                        <div class="quiz-options">
                            <div class="quiz-option">A. Cell division</div>
                            <div class="quiz-option correct">B. Energy production</div>
                            <div class="quiz-option">C. Protein synthesis</div>
                            <div class="quiz-option">D. Waste removal</div>
                        </div>
                        <div class="quiz-progress">
                            <div class="quiz-progress-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="benefits" id="benefits">
        <div class="benefits-container">
            <div class="benefits-content" data-aos="fade-right">
                <h2>Why Educators Love AI Teacher Assistant</h2>
                <p>Our AI teaching assistant helps you save time, increase productivity, and deliver more personalized learning experiences for every student in your classroom.</p>
                <ul class="benefits-list">
                    <li class="benefits-item">
                        <div class="benefits-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="benefits-text">
                            <h3>Save Hours Every Week</h3>
                            <p>Reduce lesson planning time by up to 75%, giving you more time to focus on direct student interaction and professional development.</p>
                        </div>
                    </li>
                    <li class="benefits-item">
                        <div class="benefits-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="benefits-text">
                            <h3>Personalize Learning</h3>
                            <p>Create differentiated materials for various skill levels, learning styles, and accommodations with just a few clicks.</p>
                        </div>
                    </li>
                    <li class="benefits-item">
                        <div class="benefits-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="benefits-text">
                            <h3>Fresh Creative Ideas</h3>
                            <p>Never run out of inspiration with AI-generated ideas for engaging activities, projects, and teaching approaches that keep students motivated.</p>
                        </div>
                    </li>
                    <li class="benefits-item">
                        <div class="benefits-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="benefits-text">
                            <h3>Standards Alignment</h3>
                            <p>Automatically align your content with educational standards like Common Core, NGSS, and state-specific frameworks to ensure curriculum compliance.</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="benefits-image" data-aos="fade-left">
            <div class="hero-image" data-aos="fade-left">
            <svg width="600" height="500" viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg">
                <!-- Background circle -->
                <circle cx="300" cy="250" r="200" fill="#f1f5fe" />
                
                <!-- Tablet/screen -->
                <rect x="190" y="130" width="220" height="300" rx="10" fill="#ffffff" stroke="#4361ee" stroke-width="4" />
                <rect x="200" y="140" width="200" height="260" rx="4" fill="#f1f3fa" />
                
                <!-- Screen content -->
                <!-- Header area -->
                <rect x="210" y="150" width="180" height="30" rx="4" fill="#4361ee" />
                <circle cx="225" cy="165" r="5" fill="#ffffff" />
                <rect x="240" y="160" width="70" height="10" rx="2" fill="#ffffff" />
                
                <!-- Content areas - lesson plan -->
                <rect x="210" y="190" width="180" height="15" rx="2" fill="#3a0ca3" opacity="0.7" />
                <rect x="210" y="215" width="120" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                <rect x="210" y="230" width="150" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                <rect x="210" y="245" width="130" height="8" rx="2" fill="#6c757d" opacity="0.5" />
                
                <!-- Quiz area -->
                <rect x="210" y="270" width="180" height="40" rx="4" fill="#ffffff" stroke="#4cc9f0" stroke-width="2" />
                <rect x="220" y="280" width="120" height="8" rx="2" fill="#212529" opacity="0.8" />
                <rect x="220" y="295" width="80" height="8" rx="2" fill="#f72585" opacity="0.7" />
                
                <!-- Option buttons -->
                <rect x="210" y="320" width="85" height="25" rx="4" fill="#f8f9fa" stroke="#4361ee" stroke-width="1" />
                <rect x="305" y="320" width="85" height="25" rx="4" fill="#4361ee" />
                <rect x="222" y="330" width="60" height="6" rx="1" fill="#6c757d" />
                <rect x="317" y="330" width="60" height="6" rx="1" fill="#ffffff" />
                
                <!-- Progress indicators -->
                <rect x="210" y="355" width="180" height="10" rx="5" fill="#f8f9fa" />
                <rect x="210" y="355" width="120" height="10" rx="5" fill="#f72585" />
                
                <!-- AI brain icon -->
                <circle cx="300" cy="175" r="80" fill="#4361ee" opacity="0.1" />
                <g transform="translate(250, 95) scale(0.1)">
                    <!-- Brain outline -->
                    <path d="M500 900Q350 900 250 800T150 500Q150 350 250 250T500 150Q650 150 750 250T850 500Q850 650 750 750T500 900Z" fill="#4361ee" opacity="0.9" />
                    <!-- Brain connections -->
                    <path d="M350 350Q400 300 500 300T650 350Q700 400 700 500T650 650Q600 700 500 700T350 650Q300 600 300 500T350 350Z" fill="#ffffff" stroke="#4361ee" stroke-width="10" />
                    <path d="M400 400Q450 350 500 350T600 400Q650 450 650 500T600 600Q550 650 500 650T400 600Q350 550 350 500T400 400Z" fill="none" stroke="#ffffff" stroke-width="20" />
                    <path d="M450 450Q475 425 500 425T550 450Q575 475 575 500T550 550Q525 575 500 575T450 550Q425 525 425 500T450 450Z" fill="#f72585" />
                </g>
                
                <!-- Floating elements - paper, notes, etc. -->
                <g transform="translate(115, 290) rotate(-15)">
                    <rect width="70" height="90" rx="2" fill="#ffffff" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="20" x2="60" y2="20" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="35" x2="60" y2="35" stroke="#6c757d" stroke-width="1" />
                    <line x1="10" y1="50" x2="40" y2="50" stroke="#6c757d" stroke-width="1" />
                    <circle cx="15" cy="70" r="5" fill="#f72585" opacity="0.7" />
                </g>
                
                <g transform="translate(420, 210) rotate(10)">
                    <rect width="80" height="60" rx="2" fill="#ffffff" stroke="#6c757d" stroke-width="1" />
                    <rect x="10" y="10" width="60" height="8" rx="1" fill="#6c757d" opacity="0.5" />
                    <rect x="10" y="25" width="40" height="8" rx="1" fill="#6c757d" opacity="0.5" />
                    <rect x="55" y="40" width="15" height="15" rx="2" fill="#4cc9f0" opacity="0.7" />
                </g>
                
                <!-- Circular orbit elements -->
                <g opacity="0.6">
                    <ellipse cx="300" cy="250" rx="240" ry="80" fill="none" stroke="#4361ee" stroke-width="1" stroke-dasharray="5,5" />
                    <ellipse cx="300" cy="250" rx="80" ry="240" fill="none" stroke="#f72585" stroke-width="1" stroke-dasharray="5,5" />
                    
                    <!-- Orbiting elements -->
                    <circle cx="540" cy="250" r="15" fill="#4cc9f0" />
                    <circle cx="300" cy="490" r="15" fill="#f72585" />
                    <circle cx="60" cy="250" r="12" fill="#ffbe0b" />
                    <circle cx="300" cy="10" r="12" fill="#4361ee" />
                    
                    <!-- Small connecting elements -->
                    <circle cx="450" cy="360" r="8" fill="#3a0ca3" />
                    <circle cx="150" cy="140" r="8" fill="#4cc9f0" />
                    <circle cx="450" cy="140" r="8" fill="#f72585" />
                    <circle cx="150" cy="360" r="8" fill="#4361ee" />
                </g>
                
                <!-- Abstract data points and connections -->
                <g opacity="0.7">
                    <line x1="60" y1="250" x2="150" y2="140" stroke="#6c757d" stroke-width="1" />
                    <line x1="150" y1="140" x2="300" y2="10" stroke="#6c757d" stroke-width="1" />
                    <line x1="300" y1="10" x2="450" y2="140" stroke="#6c757d" stroke-width="1" />
                    <line x1="450" y1="140" x2="540" y2="250" stroke="#6c757d" stroke-width="1" />
                    <line x1="540" y1="250" x2="450" y2="360" stroke="#6c757d" stroke-width="1" />
                    <line x1="450" y1="360" x2="300" y2="490" stroke="#6c757d" stroke-width="1" />
                    <line x1="300" y1="490" x2="150" y2="360" stroke="#6c757d" stroke-width="1" />
                    <line x1="150" y1="360" x2="60" y2="250" stroke="#6c757d" stroke-width="1" />
                </g>
                
                <!-- Abstract math symbols -->
                <text x="110" y="200" font-family="monospace" font-size="20" fill="#3a0ca3">x²</text>
                <text x="470" y="300" font-family="monospace" font-size="16" fill="#f72585">∑</text>
                <text x="130" y="390" font-family="monospace" font-size="18" fill="#4cc9f0">π</text>
                <text x="460" y="180" font-family="monospace" font-size="22" fill="#ffbe0b">√</text>
                
                <!-- Small animation indicators -->
                <circle cx="370" cy="100" r="3" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle cx="390" cy="110" r="2" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.5s" repeatCount="indefinite" />
                </circle>
                <circle cx="380" cy="120" r="4" fill="#f72585">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="1.8s" repeatCount="indefinite" />
                </circle>
                
                <circle cx="220" cy="390" r="3" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="3s" repeatCount="indefinite" />
                </circle>
                <circle cx="200" cy="400" r="2" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.2s" repeatCount="indefinite" />
                </circle>
                <circle cx="210" cy="410" r="4" fill="#4361ee">
                    <animate attributeName="opacity" values="0.3;1;0.3" dur="2.7s" repeatCount="indefinite" />
                </circle>
            </svg>
        </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-container">
            <div class="section-header" data-aos="fade-up">
                <h2>What Educators Are Saying</h2>
                <p>Thousands of teachers trust AI Teacher Assistant to enhance their teaching practices and save valuable time.</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-content">
                        AI Teacher Assistant has completely transformed my teaching practice. I can create a week's worth of lessons in under an hour, and the quality is incredible. My students are more engaged, and I have so much more time to focus on individual needs.
                    </div>
                    <div class="testimonial-author">
                       
                        <div class="testimonial-info">
                            <h4>Sarah M.</h4>
                            <p>High School Science Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-content">
                        As a new teacher, planning lessons used to take me hours every night. With AI Teacher Assistant, I can create engaging, standards-aligned content in minutes. It's like having a veteran teacher mentor available 24/7.
                    </div>
                    <div class="testimonial-author">
                        
                        <div class="testimonial-info">
                            <h4>James K.</h4>
                            <p>Elementary School Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-content">
                        The differentiation capabilities are amazing. I teach a class with diverse learning needs, and AI Teacher Assistant helps me create materials at different levels without having to start from scratch each time. Game changer!
                    </div>
                    <div class="testimonial-author">
                        
                        <div class="testimonial-info">
                            <h4>Michelle P.</h4>
                            <p>Special Education Coordinator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="price" class="price-section">
    <div class="section-header" data-aos="fade-up">
            <h2>Flexible Plans for Every Need</h2>
            <p>Choose a package that fits your goals—simple, transparent, and value-packed</p>
        </div>

        <div class="price-container row g-4 justify-content-center">
            @foreach($packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 package-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            @if($package->is_featured)
                                <span class="badge bg-success popular-badge">Most Popular</span>
                            @endif
                            <div class="d-flex align-items-center mb-4">
                                <h3 class="card-title h4 mb-0">{{ $package->title }}</h3>
                            </div>
                            <p class="card-text text-muted mb-4">{{ $package->description }}</p>
                            <div class="mb-4">
                            <h4 class="display-6 mb-0 text-start">
                                @if($package->price == 0)
                                    Free
                                @else
                                    ${{ number_format($package->price, 2) }}
                                @endif
                                
                            </h4>
                                <small class="text-muted">Duration: {{ $package->duration }} {{ Str::plural('Days', $package->duration) }}</small>
                            </div>
                            <ul class="list-unstyled mb-4">
                                @php
                                    $features = json_decode($package->features);
                                    if (json_last_error() !== JSON_ERROR_NONE || !$features) {
                                        $features = [];
                                    }
                                @endphp

                                @foreach($features as $feature)
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                                    </li>
                                @endforeach

                                @if(empty($features))
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-muted me-2"></i>No features listed
                                    </li>
                                @endif
                            </ul>

                            <a href="{{ route('home') }}" class="btn package-button w-100">
                                Select Package
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq" id="faq">
        <div class="section-header" data-aos="fade-up">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our AI teacher assistant platform.</p>
        </div>
        <div class="faq-list">
            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-question">
                    How does AI Teacher Assistant assist with lesson planning?
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    AI Teacher Assistant streamlines lesson planning by generating complete lesson plans based on your specified subject, grade level, and learning objectives. You can input your curriculum standards, and our AI will create structured lessons with engaging activities, resources, assessment strategies, and differentiation options. You maintain full control to edit and customize any generated content to perfectly match your teaching style and classroom needs.
                </div>
            </div>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-question">
                    Can I create quizzes for any subject or grade level?
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Absolutely! AI Teacher Assistant can generate quizzes for any subject and grade level, from kindergarten to higher education. Our system supports multiple question types including multiple-choice, true/false, short answer, essay, matching, and more. You can specify difficulty levels, add images, and align questions with specific learning standards. The platform also provides automatic grading for objective questions, saving you even more time.
                </div>
            </div>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-question">
                    Is AI Teacher Assistant content aligned with educational standards?
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Yes, AI Teacher Assistant supports alignment with major educational standards including Common Core, Next Generation Science Standards (NGSS), state-specific standards, and international frameworks like IB and Cambridge. When creating content, you can select specific standards, and our AI will ensure all generated materials support these learning objectives. This makes documentation and compliance much easier while ensuring your teaching remains focused on required outcomes.
                </div>
            </div>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                <div class="faq-question">
                    How secure is my data and my students' information?
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    We take data privacy extremely seriously. AI Teacher Assistant is fully FERPA and COPPA compliant, ensuring all educational data is protected according to federal regulations. We use enterprise-grade encryption for all data transfers and storage. Student data is always under your control, and we never sell or share your information with third parties. Our platform undergoes regular security audits to maintain the highest standards of data protection for educational environments.
                </div>
            </div>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                <div class="faq-question">
                    Do I need technical skills to use AI Teacher Assistant?
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Not at all! AI Teacher Assistant was designed to be extremely user-friendly, even for educators with minimal technical experience. Our intuitive interface guides you through each process with clear prompts and suggestions. We also provide comprehensive onboarding resources, including video tutorials, guides, and live support. Most users are able to create their first lesson plan or quiz within minutes of signing up, with no special training required.
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-container" data-aos="fade-up">
            <h2>Ready to Transform Your Teaching?</h2>
            <p>Join thousands of educators who are saving time and creating better learning experiences with AI Teacher Assistant.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn btn-white">Start Free Trial</a>
                <a href="{{ route('register') }}" class="btn btn-transparent">Schedule Demo</a>
            </div>
        </div>
    </section>
    

   
    
    <!-- JavaScript -->
    <script>
        // Initialize AOS (Animate on Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            // Mobile Menu Toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const navLinks = document.querySelector('.nav-links');
            
            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
            
            // FAQ Accordion
            const faqQuestions = document.querySelectorAll('.faq-question');
            
            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const isActive = this.classList.contains('active');
                    
                    // Close all other FAQs
                    faqQuestions.forEach(q => {
                        q.classList.remove('active');
                        q.nextElementSibling.classList.remove('active');
                    });
                    
                    // Toggle current FAQ
                    if (!isActive) {
                        this.classList.add('active');
                        answer.classList.add('active');
                    }
                });
            });
            
            // Open first FAQ by default
            faqQuestions[0].classList.add('active');
            faqQuestions[0].nextElementSibling.classList.add('active');
            
            // 3D Animation in Hero Section
            initThreeJS();
            
            // Interactive Quiz Demo
            const quizOptions = document.querySelectorAll('.quiz-option');
            
            quizOptions.forEach(option => {
                option.addEventListener('click', function() {
                    quizOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
        
        // Three.js Animation
        function initThreeJS() {
            const container = document.getElementById('3d-animation');
            
            // Create scene, camera, and renderer
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ alpha: true });
            
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setClearColor(0x000000, 0);
            container.appendChild(renderer.domElement);
            
            // Responsive canvas
            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });
            
            // Add lights
            const ambientLight = new THREE.AmbientLight(0x404040, 2);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
            directionalLight.position.set(1, 1, 1);
            scene.add(directionalLight);
            
            // Create floating education-themed objects
            const objects = [];
            const geometry = new THREE.IcosahedronGeometry(1, 0);
            
            // Book
            const bookGeometry = new THREE.BoxGeometry(1.5, 0.2, 1);
            const bookMaterial = new THREE.MeshPhongMaterial({ color: 0x4361ee });
            const book = new THREE.Mesh(bookGeometry, bookMaterial);
            book.position.set(-2, 1, -3);
            scene.add(book);
            objects.push(book);
            
            // Atom
            const atomCore = new THREE.Mesh(
                new THREE.SphereGeometry(0.5, 16, 16),
                new THREE.MeshPhongMaterial({ color: 0xf72585 })
            );
            atomCore.position.set(2, -1, -4);
            scene.add(atomCore);
            objects.push(atomCore);
            
            // Create orbits around atom
            const orbit1 = new THREE.RingGeometry(0.8, 0.85, 32);
            const orbitMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff, side: THREE.DoubleSide });
            const orbitMesh1 = new THREE.Mesh(orbit1, orbitMaterial);
            orbitMesh1.position.copy(atomCore.position);
            scene.add(orbitMesh1);
            
            const orbit2 = new THREE.RingGeometry(1.2, 1.25, 32);
            const orbitMesh2 = new THREE.Mesh(orbit2, orbitMaterial);
            orbitMesh2.position.copy(atomCore.position);
            orbitMesh2.rotation.x = Math.PI / 3;
            scene.add(orbitMesh2);
            
            // Brain
            const brainGeometry = new THREE.SphereGeometry(0.7, 16, 16);
            const brainMaterial = new THREE.MeshPhongMaterial({ color: 0x4cc9f0 });
            const brain = new THREE.Mesh(brainGeometry, brainMaterial);
            brain.position.set(0, 2, -5);
            scene.add(brain);
            objects.push(brain);
            
            // Math symbols
            const plusGeometry = new THREE.TorusGeometry(0.5, 0.1, 8, 4);
            const plusMaterial = new THREE.MeshPhongMaterial({ color: 0xffbe0b });
            const plus = new THREE.Mesh(plusGeometry, plusMaterial);
            plus.position.set(-3, -2, -4);
            scene.add(plus);
            objects.push(plus);
            
            camera.position.z = 5;
            
            // Animation loop
            function animate() {
                requestAnimationFrame(animate);
                
                // Rotate objects
                objects.forEach((obj, index) => {
                    obj.rotation.x += 0.005 + (index * 0.001);
                    obj.rotation.y += 0.007 + (index * 0.001);
                    
                    // Add floating effect
                    obj.position.y += Math.sin(Date.now() * 0.001 + index) * 0.005;
                });
                
                // Rotate orbits
                orbitMesh1.rotation.z += 0.01;
                orbitMesh2.rotation.y += 0.01;
                
                renderer.render(scene, camera);
            }
            
            animate();
        }
    </script>
</body>
</html>
@endsection