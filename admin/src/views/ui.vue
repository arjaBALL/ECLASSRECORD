<!-- @format -->

<template>
  <div
    class="login-container"
    :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
    <div id="item-0" :class="{ collapsed: isSidebarCollapsed }">
      <div class="logo">
        <img src="/image/bfar.png" alt="Logo" class="logo-image" />

        <h5 class="name" :class="{ 'hidden-name': isSidebarCollapsed }">
          Burue of Fisheries and Aquatic Resources
        </h5>
      </div>

      <div class="button-container">
        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon
            :icon="['fas', 'exchange-alt']"
            class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Data Transfer </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon :icon="['fas', 'tools']" class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Maintenance </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon :icon="['fas', 'users-cog']" class="custom-icon" />

          <span v-if="!isSidebarCollapsed">Employees </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon :icon="['fas', 'file-alt']" class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Report </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon :icon="['fas', 'id-card']" class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Time Card </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon :icon="['fas', 'gear']" class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Tools </span>
        </button>

        <button class="btn" :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon
            :icon="['fas', 'folder-tree']"
            class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Apps FLDR </span>
        </button>

        <button
          class="btn"
          @click="handleLogout"
          :class="{ 'collapsed-btn': isSidebarCollapsed }">
          <font-awesome-icon
            :icon="['fas', 'right-from-bracket']"
            class="custom-icon" />

          <span v-if="!isSidebarCollapsed"> Log Out </span>
        </button>
      </div>
    </div>

    <div id="item-1">
      <button class="btns" id="resize" @click="toggleSidebar">
        <font-awesome-icon :icon="['fas', 'bars']" />
      </button>

      <div class="nav">
        <button class="btns1">
          <font-awesome-icon :icon="['fas', 'bars']" />
        </button>

        <button class="btns1">
          <font-awesome-icon :icon="['fas', 'bell']" />
        </button>

        <button class="btns1">
          <font-awesome-icon :icon="['fas', 'clipboard-list']" />
        </button>
      </div>
    </div>

    <div id="item-2">
      <div id="box-0" class="box box-buttons">
        <div class="box-container">
          <button class="crud active">
            <font-awesome-icon :icon="['fas', 'user-plus']" /> Add User
          </button>

          <button class="crud">
            <font-awesome-icon :icon="['fas', 'save']" /> Save
          </button>

          <button class="crud">
            <font-awesome-icon :icon="['fas', 'edit']" /> Edit
          </button>

          <button class="crud">
            <font-awesome-icon :icon="['fas', 'trash']" /> Delete
          </button>

          <button class="crud">
            <font-awesome-icon :icon="['fas', 'sync']" /> Refresh
          </button>

          <button class="crud">
            <font-awesome-icon :icon="['fas', 'door-open']" /> Exit
          </button>
        </div>

        <div class="filter-container">
          <!-- Tabs -->
          <div class="tabs">
            <button
              class="tab"
              :class="{ active: activeTab === 'company' }"
              @click="activeTab = 'company'">
              Company
            </button>

            <button
              class="tab"
              :class="{ active: activeTab === 'department' }"
              @click="activeTab = 'department'">
              Department
            </button>
          </div>

          <!-- Search Bar -->
          <div class="filter-sb">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search employee name..."
              class="search-bar" />
          </div>
        </div>
      </div>

      <div id="box-1" class="box"></div>
    </div>
  </div>
</template>

<script>
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faBars,
  faBell,
  faIdCard,
  faFileAlt, // Dashboard
  faUserGraduate, // Student
  faTools, // Classes
  faUsersCog, // Attendance
  faGear,
  faExchangeAlt,
  faFolderTree,
  faRightFromBracket,
  faAngleDown,
  faUserPlus, // Add User
  faSave, // Save
  faEdit, // Edit
  faTrash, // Delete
  faSync, // Refresh
  faDoorOpen, // Exit
} from "@fortawesome/free-solid-svg-icons";

// Add icons to the library
library.add(
  faBars,
  faBell,
  faIdCard,
  faFileAlt,
  faUserGraduate,
  faTools,
  faExchangeAlt,
  faUsersCog,
  faGear,
  faFolderTree,
  faRightFromBracket,
  faAngleDown,
  faUserPlus, // Add User
  faSave, // Save
  faEdit, // Edit
  faTrash, // Delete
  faSync, // Refresh
  faDoorOpen // Exit
);

export default {
  components: {
    FontAwesomeIcon,
  },

  data() {
    return {
      activeDropdown: null,
      isSidebarCollapsed: false,
    };
  },

  methods: {
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
      // Close any open dropdowns when sidebar is collapsed
      if (this.isSidebarCollapsed) {
        this.activeDropdown = null;
      }
    },

    toggleDropdown(index) {
      if (this.isSidebarCollapsed) return; // Don't toggle dropdowns when sidebar is collapsed
      this.activeDropdown = this.activeDropdown === index ? null : index;
    },

    goToGrades() {
      alert("Navigating to Grades...");
      // Example: this.$router.push('/grades');
    },

    goToAttendance() {
      alert("Navigating to Attendance...");
      // Example: this.$router.push('/attendance');
    },
  },

  computed: {
    isDropdownOpen() {
      return (index) => this.activeDropdown === index;
    },
  },
};
</script>

<style scoped>
.login-container {
  display: grid;
  grid-template-rows: 4em auto auto auto; /* First row is fixed at 4em, the rest adjust */
  grid-template-columns: 15em auto auto auto;
  height: 100vh;
  transition: all 0.3s ease;
  grid-template-areas:
    "item-0 item-1 item-1 item-1 item-1 item-1"
    "item-0 item-2 item-2 item-2 item-2 item-2"
    "item-0 item-2 item-2 item-2 item-2 item-2"
    "item-0 item-2 item-2 item-2 item-2 item-2";
  overflow: hidden;
}

.sidebar-collapsed {
  grid-template-columns: 5em auto auto auto;
}

#item-0 {
  background-color: #fffafa;
  grid-area: item-0;
  position: sticky;
  top: 0;
  left: 0;
  width: 15em;
  height: 100vh; /* Ensures full height */
  transition: width 0.3s ease;
  overflow: hidden;
}
#item-0.collapsed {
  width: 5em;
}

.button-container {
  display: flex;
  flex-direction: column; /* Stack buttons in a column */
  align-items: center; /* Center the buttons horizontally */
  gap: 10px; /* Add space between buttons */
  padding-top: 1em;
  justify-content: center; /* Center vertically */
}

.btn {
  width: 200px;
  padding: 12px;
  font-size: 16px;
  text-align: left;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #ffffff00;
  color: rgb(84, 84, 84);
  transition: 0.3s;
  white-space: nowrap;
  overflow: hidden;
}

.btn-nm {
  display: inline;
  margin-right: 2.7rem;
}

.btn-nm1 {
  display: inline;
  margin-right: 5.1rem;
}

.collapsed-btn {
  width: 3em;
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn:focus,
.btn-filter:focus {
  border-color: royalblue;
  outline: none;
  color: #566dff;
  background-color: #ecf3ff;
}

.btn-filter {
  width: 150px;
  padding: 12px;
  font-size: 16px;
  text-align: left;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #ffffff00;
  color: rgb(84, 84, 84);
  transition: 0.3s;
  white-space: nowrap;
  overflow: hidden;
}

.btn-filter .collapsed-btn {
  width: 3em;
  display: flex;
  justify-content: center;
  align-items: center;
}

.custom-icon {
  padding-left: 4px;
  padding-right: 8px;
}

.dropdown {
  display: flex;
  flex-direction: column;
  width: 175px;
  margin-top: 4px;
  margin-left: 1.6em;
  gap: 4px;
  color: rgb(53, 53, 53);
}

.side-btn:hover {
  border-radius: 4px;
  background-color: #e4e7ec;
  width: auto;
  transition: 0.3s;
}

.side-btn {
  width: 200px;
  padding: 10px 1em;
  font-size: 16px;
  text-align: left;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  background-color: #ffffff00;
  color: rgb(0, 0, 0);
}

#item-1 {
  display: flex;
  position: sticky;
  top: 0; /* Fixes sticky positioning */
  z-index: 10;
  background-color: #fffafa;
  grid-area: item-1;
  grid-row: span 1;
  border-left: 1px solid #959baa;
  border-bottom: 1px solid #959baa;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
}

.btns {
  width: 2.4em;
  padding: 10px;
  font-size: 16px;
  text-align: center;
  border: none;
  border-radius: 8px;
  border: 1px solid #708090;
  cursor: pointer;
  background-color: #007bff00;
  color: rgb(56, 56, 56);
  transition: 0.3s;
  margin-left: 8px;
}

.btns:hover {
  background-color: #e4e4e4;
}

.rotate-180 {
  transform: rotate(180deg);
}

.btns1 {
  width: 2.2em;
  padding: 10px;
  font-size: 20px;
  text-align: center;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  border: #bfdfff 1px solid;
  background-color: #0057b300;
  color: gray;
  transition: 0.3s;
  margin-left: 8px;
}

.nav {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-right: 4em;
}

.btn:hover {
  background-color: #e4e7ec;
  color: black;
}

.logo {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: auto;
  border-radius: 12px;
  height: auto;
  padding: 0 1rem;
  transition: all 0.3s ease;
}

.logo-image {
  width: 5rem; /* Responsive image size */
  object-fit: contain; /* Better for logos */
  transition: all 0.3s ease;
  padding: 0.5rem;
}

#item-0.collapsed .logo-image {
  width: 3.5rem;
}

.name {
  font-size: 0.9rem;
  text-align: center;
  margin-top: 0.5rem;
  font-weight: bold;
  color: #333;
  max-width: 100%;
  opacity: 1;
  visibility: visible;
  transition: opacity 0.3s ease, visibility 0.3s ease, max-height 0.3s ease,
    margin 0.3s ease;
  max-height: 3rem;
  margin-bottom: 0.5rem;
  overflow: hidden;
}

.hidden-name {
  opacity: 0;
  visibility: hidden;
  max-height: 0;
  margin: 0;
}

#item-2 {
  background-color: #fffafa;
  grid-area: item-2;
  grid-row: span 3;
  overflow-y: auto; /* Enables scrolling */
  height: calc(95vh - 4em); /* Ensures correct height */
  border-left: 1px solid #959baa;
  transition: all 0.3s ease;
}

#item-2 {
  display: grid;
  grid-template-rows: 5rem auto;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-template-areas:
    "box0 box0 box0 box0"
    "box1 box1 box1 box1"
    "box1 box1 box1 box1";
  gap: 0.5em;
  padding: 1rem;
}

.box {
  background-color: #3674b5;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#box-0 {
  grid-area: box0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.box-container {
  width: auto;
  display: flex;
  justify-content: center;
  margin: 1rem;
}

.crud {
  display: inline-flex;
  padding: 1rem 1rem;
  outline: none;
  border: none;
  font-size: 0.8rem;
  gap: 4px;
}

.crud:hover {
  background-color: #05386d;
  color: white;
  cursor: pointer;
}

.active {
  background-color: #2781e0;
}

.filter-container {
  display: flex;
  gap: rem;
  padding-right: 1rem;
}

.tab {
  flex: 1;
  padding: 16px 16px;
  background-color: #e3f2fd;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
}
.filter-sb input {
  flex: 1;
  padding: 16px 16px;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
}

.search-input:focus {
  border-color: #6495ed; /* Deeper Blue on Focus */
}

.search-btn {
  background-color: #4a90e2;
  border: none;
  color: #fff;
  padding: 8px 16px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
  padding: 8px 16px;
}

.search-btn:hover {
  background-color: #357abd;
}

#box-1 {
  grid-area: box1;
}

#box-2 {
  grid-area: box2;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .login-container {
    grid-template-rows: auto;
    grid-template-columns: 1fr 1fr;
    grid-template-areas:
      "item-0 item-0"
      "item-1 item-1"
      "item-2 item-2";
  }

  #item-0.collapsed {
    width: 100%;
    height: 4em;
    display: flex;
    flex-direction: row;
  }

  .sidebar-collapsed {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 4em auto auto;
  }

  #item-0.collapsed .button-container {
    flex-direction: row;
    overflow-x: auto;
  }

  #item-0.collapsed .logo {
    display: none;
  }
}

@media (max-width: 480px) {
  .login-container {
    grid-template-columns: 1fr;
    grid-template-areas:
      "item-0"
      "item-1"
      "item-2";
  }
}
</style>
