<!-- @format -->

<template>
  <div class="app-wrapper">
    <div
      class="box-container"
      :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
      <section class="nav-container" :class="{ collapsed: isSidebarCollapsed }">
        <div class="text-center py-2">
          <img
            src="/image/logo.png"
            alt="Responsive image"
            class="img-fluid logo mx-auto d-block"
            :class="isSidebarCollapsed ? 'w-60' : 'w-50'" />
          <h5 class="mb-2" v-if="!isSidebarCollapsed">
            Asian Development Foundation College
          </h5>
        </div>

        <div class="nav flex-column nav-pills w-100">
          <router-link
            class="nav-link text-start mb-2 d-flex align-items-center nav-hover"
            :class="{ 'justify-content-center': isSidebarCollapsed }"
            v-for="(item, index) in menuItems"
            :key="index"
            :to="item.to || '#'"
            @click.prevent="!item.to ? handleMenuAction(item) : null">
            <font-awesome-icon
              :icon="item.icon"
              :class="{ 'me-2': !isSidebarCollapsed }" />
            <span v-if="!isSidebarCollapsed">{{ item.text }}</span>
          </router-link>
        </div>
      </section>
      <section class="top-header">
        <div class="header-content">
          <button
            class="btn btn-sm btn-outline-light toggle-btn"
            @click="toggleSidebar">
            <font-awesome-icon :icon="['fas', 'bars']" />
          </button>
          <!-- Add other header content here if needed -->
        </div>
      </section>

      <section class="sub-navigation"></section>
      <section class="main-container">
        <div class="add-container">
          Add Student
          <form @submit.prevent="handleLogin" class="">
            <div class="input-group">
              <label>Student ID</label>
              <input type="text" v-model="studentid" placeholder="Enter id" />
              <p class="error-message">{{ studentError }}</p>
            </div>

            <div class="input-group">
              <label>Last Name:</label>
              <input
                type="text"
                v-model="lastname"
                placeholder="Enter Lastname" />
              <p class="error-message">{{ lastnameError }}</p>
            </div>

            <div class="name-container">
              <div class="input-group">
                <label>First Name:</label>
                <input
                  type="text"
                  v-model="firstname"
                  placeholder="Enter First Name" />
                <p class="error-message">{{ firstnameError }}</p>
              </div>

              <div class="input-group">
                <label>Middle Name</label>
                <input
                  type="text"
                  v-model="middlename"
                  placeholder="Enter Middle Name" />
                <p class="error-message">{{ middlenameError }}</p>
              </div>
            </div>

            <div class="name-container">
              <div class="input-group">
                <label for="course">Course</label>
                <select id="course" v-model="selectedCourse">
                  <option value="" disabled>Select a course</option>
                  <option
                    v-for="course in courses"
                    :key="course.course_id"
                    :value="course.course_id">
                    {{ course.course_name }}
                  </option>
                </select>
                <p class="error-message">{{ courseError }}</p>
              </div>

              <div class="input-group">
                <label for="year_levels">Year</label>
                <select id="year_levels" v-model="selectedYear_levels">
                  <option value="" disabled>Select a year</option>
                  <option
                    v-for="year_levels in year_levels"
                    :key="year_levels.year_id"
                    :value="year_levels.year_id">
                    {{ year_levels.year_name }}
                  </option>
                </select>
                <p class="error-message">{{ year_levelsError }}</p>
              </div>
            </div>

            <div class="input-group">
              <label for="semesters">Semester</label>
              <select id="semesters" v-model="selectedSemesters">
                <option value="" disabled>Select Semester</option>
                <option
                  v-for="semesters in semesters"
                  :key="semesters.semester_id"
                  :value="semesters.semester_id">
                  {{ semesters.semester_name }}
                </option>
              </select>
              <p class="error-message">{{ semestersError }}</p>
            </div>

            <button type="submit">Save</button>
          </form>
        </div>
        <div class="student"></div>
      </section>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from "vue";
import { validateForm } from "./validation";
import { fetchCourses } from "../router/courseService";
import { fetchYear_levels } from "../router/yearService";
import { fetchSemesters } from "../router/semesterService";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faBars,
  faBell,
  faIdCard,
  faFileAlt,
  faUserGraduate,
  faTools,
  faUsersCog,
  faGear,
  faExchangeAlt,
  faFolderTree,
  faRightFromBracket,
  faAngleDown,
  faUserPlus,
  faSave,
  faEdit,
  faTrash,
  faSync,
  faDoorOpen,
  faBuilding,
  faSitemap,
} from "@fortawesome/free-solid-svg-icons";

// Add all icons to the library in one call
library.add(
  faBars,
  faBell,
  faIdCard,
  faFileAlt,
  faUserGraduate,
  faTools,
  faUsersCog,
  faGear,
  faExchangeAlt,
  faFolderTree,
  faRightFromBracket,
  faAngleDown,
  faUserPlus,
  faSave,
  faEdit,
  faTrash,
  faSync,
  faDoorOpen,
  faBuilding,
  faSitemap
);

export default {
  components: {
    FontAwesomeIcon,
  },

  data() {
    return {
      // UI state
      activeDropdown: null,
      isSidebarCollapsed: false,
      searchQuery: "",

      // Form data
      selectedCourse: "",
      selectedYear_levels: "",
      selectedSemesters: "",
      selectedDate: "",
      imageUrl: null,

      // Error messages
      courseError: "",
      dateError: "",
      imageError: "",

      // Menu configuration
      menuItems: [
        {
          icon: ["fas", "tachometer-alt"],
          text: "Dashboard",
          to: "/dashboard",
        },
        { icon: ["fas", "clipboard-check"], text: "Classes", to: "/classes" },
        { icon: ["fas", "users-cog"], text: "Student" },
        { icon: ["fas", "file-alt"], text: "Attendance" },
        { icon: ["fas", "id-card"], text: "Student Grade Sheet" },
        { icon: ["fas", "gear"], text: "Tools", to: "/tools" },
        { icon: ["fas", "folder-tree"], text: "Apps FLDR" },
        { icon: ["fas", "right-from-bracket"], text: "Log Out" },
      ],

      // Data storage
      courses: [],
      year_levels: [],
      semesters: [],
    };
  },

  computed: {
    isDropdownOpen() {
      return (index) => this.activeDropdown === index;
    },

    filteredUsers() {
      if (!this.user) return [];
      return this.user.filter((u) =>
        u.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },

  async mounted() {
    await this.loadCourses();
    await this.loadYear_levels();
    await this.loadSemesters();
  },

  methods: {
    // Sidebar navigation methods
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
      if (this.isSidebarCollapsed) this.activeDropdown = null;
    },

    toggleDropdown(index) {
      if (this.isSidebarCollapsed) return;
      this.activeDropdown = this.activeDropdown === index ? null : index;
    },

    // Data loading methods
    async loadCourses() {
      try {
        this.courses = await fetchCourses();
      } catch (error) {
        this.courseError = "Failed to load courses. Please try again later.";
      }
    },

    async loadYear_levels() {
      try {
        this.year_levels = await fetchYear_levels();
      } catch (error) {
        this.year_levelsError = "Failed to load Year. Please try again later.";
      }
    },

    async loadSemesters() {
      try {
        this.semesters = await fetchSemesters();
      } catch (error) {
        this.semestersError =
          "Failed to load Semester. Please try again later.";
      }
    },

    // Form handling methods
    onFileChange(event) {
      const file = event.target.files[0];
      const validTypes = ["image/jpeg", "image/png", "image/webp"];

      if (!file) return;

      if (!validTypes.includes(file.type)) {
        this.imageError =
          "Invalid file type. Please upload a JPG, PNG, or WEBP image.";
        this.imageUrl = null;
      } else if (file.size > 2 * 1024 * 1024) {
        this.imageError = "Image size exceeds 2MB.";
        this.imageUrl = null;
      } else {
        this.imageError = "";
        this.imageUrl = URL.createObjectURL(file);
      }
    },

    // Action handlers
    handleMenuAction(item) {
      if (item.text === "Log Out") {
        this.handleLogout();
        return;
      }

      console.log(`${item.text} clicked`);
    },

    handleLogout() {
      if (confirm("Are you sure you want to log out?")) {
        alert("Logging out...");
        // Future implementation: Redirect to login page or clear session storage
      }
    },
  },
};
</script>

<style scoped>
.app-wrapper {
  width: 100vw;
  height: 100vh;
  overflow: hidden;
}

.box-container {
  display: grid;
  grid-template-columns: 15rem 1fr;
  grid-template-rows: 3rem 3rem 1fr;
  grid-template-areas:
    "nav top-header"
    "nav sub-navigation"
    "nav main";
  gap: 0.5rem;
  padding: 0.5rem;
  width: 100%;
  height: 100vh;
  transition: all 0.3s ease;
}

.box-container.sidebar-collapsed {
  grid-template-columns: 5rem 1fr;
}

.top-header {
  grid-area: top-header;
  background-color: #6e6d6d;
  border-radius: 0.5rem;
  position: relative;
}

/* New header content container */
.header-content {
  display: flex;
  align-items: center;
  height: 100%;
  padding: 0 1rem;
}

/* Specific toggle button styling */

.nav-container {
  grid-area: nav;
  background-color: #8e8787;
  border-radius: 0.5rem;
  padding: 1rem;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  overflow-y: auto;
}

.nav-container.collapsed {
  width: 5rem;
  padding: 1rem 0.5rem;
}

.nav-container.collapsed .nav-link {
  padding: 0.5rem;
  justify-content: center;
}

.sub-navigation {
  grid-area: sub-navigation;
  background-color: #4e4e4e;
  border-radius: 0.5rem;
}

.main-container {
  grid-area: main;
  background-color: #3d3d3d;
  border-radius: 0.5rem;
}

.nav-link {
  background-color: #efefef !important;
  color: rgb(0, 0, 0) !important;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
  width: 100%;
}

.nav-link:hover {
  background-color: #0056b3 !important;
  color: #fff !important;
}

/* Ensure navbar items are fully responsive */
.nav-pills {
  width: 100%;
}

.main-container {
  display: grid;
  grid-template-columns: 25rem auto;
  grid-template-rows: auto;
  grid-template-areas: "add-student student";
  padding: 0.5rem;
  gap: 0.5rem;
}

.add-container {
  grid-area: add-student;
  border-radius: 0.5rem;
  background-color: aliceblue;
  text-align: left;
}

.student {
  grid-area: student;
  border-radius: 0.5rem;
  background-color: aliceblue;
}

.add-container {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  text-align: center;
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

.input-group {
  text-align: left;
  border-radius: 0.5rem;
}

label {
  display: block;
  margin-bottom: 4px;
  font-weight: bold;
  color: #555;
}

input,
select {
  display: block;
  height: 45px;
  width: 100%; /* Full width of container */
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 0.875rem; /* 14px */
  box-sizing: border-box; /* Include padding in width calculation */
}

input:focus,
select:focus {
  border-color: royalblue;
  box-shadow: 0 0 5px rgba(65, 105, 225, 0.5);
  outline: none;
}

input:hover,
select:hover {
  border-color: royalblue;
  box-shadow: 0 0 5px rgba(65, 105, 225, 0.5);
  outline: none;
}

.name-container {
  display: flex;
  gap: 8px;
}

.add-container button {
  width: 100%;
  padding: 12px;
  background-color: #007bff;
  border: none;
  color: white;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

button:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

@media (max-width: 768px) {
  .box-container {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 5rem 5rem 5rem auto;
    grid-template-areas:
      "top-header top-header"
      "nav nav "
      "sub-navigation sub-navigation"
      "main main";
  }

  h5 {
    display: none;
  }

  .nav-container {
    padding: 1rem !important;
    transition: all 0.3s ease;
    display: flex !important;
    flex-direction: row !important;
  }

  .nav-pills {
    width: 3rem !important;
    background-color: #b30000 !important;
    display: contents;
    gap: 1rem !important;
  }

  .nav-container img {
    object-fit: contain;
    width: 50% !important;
    display: none !important;
  }

  .nav-link {
    padding: 0.5rem 0.5rem;
    margin: 0.5rem;
    display: flex;
    font-size: 1.8rem;
    justify-content: center;
    background-color: #3d3d3d00 !important;
    color: aliceblue !important;
  }

  .nav-link:hover {
    color: #fd1a1a !important;
  }

  .nav-link span {
    display: none;
  }

  /* Center toggle button in responsive mode */
  .top-header {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .header-content {
    display: flex;

    align-items: center;
    width: 100%;
  }

  .toggle-btn {
    margin: 0;
  }
}

/* Ensure full screen usage */
html,
body {
  margin: 0;
  padding: 0;
  overflow: hidden;
}
</style>
