<!-- @format -->

<template>
  <div class="container">
    <header>
      <div class="pic">
        <img src="/image/logo.png" alt="Logo" class="logo-image" />
      </div>
      ADFC
    </header>
    <nav>
      <ul>
        <li class="active">Home</li>
        <li>About</li>
        <li>Services</li>
        <li>Contact</li>
      </ul>
    </nav>
    <main>
      <div class="main-container">
        <div class="about-container">
          <div class="about">
            <h2>E-Class Record Management System</h2>
            <p>
              This is a user-friendly platform designed to help teachers
              efficiently manage student records, track grades, and generate
              performance insights with ease.
            </p>
            <div class="hero-buttons">
              <button>Get Started</button>
              <button>Learn More</button>
            </div>
          </div>
          <div class="photo-container">
            <img src="/image/photo.jpg" alt="ADFC Logo" class="photo" />
          </div>
        </div>
        <div class="service-title">
          <h2>Our Service</h2>
        </div>
        <div class="card-container">
          <div class="cards">
            <div class="service-icon">📊</div>
            <h3>Grade Management</h3>
            <p>
              Easily input, track, and analyze student grades with our intuitive
              interface.
            </p>
          </div>
          <div class="cards">
            <div class="service-icon">📝</div>
            <h3>Attendance Tracking</h3>
            <p>
              Monitor student attendance and generate reports with just a few
              clicks.
            </p>
          </div>
          <div class="cards">
            <div class="service-icon">📊</div>
            <h3>Grade Management</h3>
            <p>
              Easily input, track, and analyze student grades with our intuitive
              interface.
            </p>
          </div>
          <div class="cards">
            <div class="service-icon">📊</div>
            <h3>Grade Management</h3>
            <p>
              Easily input, track, and analyze student grades with our intuitive
              interface.
            </p>
          </div>
        </div>
      </div>
    </main>
    <footer>Copyright</footer>
  </div>
</template>

<script setup></script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap");
.container {
  width: 100%;
  height: 100vh;
  background-color: aliceblue;
}

.container {
  display: grid;
  height: 100vh;
  grid-template-columns: 15rem auto;
  grid-template-rows: 5rem auto auto;
  grid-template-areas:
    "header nav"
    "main main"
    "footer footer";
}

header {
  grid-area: header;
  margin-top: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: "Figtree", sans-serif;
  font-size: 1.3rem;
  font-weight: 600;
  background: linear-gradient(135deg, #2c3e50, #3498db);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}
nav {
  grid-area: nav;
  display: flex;
  justify-content: center;
  align-items: center;
}
main {
  grid-area: main;
  background-color: #9bbcc7;
  height: 90vh;
}
footer {
  grid-area: footer;
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  gap: 16px;
}

li {
  font-family: "Montserrat", sans-serif;
  cursor: pointer;
  font-weight: bold;
  width: 6rem;
  height: 2.2rem;
  font-weight: 600;
  font-size: 0.8rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-bottom-left-radius: 0.6rem;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.6rem;
  border-bottom-right-radius: 0.25rem;
  border: #357ab8 1px solid;
  transition: background 0.3s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

li:hover {
  background-color: #357ab8; /* Darker blue on hover */
  color: white;
}

.active {
  background-color: #3498db;
}

.logo {
  width: auto;
  border-radius: 12px;
  height: auto;
  transition: all 0.3s ease;
}

.logo-image {
  width: 3.5rem; /* Responsive image size */
  object-fit: contain; /* Better for logos */
  transition: all 0.3s ease;
  padding: 0.5rem;
  margin-left: 1.5rem;
}

.main-container {
  display: inline-block;
  width: 100%;
}

.service-title {
  text-align: center;
}

.about-container {
  display: flex;
  background: linear-gradient(135deg, #f5f7fa, #e4f1fe);
  padding: 0rem 5%;
  min-height: 90vh;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.about {
  width: 50%;
  height: auto;
}

h2 {
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
p {
  font-size: 1.2rem;
  color: #546e7a;
  margin-bottom: 2rem;
  max-width: 600px;
}

.hero-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

button {
  font-size: 1rem;
  width: 8.5rem;
  border: 1px solid #357ab8;
  padding: 16px 24px;
  border-bottom-left-radius: 0.25rem;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 1rem;
  border-bottom-right-radius: 0.25rem;
  cursor: pointer;
}
.hero-buttons button:first-child {
  background-color: #357ab8;
  color: white;
}

.hero-buttons button:first-child:hover {
  background-color: #f5f7fa;
  color: #357ab8;
}

.hero-buttons button:last-child {
  color: #357ab8;
}

.hero-buttons button:last-child:hover {
  color: #f5f7fa;
  background-color: #357ab8;
}

.photo-container {
  background-color: #ffffff0c; /* Lighter background instead of dark gray */
  width: 50%;
  height: auto;
  border-radius: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden; /* Prevents image from overflowing */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
  padding: 0.9rem; /* Adds some padding inside the container */
}

.photo {
  width: 100%; /* Fill the container completely */
  height: auto;
  object-fit: cover;
  border-radius: 1rem; /* Rounded corners on the actual image */
  transition: transform 0.3s ease; /* For hover effect */
}

.photo:hover {
  transform: scale(1.02); /* Slight zoom on hover */
}

.card-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1rem;
  padding: 1rem 5%;
}

.cards {
  font-family: "Montserrat", sans-serif;
  background-color: #fff;
  border-radius: 16px;
  padding: 2.5rem 2rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
  position: relative;
  overflow: hidden;
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
  color: #3498db;
}

.cards::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(90deg, #3498db, #2980b9);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
}

.cards:hover {
  transform: translateY(-15px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.cards:hover::before {
  transform: scaleX(1);
}
</style>
