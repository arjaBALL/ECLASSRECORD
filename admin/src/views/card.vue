<!-- @format -->

<template>
  <div class="dashboard-wrapper">
    <h1 class="dashboard-title">Dashboard</h1>
    <p class="welcome-text">
      Welcome to the admin dashboard. Use the sidebar to navigate through the
      system.
    </p>

    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total Users</h3>
        <p>120</p>
      </div>
      <div class="stat-card">
        <h3>Active Sessions</h3>
        <p>8</p>
      </div>
      <div class="stat-card">
        <h3>Reports</h3>
        <p>3 pending</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "card",
};
</script>

<style scoped>
.dashboard-wrapper {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.dashboard-title {
  font-size: 2rem;
  font-weight: bold;
  color: #2e92fe;
}

.welcome-text {
  font-size: 1.1rem;
  color: #555;
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
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  text-align: center;
}

.stat-card h3 {
  margin-bottom: 0.5rem;
  color: #333;
}

.stat-card p {
  font-size: 1.2rem;
  font-weight: 600;
  color: #2e92fe;
}
</style>
