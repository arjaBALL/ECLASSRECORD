<!-- @format -->

<template>
  <div class="dashboard-wrapper">
    <h1 class="dashboard-title">Dashboard</h1>

    <div v-if="loading" class="loading-indicator">
      Loading dashboard data...
    </div>

    <div v-else-if="error" class="error-message">{{ error }}</div>

    <div v-else class="stats-grid">
      <div class="stat-card">
        <h4>Total Teachers</h4>
        <p>{{ stats.total_teachers }}</p>
      </div>
      <div class="stat-card">
        <h4>Total Students</h4>
        <p>{{ stats.total_students }}</p>
      </div>
      <div class="stat-card">
        <h4>Active Teachers</h4>
        <p>{{ stats.active_teachers }}</p>
      </div>
      <div class="stat-card">
        <h4>Account Request</h4>
        <p>{{ stats.pending_requests }} pending</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  name: "Dash",

  data() {
    return {
      stats: {
        total_teachers: 0,
        total_students: 0,
        active_teachers: 0,
        pending_requests: 0,
      },
      loading: false,
      error: null,
    };
  },

  methods: {
    async fetchStats() {
      this.loading = true;
      this.error = null;

      try {
        // Use the same base URL pattern as your other API calls
        const url =
          "http://localhost:8080/capstone/admin/backend/api/dashboard_data.php";

        const response = await axios.get(url);

        console.log("Dashboard data response:", response.data);

        // Check if response has data and is successful
        if (response.data) {
          // Update stats with the response data
          this.stats = {
            total_teachers: response.data.total_teachers || 0,
            total_students: response.data.total_students || 0,
            active_teachers: response.data.active_teachers || 0,
            pending_requests: response.data.pending_requests || 0,
          };
        } else {
          throw new Error("Failed to fetch dashboard data");
        }
      } catch (error) {
        this.error = "Failed to load dashboard data. Please try again.";
        console.error("Error fetching dashboard stats:", error);
      } finally {
        this.loading = false;
      }
    },
  },

  created() {
    this.fetchStats();
  },
};
</script>

<style scoped>
.dashboard-wrapper {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.dashboard-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #2e92fe;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.stat-card {
  background-color: #f5f9ff;
  border: 1px solid #dbe9ff;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  text-align: center;
  padding: 1rem;
}

.stat-card h3 {
  color: #333;
}

.stat-card p {
  font-size: 1.2rem;
  font-weight: 600;
  color: #2e92fe;
}

.loading-indicator {
  text-align: center;
  color: #2e92fe;
  padding: 1rem;
  font-weight: 500;
}

.error-message {
  color: #ff3333;
  text-align: center;
  padding: 1rem;
  font-weight: 500;
  background-color: #ffeeee;
  border-radius: 8px;
  margin: 1rem 0;
}
</style>
