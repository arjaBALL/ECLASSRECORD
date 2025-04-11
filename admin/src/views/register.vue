<!-- @format -->

<template>
  <div
    class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card h-100 p-3 d-flex justify-content-center">
      <div
        class="text-center py-2 justify-content-center d-flex align-items-center mb-2">
        <img
          src="/image/logo.png"
          alt="Responsive image"
          class="img-fluid logo me-1"
          style="height: 40px" />
        <h5 class="mb-0 fs-6" v-if="!isSidebarCollapsed">
          Asian Development Foundation College
        </h5>
      </div>
      <form @submit.prevent="handleregisterteacher">
        <div
          v-if="responseMessage"
          class="alert d-flex align-items-start border border-1 rounded-2 p-3 mb-3"
          :class="{
            'alert-success bg-light text-success border-success':
              responseType === 'success',
            'alert-danger bg-light text-danger border-danger':
              responseType === 'error',
          }">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="currentColor"
            class="bi bi-exclamation-circle me-2 mt-1"
            viewBox="0 0 16 16">
            <path
              d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
            <path
              d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zm.1-5.995a.905.905 0 1 1 1.8 0l-.35 3.5a.55.55 0 0 1-1.1 0l-.35-3.5z" />
          </svg>
          <div>
            <strong v-if="responseType === 'error'">Error: </strong>
            <strong v-else>Success: </strong>
            {{ responseMessage }}
          </div>
        </div>

        <div class="inpt-grp">
          <label>Teacher ID</label>
          <input
            type="text"
            v-model="teacherid"
            placeholder="Enter teacher id" />
          <p class="error-message">
            {{ teacheridError }}
          </p>
        </div>
        <div class="name-container">
          <div class="inpt-grp">
            <label>Last Name</label>
            <input
              type="text"
              v-model="lastname"
              placeholder="Enter last name" />
            <p class="error-message">
              {{ lastnameError }}
            </p>
          </div>
          <div class="inpt-grp">
            <label>First Name</label>
            <input
              type="text"
              v-model="firstname"
              placeholder="Enter first name" />
            <p class="error-message">
              {{ firstnameError }}
            </p>
          </div>
        </div>
        <div class="inpt-grp">
          <label>Email</label>
          <input type="email" v-model="email" placeholder="Enter your email" />
          <p class="error-message">
            {{ emailError }}
          </p>
        </div>
        <div class="name-container">
          <div class="inpt-grp">
            <label>Password</label>
            <input
              type="password"
              v-model="password"
              placeholder="Enter your password" />
            <p class="error-message">
              {{ passwordError }}
            </p>
          </div>
          <div class="inpt-grp">
            <label>Confirm Password</label>
            <input
              type="password"
              v-model="confirmpassword"
              placeholder="Confirm password" />
            <p class="error-message">
              {{ confirmpasswordError }}
            </p>
          </div>
        </div>
        <div class="inpt-grp">
          <button type="submit" class="btn btn-primary w-100 mt-1">
            Register
          </button>
        </div>
        <div class="inpt-grp text-center mt-2 link">
          <p>
            Already have an account? <a href="/userlogin" class="link">Login</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, watchEffect } from "vue";

export default {
  data() {
    return {
      teacherid: "",
      lastname: "",
      firstname: "",
      email: "",
      password: "",
      confirmpassword: "",
      teacheridError: "",
      lastnameError: "",
      firstnameError: "",
      emailError: "",
      passwordError: "",
      confirmpasswordError: "",
      responseMessage: "",
      responseType: "",
      messageTimeout: null,
      isSidebarCollapsed: false,
    };
  },
  methods: {
    async handleregisterteacher() {
      let isValid = true;

      // Reset error messages
      this.teacheridError = "";
      this.lastnameError = "";
      this.firstnameError = "";
      this.emailError = "";
      this.passwordError = "";
      this.confirmpasswordError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.teacherid) {
        this.teacheridError = "Teacher ID is required";
        isValid = false;
      }
      if (!this.lastname) {
        this.lastnameError = "Last name is required";
        isValid = false;
      }
      if (!this.firstname) {
        this.firstnameError = "First name is required";
        isValid = false;
      }
      if (!this.email) {
        this.emailError = "Email is required";
        isValid = false;
      } else if (!this.validateEmail(this.email)) {
        this.emailError = "Please enter a valid email address";
        isValid = false;
      }
      if (!this.password) {
        this.passwordError = "Password is required";
        isValid = false;
      }
      if (!this.confirmpassword) {
        this.confirmpasswordError = "Please confirm your password";
        isValid = false;
      } else if (this.password !== this.confirmpassword) {
        this.confirmpasswordError = "Passwords do not match";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/register-teacher.php",
            {
              teacher_id: this.teacherid,
              lastname: this.lastname,
              firstname: this.firstname,
              email: this.email,
              password: this.password,
            }
          );

          if (response.data.success) {
            this.responseMessage = "Teacher registered successfully!";
            this.responseType = "success";
            this.resetForm();
          } else {
            this.responseMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responseMessage = "";
            this.responseType = "";
          }, 5000);
        } catch (error) {
          console.error("Error registering teacher:", error);
          if (error.response) {
            console.log("Response data:", error.response.data);
            console.log("Response status:", error.response.status);
            console.log("Response headers:", error.response.headers);
          } else if (error.request) {
            console.log("Request made but no response received", error.request);
          } else {
            console.log("Error", error.message);
          }

          this.responseMessage =
            "Failed to register teacher. Please try again.";
          this.responseType = "error";
        }
      }
    },
    validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    },
    resetForm() {
      this.teacherid = "";
      this.lastname = "";
      this.firstname = "";
      this.email = "";
      this.password = "";
      this.confirmpassword = "";
    },
  },
};
</script>

<style scoped>
.card {
  width: 30rem;
}

.inpt-grp {
  width: 100%;
  text-align: left;
}

label {
  display: block;
  margin-bottom: 4px;
  font-weight: bold;
  color: #555;
}

.inpt-grp input {
  border-radius: 4px; /* Rounded corners */
  border: 1px solid #ccc; /* Subtle border for definition */
  padding: 6px 12px; /* Comfortable spacing */
  width: 100%; /* Ensures consistent width */
  box-sizing: border-box; /* Prevents overflow */
}

.name-container {
  display: flex;
  gap: 0.5rem;
}

.link {
  font-size: 0.8rem;
  text-decoration: none;
}

.error-message {
  color: #dc3545;
  font-size: 0.8rem;
  margin-top: 2px;
  min-height: 0;
}

.success {
  color: #28a745;
}

.error {
  color: #dc3545;
}
</style>
