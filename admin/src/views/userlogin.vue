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

      <!-- Enhanced Success Notification -->
      <div v-if="showSuccessNotification" class="success-notification">
        <div class="check-icon">✓</div>
        <div class="success-message">Login successful! Redirecting...</div>
      </div>

      <!-- Regular alerts for other messages -->
      <div
        v-if="responseMessage && !showSuccessNotification"
        :class="[
          'alert',
          responseType === 'success' ? 'alert-success' : 'alert-danger',
        ]">
        {{ responseMessage }}
      </div>

      <form @submit.prevent="handleloginuser">
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
          <button type="submit" class="btn btn-primary w-100 mt-1">
            Login
          </button>
        </div>
        <div class="inpt-grp text-center mt-2 link">
          <p>
            Don't have an account? <a href="/register" class="link">Register</a>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";

export default {
  data() {
    return {
      teacherid: "",
      password: "",
      teacheridError: "",
      passwordError: "",
      responseMessage: "",
      responseType: "",
      messageTimeout: null,
      isSidebarCollapsed: false,
      showSuccessNotification: false,
    };
  },
  methods: {
    async handleloginuser() {
      let isValid = true;

      // Reset error messages
      this.teacheridError = "";
      this.passwordError = "";
      this.showSuccessNotification = false;

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.teacherid) {
        this.teacheridError = "Teacher ID is required";
        isValid = false;
      }

      if (!this.password) {
        this.passwordError = "Password is required";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/login-teacher.php",
            {
              teacher_id: this.teacherid,
              password: this.password,
            }
          );

          if (response.data.success) {
            // Show enhanced success notification instead of simple alert
            this.showSuccessNotification = true;
            this.responseMessage = "Login successful!";
            this.responseType = "success";

            localStorage.setItem("session_id", response.data.session_id);

            // Store user information in localStorage or sessionStorage
            localStorage.setItem(
              "teacherData",
              JSON.stringify(response.data.teacher)
            );
            localStorage.setItem("isLoggedIn", "true");

            // Check role and redirect accordingly after short delay to show notification
            const role = response.data.teacher.role;

            // Delay redirection to show notification
            setTimeout(() => {
              if (role === "admin") {
                this.$router.push("/admin"); // Admin dashboard route
              } else if (role === "teacher") {
                this.$router.push(`/performance/${response.data.teacher.id}`); // Teacher dashboard route
              }
            }, 2000); // 2-second delay for notification to be visible
          } else {
            this.responseMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds (only for error messages)
          if (!response.data.success) {
            this.messageTimeout = setTimeout(() => {
              this.responseMessage = "";
              this.responseType = "";
            }, 5000);
          }
        } catch (error) {
          console.error("Error logging in:", error);
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
            "Failed to login. Please check your credentials and try again.";
          this.responseType = "error";

          // Auto-clear error message
          this.messageTimeout = setTimeout(() => {
            this.responseMessage = "";
            this.responseType = "";
          }, 5000);
        }
      }
    },
  },
};
</script>

<style scoped>
.card {
  width: 25rem;
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

.alert {
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 15px;
  text-align: center;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

/* Enhanced Success Notification Styles */
.success-notification {
  display: flex;
  align-items: center;
  background-color: #28a745;
  color: white;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.5s ease-out;
}

.check-icon {
  font-size: 24px;
  margin-right: 10px;
  border: 2px solid white;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.success-message {
  font-weight: bold;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
