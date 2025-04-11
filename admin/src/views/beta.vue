<!-- @format -->

<template>
  <div class="app-container">
    <!-- Header with improved logo placement and styling -->
    <header class="header">
      <div class="logo-container">
        <img src="/image/logo.png" alt="ADFC Logo" class="logo" />
        <h1 class="brand-name">ADFC</h1>
      </div>
      <nav class="main-nav">
        <ul>
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </nav>
      <div class="auth-buttons">
        <button @click="showLoginModal = true" class="btn auth-btn login">
          Login
        </button>
        <button @click="showRegisterModal = true" class="btn auth-btn register">
          Register
        </button>
      </div>
    </header>

    <!-- Main content area with enhanced hero section and service cards -->
    <main>
      <section class="hero-section">
        <div class="hero-content">
          <div class="badge">Innovative Education Tool</div>
          <h2>E-Class Record Management System</h2>
          <p>
            A user-friendly platform designed to help teachers efficiently
            manage student records, track grades, and generate performance
            insights with ease.
          </p>
          <div class="cta-buttons">
            <button @click="showRegisterModal = true" class="btn primary">
              Get Started
            </button>
            <button class="btn secondary">Learn More</button>
          </div>
          <div class="stats-container">
            <div class="stat-item">
              <span class="stat-number">5,000+</span>
              <span class="stat-label">Active Users</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">200+</span>
              <span class="stat-label">Schools</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">98%</span>
              <span class="stat-label">Satisfaction</span>
            </div>
          </div>
        </div>
        <div class="hero-image-container">
          <div class="shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
          </div>
          <div class="hero-image">
            <!-- Enhanced image placeholder with floating elements -->
            <div class="floating-card card-1">
              <div class="card-icon">📊</div>
              <div class="card-text">Grade Analytics</div>
            </div>
            <div class="floating-card card-2">
              <div class="card-icon">🎓</div>
              <div class="card-text">Smart Reports</div>
            </div>
          </div>
        </div>
      </section>

      <section class="features-highlight">
        <div class="feature-highlight-item">
          <div class="feature-icon">⚡</div>
          <div class="feature-text">Fast & Reliable</div>
        </div>
        <div class="feature-highlight-item">
          <div class="feature-icon">🔒</div>
          <div class="feature-text">Secure Data</div>
        </div>
        <div class="feature-highlight-item">
          <div class="feature-icon">📱</div>
          <div class="feature-text">Mobile Friendly</div>
        </div>
        <div class="feature-highlight-item">
          <div class="feature-icon">🔄</div>
          <div class="feature-text">Real-time Updates</div>
        </div>
      </section>

      <section class="services-section">
        <h2 class="section-title">Our Services</h2>
        <div class="service-cards">
          <div class="service-card">
            <div class="service-icon">📊</div>
            <h3>Grade Management</h3>
            <p>
              Easily input, track, and analyze student grades with our intuitive
              interface.
            </p>
            <a href="#" class="service-link">Learn more</a>
          </div>
          <div class="service-card">
            <div class="service-icon">📝</div>
            <h3>Attendance Tracking</h3>
            <p>
              Monitor student attendance and generate reports with just a few
              clicks.
            </p>
            <a href="#" class="service-link">Learn more</a>
          </div>
          <div class="service-card">
            <div class="service-icon">📈</div>
            <h3>Performance Analytics</h3>
            <p>
              Gain valuable insights into student performance through detailed
              analytics.
            </p>
            <a href="#" class="service-link">Learn more</a>
          </div>
          <div class="service-card">
            <div class="service-icon">📱</div>
            <h3>Mobile Access</h3>
            <p>
              Access your class records anytime, anywhere with our
              mobile-friendly platform.
            </p>
            <a href="#" class="service-link">Learn more</a>
          </div>
        </div>
      </section>

      <section class="testimonials-section">
        <h2 class="section-title">What Our Users Say</h2>
        <div class="testimonials-container">
          <div class="testimonial-card">
            <div class="quote">
              "This system has transformed how I manage my classroom records.
              Highly recommended!"
            </div>
            <div class="author">
              <div class="author-avatar"></div>
              <div class="author-info">
                <div class="author-name">Sarah Johnson</div>
                <div class="author-role">High School Teacher</div>
              </div>
            </div>
          </div>
          <div class="testimonial-card">
            <div class="quote">
              "The analytics feature has given me valuable insights into student
              performance patterns."
            </div>
            <div class="author">
              <div class="author-avatar"></div>
              <div class="author-info">
                <div class="author-name">Michael Chen</div>
                <div class="author-role">Department Head</div>
              </div>
            </div>
          </div>
          <div class="testimonial-card">
            <div class="quote">
              "Our school has seen a 40% reduction in administrative work since
              implementing this system."
            </div>
            <div class="author">
              <div class="author-avatar"></div>
              <div class="author-info">
                <div class="author-name">Patricia Rivera</div>
                <div class="author-role">School Principal</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="features-section">
        <h2 class="section-title">Key Features</h2>
        <div class="features-grid">
          <div class="feature">
            <div class="feature-header">
              <div class="feature-icon-circle">
                <span class="feature-icon">🖥️</span>
              </div>
              <h3>User-Friendly Interface</h3>
            </div>
            <p>Intuitive design for easy navigation and efficient workflow.</p>
          </div>
          <div class="feature">
            <div class="feature-header">
              <div class="feature-icon-circle">
                <span class="feature-icon">⚡</span>
              </div>
              <h3>Real-Time Updates</h3>
            </div>
            <p>Instantly sync changes across all devices and user accounts.</p>
          </div>
          <div class="feature">
            <div class="feature-header">
              <div class="feature-icon-circle">
                <span class="feature-icon">🔒</span>
              </div>
              <h3>Secure Data Storage</h3>
            </div>
            <p>
              Advanced encryption to keep sensitive student information safe.
            </p>
          </div>
          <div class="feature">
            <div class="feature-header">
              <div class="feature-icon-circle">
                <span class="feature-icon">📊</span>
              </div>
              <h3>Customizable Reports</h3>
            </div>
            <p>
              Generate personalized reports based on your specific requirements.
            </p>
          </div>
        </div>
      </section>

      <section class="cta-section">
        <div class="cta-content">
          <h2>Ready to Transform Your Classroom Management?</h2>
          <p>
            Join thousands of educators who have simplified their record
            keeping.
          </p>
          <button @click="showRegisterModal = true" class="btn cta-btn">
            Get Started Today
          </button>
        </div>
      </section>
    </main>

    <!-- Footer with improved design and additional links -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-info">
          <div class="footer-logo">
            <img
              src="/image/logo.png"
              alt="ADFC Logo"
              class="footer-logo-img" />
            <span>ADFC</span>
          </div>
          <p class="footer-description">
            Empowering educators with intuitive tools for effective classroom
            management and student performance tracking.
          </p>
          <div class="social-links">
            <a href="#" class="social-link">FB</a>
            <a href="#" class="social-link">TW</a>
            <a href="#" class="social-link">IG</a>
            <a href="#" class="social-link">LI</a>
          </div>
        </div>
        <div class="footer-links">
          <div class="link-group">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
          <div class="link-group">
            <h4>Resources</h4>
            <ul>
              <li><a href="#">Help Center</a></li>
              <li><a href="#">Documentation</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Tutorials</a></li>
            </ul>
          </div>
          <div class="link-group">
            <h4>Legal</h4>
            <ul>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Terms of Service</a></li>
              <li><a href="#">Data Policy</a></li>
              <li><a href="#">Cookies</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-newsletter">
          <h4>Stay Updated</h4>
          <p>Subscribe to our newsletter for updates and new features.</p>
          <div class="newsletter-form">
            <input type="email" placeholder="Enter your email" />
            <button class="btn subscribe">Subscribe</button>
          </div>
        </div>
      </div>
      <div class="copyright">
        <p>
          &copy; 2025 ADFC E-Class Record Management System. All rights
          reserved.
        </p>
      </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal-overlay" v-if="showLoginModal" @click="closeModals">
      <div class="modal login-modal" @click.stop>
        <div class="modal-header">
          <h3>Login to Your Account</h3>
          <button class="close-btn" @click="showLoginModal = false">×</button>
        </div>
        <div class="modal-body">
          <form class="login-form" @submit.prevent="handleLogin">
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                placeholder="Enter your email"
                required />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input
                type="password"
                id="password"
                placeholder="Enter your password"
                required />
              <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            <div class="form-group remember-me">
              <input type="checkbox" id="remember" />
              <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn submit-btn">Login</button>
          </form>
          <div class="social-login">
            <p>Or login with</p>
            <div class="social-buttons">
              <button class="social-btn google">G</button>
              <button class="social-btn facebook">f</button>
              <button class="social-btn apple">a</button>
            </div>
          </div>
          <div class="modal-footer">
            <p>
              Don't have an account?
              <a href="#" @click="switchToRegister">Register</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Register Modal -->
    <div class="modal-overlay" v-if="showRegisterModal" @click="closeModals">
      <div class="modal register-modal" @click.stop>
        <div class="modal-header">
          <h3>Create an Account</h3>
          <button class="close-btn" @click="showRegisterModal = false">
            ×
          </button>
        </div>
        <div class="modal-body">
          <div class="register-types">
            <button class="register-type-btn active">Teacher</button>
            <button class="register-type-btn">Administrator</button>
            <button class="register-type-btn">School</button>
          </div>
          <form class="register-form" @submit.prevent="handleRegister">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName">First Name</label>
                <input
                  type="text"
                  id="firstName"
                  placeholder="Enter first name"
                  required />
              </div>
              <div class="form-group">
                <label for="lastName">Last Name</label>
                <input
                  type="text"
                  id="lastName"
                  placeholder="Enter last name"
                  required />
              </div>
            </div>
            <div class="form-group">
              <label for="regEmail">Email</label>
              <input
                type="email"
                id="regEmail"
                placeholder="Enter your email"
                required />
            </div>
            <div class="form-group">
              <label for="school">School</label>
              <input
                type="text"
                id="school"
                placeholder="Enter your school name"
                required />
            </div>
            <div class="form-group">
              <label for="regPassword">Password</label>
              <input
                type="password"
                id="regPassword"
                placeholder="Create a password"
                required />
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input
                type="password"
                id="confirmPassword"
                placeholder="Confirm your password"
                required />
            </div>
            <div class="form-group terms">
              <input type="checkbox" id="terms" required />
              <label for="terms"
                >I agree to the <a href="#">Terms of Service</a> and
                <a href="#">Privacy Policy</a></label
              >
            </div>
            <button type="submit" class="btn submit-btn">Create Account</button>
          </form>
          <div class="modal-footer">
            <p>
              Already have an account?
              <a href="#" @click="switchToLogin">Login</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup></script>

<style scoped>
/* Import modern fonts */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap");

/* Reset and base styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Poppins", sans-serif;
  color: #333;
  line-height: 1.6;
  background-color: #f8f9fa;
}

/* Container layout */
.app-container {
  display: grid;
  min-height: 100vh;
  grid-template-rows: auto 1fr auto;
}

/* Header styles */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 5%;
  background-color: #fff;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 100;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 3rem;
  height: auto;
  margin-right: 0.5rem;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.brand-name {
  font-family: "Montserrat", sans-serif;
  font-weight: 700;
  font-size: 1.8rem;
  color: #2c3e50;
  background: linear-gradient(135deg, #3498db, #2c3e50);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Auth buttons */
.auth-buttons {
  display: flex;
  gap: 0.8rem;
}

.auth-btn {
  padding: 0.6rem 1.2rem;
  border-radius: 50px;
  font-weight: 500;
  font-size: 0.9rem;
  transition: all 0.3s ease;
}

.auth-btn.login {
  background-color: transparent;
  color: #3498db;
  border: 1px solid #3498db;
}

.auth-btn.login:hover {
  background-color: rgba(52, 152, 219, 0.1);
}

.auth-btn.register {
  background-color: #3498db;
  color: white;
  border: 1px solid #3498db;
}

.auth-btn.register:hover {
  background-color: #2980b9;
}

/* Navigation styles */
.main-nav ul {
  display: flex;
  list-style: none;
  gap: 1.8rem;
}

.main-nav a {
  text-decoration: none;
  color: #2c3e50;
  font-weight: 500;
  font-size: 1rem;
  position: relative;
  padding: 0.5rem 0;
  transition: color 0.3s ease;
}

.main-nav a::after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #3498db;
  transition: width 0.3s ease;
}

.main-nav a:hover {
  color: #3498db;
}

.main-nav a:hover::after,
.main-nav .active a::after {
  width: 100%;
}

.main-nav .active a {
  color: #3498db;
}

/* Main content styles */
main {
  padding: 0;
}

/* Hero section styles */
.hero-section {
  display: flex;
  background: linear-gradient(135deg, #f5f7fa, #e4f1fe);
  padding: 4rem 5%;
  min-height: 70vh;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.hero-content {
  flex: 1;
  padding-right: 2rem;
  position: relative;
  z-index: 2;
}

.badge {
  display: inline-block;
  background-color: rgba(52, 152, 219, 0.1);
  color: #3498db;
  font-weight: 500;
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  margin-bottom: 1.5rem;
  border: 1px solid rgba(52, 152, 219, 0.2);
}

.hero-content h2 {
  font-family: "Montserrat", sans-serif;
  font-size: 3rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 1.5rem;
  line-height: 1.2;
  background: linear-gradient(135deg, #2c3e50, #3498db);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-content p {
  font-size: 1.2rem;
  color: #546e7a;
  margin-bottom: 2rem;
  max-width: 600px;
}

.cta-buttons {
  display: flex;
  gap: 1rem;
  margin-bottom: 2.5rem;
}

.btn {
  font-family: "Poppins", sans-serif;
  padding: 0.8rem 1.8rem;
  border-radius: 50px;
  font-weight: 500;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

.btn.primary {
  background: linear-gradient(135deg, #3498db, #2980b9);
  color: white;
  box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
}

.btn.primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(52, 152, 219, 0.5);
}

.btn.secondary {
  background-color: transparent;
  color: #3498db;
  border: 2px solid #3498db;
}

.btn.secondary:hover {
  background-color: rgba(52, 152, 219, 0.1);
  transform: translateY(-2px);
}

.stats-container {
  display: flex;
  gap: 2rem;
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-number {
  font-family: "Montserrat", sans-serif;
  font-size: 1.8rem;
  font-weight: 700;
  color: #2c3e50;
}

.stat-label {
  color: #546e7a;
  font-size: 0.9rem;
}

.hero-image-container {
  flex: 1;
  position: relative;
}

.shapes {
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.shape {
  position: absolute;
  border-radius: 50%;
}

.shape-1 {
  width: 300px;
  height: 300px;
  background: radial-gradient(
    circle,
    rgba(52, 152, 219, 0.2) 0%,
    rgba(52, 152, 219, 0) 70%
  );
  top: -50px;
  right: -50px;
}

.shape-2 {
  width: 200px;
  height: 200px;
  background: radial-gradient(
    circle,
    rgba(41, 128, 185, 0.15) 0%,
    rgba(41, 128, 185, 0) 70%
  );
  bottom: 50px;
  right: 100px;
}

.shape-3 {
  width: 150px;
  height: 150px;
  background: radial-gradient(
    circle,
    rgba(26, 188, 156, 0.15) 0%,
    rgba(26, 188, 156, 0) 70%
  );
  bottom: -20px;
  left: 100px;
}

.hero-image {
  background-color: #fff;
  min-height: 450px;
  border-radius: 16px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  position: relative;
  z-index: 2;
  background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 800 600"><rect fill="%23ffffff" width="800" height="600"/><path fill="%23f0f9ff" d="M0 0 L800 0 L800 600 L0 600 Z"/><circle fill="%23e6f7ff" cx="400" cy="300" r="200"/><path fill="%23d6eeff" d="M0 600 L800 400 L800 600 Z"/></svg>');
  background-size: cover;
  overflow: hidden;
}

.floating-card {
  position: absolute;
  background: white;
  padding: 1rem;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 0.8rem;
  animation: float 6s ease-in-out infinite;
}

.card-1 {
  top: 30%;
  left: 20%;
  animation-delay: 0s;
}

.card-2 {
  bottom: 25%;
  right: 15%;
  animation-delay: 1s;
}

.card-icon {
  font-size: 1.5rem;
}

.card-text {
  font-weight: 600;
  font-size: 0.9rem;
  color: #2c3e50;
}

@keyframes float {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-15px);
  }
  100% {
    transform: translateY(0px);
  }
}

/* Features Highlight Section */
.features-highlight {
  display: flex;
  justify-content: space-around;
  padding: 1.5rem 5%;
  background-color: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.feature-highlight-item {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.feature-icon {
  font-size: 1.5rem;
}

.feature-text {
  font-weight: 600;
  color: #2c3e50;
}

/* Services section styles */
.services-section {
  padding: 5rem 5%;
  background-color: #f8f9fa;
}

.section-title {
  text-align: center;
  font-family: "Montserrat", sans-serif;
  font-size: 2.2rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 3.5rem;
  position: relative;
}

.section-title::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #3498db, #2980b9);
  border-radius: 2px;
}

.service-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.service-card {
  background-color: #fff;
  border-radius: 16px;
  padding: 2.5rem 2rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.service-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(90deg, #db3434, #b92929);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
}

.service-card:hover {
  transform: translateY(-15px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.service-card:hover::before {
  transform: scaleX(1);
}

.service-icon {
  font-size: 3.5rem;
  margin-bottom: 1.5rem;
  display: inline-block;
  background-color: rgba(52, 152, 219, 0.1);
  width: 80px;
  height: 80px;
  line-height: 80px;
  border-radius: 50%;
  color: #e4e4e4;
}

.service-card h3 {
  font-family: "Montserrat", sans-serif;
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 1.2rem;
}

.service-card p {
  color: #546e7a;
  margin-bottom: 1.5rem;
}

.service-link {
  color: #3498db;
  text-decoration: none;
  font-weight: 600;
  position: relative;
  transition: color 0.3s ease;
}

.service-link::after {
  content: "→";
  margin-left: 0.5rem;
  transition: transform 0.3s ease;
  display: inline-block;
}

.service-link:hover {
  color: #2980b9;
}

.service-link:hover::after {
  transform: translateX(5px);
}

/* Testimonials section (continuing from where it was cut off) */
.testimonials-section {
  padding: 5rem 5%;
  background-color: #fff;
}

.testimonials-container {
  display: flex;
  gap: 2rem;
  overflow-x: auto;
  padding: 1rem 0.5rem;
  margin: 0 -0.5rem;
  scroll-snap-type: x mandatory;
}

.testimonial-card {
  flex: 0 0 auto;
  width: calc(33.333% - 2rem);
  min-width: 300px;
  background-color: #f8f9fa;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  scroll-snap-align: start;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
}

.quote {
  font-size: 1.1rem;
  color: #2c3e50;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  position: relative;
  padding-left: 1.5rem;
}

.quote::before {
  content: '"';
  position: absolute;
  left: 0;
  top: -0.5rem;
  font-size: 3rem;
  color: #3498db;
  opacity: 0.2;
  font-family: "Georgia", serif;
}

.author {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.author-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #e1e5ea;
  background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"><circle cx="25" cy="18" r="8" fill="%23a0aec0"/><path d="M15 40 Q25 30, 35 40" stroke="%23a0aec0" fill="none" stroke-width="2"/><circle cx="25" cy="25" r="23" stroke="%23a0aec0" fill="none" stroke-width="2"/></svg>');
}

.author-info {
  display: flex;
  flex-direction: column;
}

.author-name {
  font-weight: 600;
  color: #2c3e50;
}

.author-role {
  font-size: 0.9rem;
  color: #546e7a;
}

/* Features section styles */
.features-section {
  padding: 5rem 5%;
  background-color: #f8f9fa;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.feature {
  background-color: #fff;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.feature:hover {
  transform: translateY(-5px);
}

.feature-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.2rem;
}

.feature-icon-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: rgba(52, 152, 219, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
}

.feature-icon {
  font-size: 1.5rem;
}

.feature h3 {
  font-family: "Montserrat", sans-serif;
  font-size: 1.3rem;
  font-weight: 600;
  color: #2c3e50;
}

.feature p {
  color: #546e7a;
}

/* CTA section styles */
.cta-section {
  background: linear-gradient(135deg, #3498db, #2980b9);
  padding: 5rem 5%;
  text-align: center;
  color: white;
}

.cta-content {
  max-width: 800px;
  margin: 0 auto;
}

.cta-section h2 {
  font-family: "Montserrat", sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
}

.cta-section p {
  font-size: 1.2rem;
  margin-bottom: 2.5rem;
  opacity: 0.9;
}

.cta-btn {
  background-color: white;
  color: #3498db;
  padding: 1rem 2.5rem;
  font-weight: 600;
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.cta-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
}

/* Footer styles */
.footer {
  background-color: #2c3e50;
  color: white;
  padding: 4rem 5% 2rem;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 3rem;
  margin-bottom: 3rem;
}

.footer-info {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.footer-logo-img {
  width: 2.5rem;
  height: auto;
  filter: brightness(0) invert(1);
}

.footer-logo span {
  font-family: "Montserrat", sans-serif;
  font-weight: 700;
  font-size: 1.5rem;
}

.footer-description {
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.8;
}

.social-links {
  display: flex;
  gap: 1rem;
}

.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.social-link:hover {
  background-color: #3498db;
}

.link-group h4 {
  font-family: "Montserrat", sans-serif;
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
  position: relative;
  padding-bottom: 0.8rem;
}

.link-group h4::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 40px;
  height: 3px;
  background-color: #3498db;
}

.link-group ul {
  list-style: none;
}

.link-group li {
  margin-bottom: 0.8rem;
}

.link-group a {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  transition: color 0.3s ease, transform 0.3s ease;
  display: inline-block;
}

.link-group a:hover {
  color: white;
  transform: translateX(5px);
}

.footer-newsletter h4 {
  font-family: "Montserrat", sans-serif;
  font-size: 1.2rem;
  margin-bottom: 1rem;
}

.footer-newsletter p {
  color: rgba(255, 255, 255, 0.7);
  margin-bottom: 1.5rem;
}

.newsletter-form {
  display: flex;
}

.newsletter-form input {
  flex: 1;
  padding: 0.8rem 1.2rem;
  border: none;
  border-radius: 50px 0 0 50px;
  outline: none;
  font-family: "Poppins", sans-serif;
}

.newsletter-form .btn {
  border-radius: 0 50px 50px 0;
  padding: 0.8rem 1.5rem;
  background-color: #3498db;
  color: white;
  font-weight: 500;
}

.newsletter-form .btn:hover {
  background-color: #2980b9;
}

.copyright {
  text-align: center;
  padding-top: 2rem;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.5);
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(5px);
}

.modal {
  background-color: white;
  border-radius: 16px;
  width: 90%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #e1e5ea;
}

.modal-header h3 {
  font-family: "Montserrat", sans-serif;
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #546e7a;
  transition: color 0.3s ease;
}

.close-btn:hover {
  color: #e74c3c;
}

.modal-body {
  padding: 1.5rem;
}

.login-form,
.register-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.form-row .form-group {
  flex: 1;
}

label {
  font-weight: 500;
  color: #2c3e50;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  padding: 0.8rem 1.2rem;
  border: 1px solid #e1e5ea;
  border-radius: 8px;
  font-family: "Poppins", sans-serif;
  transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  border-color: #3498db;
  outline: none;
}

.forgot-password {
  align-self: flex-end;
  color: #3498db;
  text-decoration: none;
  font-size: 0.9rem;
  transition: color 0.3s ease;
}

.forgot-password:hover {
  color: #2980b9;
  text-decoration: underline;
}

.remember-me {
  flex-direction: row;
  align-items: center;
  gap: 0.5rem;
}

.submit-btn {
  background-color: #3498db;
  color: white;
  margin-top: 1rem;
}

.submit-btn:hover {
  background-color: #2980b9;
}

.social-login {
  margin-top: 2rem;
  text-align: center;
}

.social-login p {
  color: #546e7a;
  margin-bottom: 1rem;
  position: relative;
}

.social-login p::before,
.social-login p::after {
  content: "";
  position: absolute;
  top: 50%;
  width: 30%;
  height: 1px;
  background-color: #e1e5ea;
}

.social-login p::before {
  left: 0;
}

.social-login p::after {
  right: 0;
}

.social-buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.social-btn {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: none;
  font-weight: bold;
  font-size: 1.2rem;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.social-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.social-btn.google {
  background-color: #db4437;
  color: white;
}

.social-btn.facebook {
  background-color: #4267b2;
  color: white;
}

.social-btn.apple {
  background-color: #000;
  color: white;
}

.modal-footer {
  text-align: center;
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e1e5ea;
}

.modal-footer a {
  color: #3498db;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.3s ease;
}

.modal-footer a:hover {
  color: #2980b9;
  text-decoration: underline;
}

.register-types {
  display: flex;
  margin-bottom: 1.5rem;
  gap: 0.5rem;
}

.register-type-btn {
  flex: 1;
  padding: 0.8rem;
  border: 1px solid #e1e5ea;
  border-radius: 8px;
  background-color: transparent;
  color: #546e7a;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
}

.register-type-btn.active,
.register-type-btn:hover {
  background-color: #3498db;
  color: white;
  border-color: #3498db;
}

.terms {
  flex-direction: row;
  align-items: flex-start;
}

.terms label {
  font-size: 0.9rem;
}

.terms a {
  color: #3498db;
}

/* Responsive styles */
@media (max-width: 1200px) {
  .hero-content h2 {
    font-size: 2.5rem;
  }

  .hero-section {
    padding: 3rem 5%;
  }
}

@media (max-width: 992px) {
  .hero-section {
    flex-direction: column;
    gap: 3rem;
    text-align: center;
  }

  .hero-content {
    padding-right: 0;
  }

  .stats-container {
    justify-content: center;
  }

  .cta-buttons {
    justify-content: center;
  }

  .service-card {
    padding: 2rem 1.5rem;
  }
}

@media (max-width: 768px) {
  .header {
    flex-wrap: wrap;
    gap: 1rem;
  }

  .main-nav {
    order: 3;
    width: 100%;
    margin-top: 1rem;
  }

  .main-nav ul {
    justify-content: space-between;
  }

  .features-highlight {
    flex-wrap: wrap;
    gap: 1rem;
  }

  .feature-highlight-item {
    width: 45%;
  }

  .testimonial-card {
    width: calc(100% - 2rem);
  }

  .form-row {
    flex-direction: column;
  }
}

@media (max-width: 576px) {
  .section-title {
    font-size: 1.8rem;
  }

  .hero-content h2 {
    font-size: 2rem;
  }

  .feature-highlight-item {
    width: 100%;
  }

  .stats-container {
    flex-direction: column;
    gap: 1rem;
    align-items: center;
  }

  .cta-buttons {
    flex-direction: column;
  }

  .footer-content {
    grid-template-columns: 1fr;
  }
}
</style>
