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
          <form @submit.prevent="handleaddstudent" class="login-form w-100">
            <div
              v-if="responseMessage"
              :class="
                responseType === 'success' ? 'success-message' : 'error-message'
              "
              class="response-alert">
              {{ responseMessage }}
            </div>

            <div class="inpt-grp">
              <label>Student ID</label>
              <input
                type="text"
                v-model="studentid"
                placeholder="Enter Student ID" />
              <p class="error-message">{{ studentidError }}</p>
            </div>
            <div class="inpt-grp">
              <label>Last Name</label>
              <input
                type="text"
                v-model="lastname"
                placeholder="Enter Last name" />
              <p class="error-message">{{ lastnameError }}</p>
            </div>

            <div class="inpt-grp">
              <label>First Name</label>
              <input
                type="text"
                v-model="firstname"
                placeholder="Enter First Name" />
              <p class="error-message">{{ firstnameError }}</p>
            </div>
            <div class="inpt-grp">
              <label>Middle Name</label>
              <input
                type="text"
                v-model="middlename"
                placeholder="Enter Middle name" />
              <p class="error-message">{{ middlenameError }}</p>
            </div>
            <div class="name-container">
              <div class="inpt-grp">
                <label>Year</label>
                <select
                  v-model="selectedYear"
                  id="department"
                  class="form-select">
                  <option value="" disabled>Select Year</option>
                  <option
                    v-for="year in year_levels"
                    :key="year.year_id"
                    :value="year.year_id">
                    {{ year.year_name }}
                  </option>
                </select>
                <p v-if="yearError" class="error-message">
                  {{ yearError }}
                </p>
                <p v-if="yearLoading" class="loading-message">
                  Loading year...
                </p>
              </div>
              <div class="inpt-grp">
                <label>Semester</label>
                <select
                  v-model="selectedSemester"
                  id="department"
                  class="form-select">
                  <option value="" disabled>Select Semester</option>
                  <option
                    v-for="semester in semesters"
                    :key="semester.semester_id"
                    :value="semester.semester_id">
                    {{ semester.semester_name }}
                  </option>
                </select>
                <p v-if="semesterError" class="error-message">
                  {{ semesterError }}
                </p>
                <p v-if="semesterLoading" class="loading-message">
                  Loading semester...
                </p>
              </div>
            </div>
            <div class="inpt-grp">
              <button type="submit" class="btn-style">Add User</button>
            </div>
          </form>
        </div>
        <div class="student d-flex justify-content-center align-items-center">
          <div class="container mx-auto px-4 py-6">
            <!-- Loading indicator -->
            <div v-if="loading" class="flex justify-center items-center h-64">
              <div class="spinner-border text-blue-500" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <p class="ml-3 text-gray-600">Loading student data...</p>
            </div>

            <!-- Error message -->
            <div
              v-else-if="error"
              class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
              role="alert">
              <span class="block sm:inline">{{ error }}</span>
              <button
                @click="fetchStudents"
                class="ml-4 bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">
                Retry
              </button>
            </div>

            <!-- Students Table -->
            <div v-else class="overflow-x-auto">
              <div class="flex items-center space-x-4">
                <div class="flex items-center d-flex gap-1 justify-content-end">
                  <select
                    v-model="sortBy"
                    class="px-3 py-2 border rounded-md w-auto">
                    <option value="lastname">Sort by Last Name</option>
                    <option value="firstname">Sort by First Name</option>
                  </select>
                  <input
                    v-model="searchQuery"
                    placeholder="Search students..."
                    class="px-3 py-2 border rounded-md w-auto d-flex" />
                </div>
                <div class="text-gray-600">
                  Total Students: {{ filteredStudents.length }}
                </div>
              </div>

              <table
                class="w-full border-collapse bg-white border rounded shadow-md rounded-lg overflow-hidden w-100">
                <thead class="bg-blue-100">
                  <tr class="border-bottom">
                    <th
                      class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Student ID
                    </th>
                    <th
                      class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Last Name
                    </th>
                    <th
                      class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      First Name
                    </th>
                    <th
                      class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Middle Name
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="student in paginatedStudents"
                    :key="student.studentid"
                    class="border-b hover:bg-gray-100 transition-colors">
                    <td class="px-4 py-3 border-bottom">
                      {{ student.studentid }}
                    </td>
                    <td class="px-4 py-3 border-bottom">
                      {{ student.lastname }}
                    </td>
                    <td class="px-4 py-3 border-bottom">
                      {{ student.firstname }}
                    </td>
                    <td class="px-4 py-3 border-bottom">
                      {{ student.middlename || "N/A" }}
                    </td>
                  </tr>
                  <tr v-if="filteredStudents.length === 0">
                    <td colspan="4" class="text-center py-4 text-gray-500">
                      No students found
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- Pagination -->
              <div class="flex justify-center items-center mt-4 space-x-2">
                <button
                  @click="prevPage"
                  :disabled="currentPage === 1"
                  class="px-4 py-2 border rounded bg-blue-500 text-white disabled:opacity-50">
                  Previous
                </button>
                <span class="text-gray-600">
                  Page {{ currentPage }} of {{ totalPages }}
                </span>
                <button
                  @click="nextPage"
                  :disabled="currentPage === totalPages"
                  class="px-4 py-2 border rounded bg-blue-500 text-white disabled:opacity-50">
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, watchEffect } from "vue";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { useIconLibrary } from "@/router/composables/useIconLibrary";
import { useDataServices } from "../router/composables/useDataServices";
import { useUIState } from "../router/composables/useUIState";
import { sidebarMenuConfig } from "../router/composables/menuConfig";
import { string } from "yup";

export default {
  components: {
    FontAwesomeIcon,
  },

  data() {
    return {
      studentid: "",
      studentidError: "",
      lastname: "",
      lastnameError: "",
      firstname: "",
      firstnameError: "",
      middlename: "",
      middlenameError: "",
      year_levels: [],
      selectedYear: "",
      yearError: "",
      yearLoading: false,
      semesters: [],
      selectedSemester: "",
      semesterError: "",
      semesterLoading: false,
      responseMessage: "",
      responseType: "",
      messageTimeout: null,

      //table data

      students: [],
      loading: true,
      error: null,
      searchQuery: "",
      sortBy: "lastname",
      currentPage: 1,
      studentsPerPage: 10,
    };
  },

  mounted() {
    this.fetchYear_levels();
    this.fetchSemesters();
    this.fetchStudents();
  },

  methods: {
    async handleaddstudent() {
      let isValid = true;
      //reset error message
      this.studentidError = "";
      this.lastnameError = "";
      this.firstnameError = "";
      this.middlenameError = "";
      this.yearError = "";
      this.semesterError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.studentid) {
        this.studentidError = "Student Id is required";
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
      if (!this.middlename) {
        this.middlenameError = "Middle name is required";
        isValid = false;
      }
      if (!this.selectedYear) {
        this.yearError = "Year level is required";
        isValid = false;
      }
      if (!this.selectedSemester) {
        this.semesterError = "Semester is required";
        isValid = false;
      }

      if (isValid) {
        // Prepare form data to send
        const formData = new FormData();
        formData.append("studentid", this.studentid);
        formData.append("lastname", this.lastname);
        formData.append("firstname", this.firstname);
        formData.append("middlename", this.middlename);
        formData.append("year_name", this.selectedYear);
        formData.append("semester_name", this.selectedSemester);

        try {
          // Send data to backend API using axios
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/addstudent.php",
            formData
          );

          if (response.data.success) {
            this.responseMessage = "Student added successfully!";
            this.responseType = "success";
            this.resetForm();
            // this.fetchStudents(); // Assuming you want to refresh the list after adding
          } else {
            this.responseMessage = "Error: " + response.data.error;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responseMessage = "";
            this.responseType = "";
          }, 5000);

          console.log(response.data);
        } catch (error) {
          console.error("Error adding student:", error);
          if (error.response) {
            console.log("Response data:", error.response.data);
            console.log("Response status:", error.response.status);
            console.log("Response headers:", error.response.headers);
          } else if (error.request) {
            console.log("Request made but no response received", error.request);
          } else {
            console.log("Error", error.message);
          }

          this.responseMessage = "Failed to add student. Please try again.";
          this.responseType = "error";
        }
      }
    },

    resetForm() {
      this.studentid = "";
      this.lastname = "";
      this.firstname = "";
      this.middlename = "";
      this.selectedYear = "";
      this.selectedSemester = "";
    },

    async fetchYear_levels() {
      this.yearLoading = true;
      this.yearError = "";

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_year.php"
        );
        this.year_levels = response.data;
      } catch (error) {
        console.error("Error fetching year", error);
        this.yearError = "Unable to load year level. Please try again.";
      } finally {
        this.yearLoading = false;
      }
    },

    async fetchSemesters() {
      this.semesterLoading = true;
      this.semesterError = "";

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_semester.php"
        );
        this.semesters = response.data;
      } catch (error) {
        console.error("Error fetching semester", error);
        this.semesterError = "Unable to load semesters. Please try again.";
      } finally {
        this.semesterLoading = false;
      }
    },

    async fetchStudents() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetchstudent.php"
        );
        this.students = response.data;
        this.loading = false;
      } catch (error) {
        this.error = "Failed to fetch students. Please try again.";
        this.loading = false;
        console.error("Error fetching students:", error);
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
  },

  computed: {
    filteredStudents() {
      let filtered = this.students;

      // Search filtering
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(
          (student) =>
            student.lastname.toLowerCase().includes(query) ||
            student.firstname.toLowerCase().includes(query) ||
            student.studentid.toString().includes(query)
        );
      }

      // Sorting
      filtered.sort((a, b) => {
        return a[this.sortBy].localeCompare(b[this.sortBy]);
      });

      return filtered;
    },
    paginatedStudents() {
      const start = (this.currentPage - 1) * this.studentsPerPage;
      const end = start + this.studentsPerPage;
      return this.filteredStudents.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredStudents.length / this.studentsPerPage);
    },
    pageNumbers() {
      return Array.from({ length: this.totalPages }, (_, i) => i + 1);
    },
  },

  setup() {
    // Sidebar and UI State
    const { isSidebarCollapsed, toggleSidebar } = useUIState();

    return {
      isSidebarCollapsed,
      toggleSidebar,
      menuItems: sidebarMenuConfig,
    };
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

body {
  font-family: "Poppins", sans-serif;
}

option {
  color: #333;
}
/* Reset PrimeVue styles */
.custom-input {
  all: unset; /* Removes all inherited styles */
  border: 1px solid #ccc;
  padding: 8px;
  border-radius: 4px;
  width: 100%;
  font-size: 16px;
  background-color: white;
}

/* Label styling */
.input-group label {
  font-weight: bold;
  display: block;
}

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
  background-color: #acacac;
  border-radius: 0.5rem;
  position: sticky;
}
/* New header content container */
.header-content {
  display: flex;
  align-items: center;
  height: 100%;
  padding: 0 1rem;
}

/* New header content container */
.header-content {
  display: flex;
  align-items: center;
  height: 100%;
  padding: 0 1rem;
}

/* Specific toggle button styling */
.toggle-btn {
  margin-left: 0.5rem;
}

.nav-container {
  grid-area: nav;
  background-color: #8e8787;
  border-radius: 0.5rem;
  padding: 1rem;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: auto;
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
  position: sticky;
  top: 3rem;
  height: 3rem;
  z-index: 999;
  display: flex;
  align-items: center;
}

.main-container {
  grid-area: main;
  background-color: #3d3d3d;
  border-radius: 0.5rem;
  height: calc(95vh - 6rem); /* Adjust for header and sub-navigation */
  overflow: hidden;
  padding: 0.5rem;
  box-sizing: border-box;
  display: grid;
  grid-template-columns: 25rem auto;
  grid-template-rows: auto;
  grid-template-areas: "add-student student";
  gap: 0.5rem;
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

.add-container {
  grid-area: add-student;
  border-radius: 0.5rem;
  background-color: aliceblue;
  text-align: left;
  padding: 20px;
  position: relative;
  box-sizing: border-box;
  overflow-y: auto;
}

.add-container::-webkit-scrollbar {
}

.student {
  grid-area: student;
  border-radius: 0.5rem;
  background-color: aliceblue;
  overflow-y: auto;
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
  padding: 8px 12px; /* Comfortable spacing */
  width: 100%; /* Ensures consistent width */
  box-sizing: border-box; /* Prevents overflow */
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
