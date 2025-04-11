<!-- @format -->

<template>
  <div class="student d-flex justify-content-center align-items-center">
    <div class="w-100">
      <div class="fs-3 fw-medium">Students</div>
      <!-- Loading indicator -->
      <div
        v-if="loading"
        class="d-flex justify-content-center align-items-center h-64">
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
      <div v-else class="overflow-x-auto border p-3 rounded">
        <div class="flex items-center space-x-4">
          <div class="flex items-center d-flex gap-1 justify-content-end pb-3">
            <!-- Filter by Year Level -->
            <select
              v-model="selectedYearLevel"
              class="px-3 py-2 border rounded-md w-auto align-text-center rounded">
              <option value="">All Year Levels</option>
              <option
                v-for="year in yearLevelsList"
                :key="year.id"
                :value="year.id">
                {{ year.name }}
              </option>
            </select>

            <!-- Filter by Program/Course -->
            <select
              v-model="selectedCourse"
              class="px-3 py-2 border rounded-md w-auto align-text-center rounded">
              <option value="">All Programs</option>
              <option
                v-for="course in coursesList"
                :key="course.id"
                :value="course.id">
                {{ course.name }}
              </option>
            </select>

            <!-- Filter by Section -->
            <select
              v-model="selectedSection"
              class="px-3 py-2 border rounded-md w-auto align-text-center rounded">
              <option value="">All Sections</option>
              <option
                v-for="section in sectionsList"
                :key="section.id"
                :value="section.id">
                {{ section.name }}
              </option>
            </select>

            <!-- Sorting Dropdown -->
            <select
              v-model="sortBy"
              class="px-3 py-2 border rounded-md w-auto align-text-center rounded">
              <option value="last_name">Last Name (A-Z)</option>
              <option value="year_level_id">Year Level (Low to High)</option>
              <option value="year_level_id_desc">
                Year Level (High to Low)
              </option>
              <option value="course">Program (A-Z)</option>
              <option value="course_desc">Program (Z-A)</option>
              <option value="section">Section (A-Z)</option>
              <option value="section_desc">Section (Z-A)</option>
            </select>

            <input
              v-model="searchQuery"
              placeholder="Search students..."
              class="px-3 py-2 border rounded-md w-auto d-flex rounded" />
          </div>
          <div class="text-gray-600">
            Total Students: {{ filteredStudents.length }}
          </div>
        </div>

        <table
          class="w-full border-collapse bg-white border rounded shadow-md rounded-lg overflow-hidden w-100 text-center">
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
                Email
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Course
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Year Level
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Section
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="student in paginatedStudents"
              :key="student.student_id"
              class="border-b hover:bg-gray-100 transition-colors">
              <td class="px-4 py-3 border-bottom">
                {{ student.student_school_id }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.last_name }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.first_name }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.email }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.course }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.year_level }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ student.section }}
              </td>
              <td class="px-4 py-2 d-flex">
                <!-- Create Button -->
                <button
                  class="btn btn-outline-success btn-sm mx-1 custom-hover">
                  <font-awesome-icon :icon="['fas', 'user-plus']" />
                </button>

                <!-- Edit Button -->
                <button
                  class="btn btn-outline-primary btn-sm mx-1 custom-hover1">
                  <font-awesome-icon :icon="['fas', 'edit']" />
                </button>

                <!-- Delete Button -->
                <button
                  class="btn btn-outline-danger btn-sm mx-1 custom-hover2">
                  <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
              </td>
            </tr>
            <tr v-if="filteredStudents.length === 0">
              <td colspan="7" class="text-center py-4 text-gray-500">
                No students found
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-4 gap-2 align-items-center">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="px-4 py-2 btn btn-primary">
            Previous
          </button>
          <span class="text-gray-600">
            Page {{ currentPage }} of {{ totalPages }}
          </span>
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="px-4 py-2 btn btn-primary">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

export default {
  components: {
    FontAwesomeIcon,
  },
  data() {
    return {
      messageTimeout: null,
      students: [],
      loading: true,
      error: null,
      searchQuery: "",
      currentPage: 1,
      studentsPerPage: 10,
      selectedYearLevel: "", // for year level filtering
      selectedCourse: "", // for program/course filtering
      selectedSection: "", // for section filtering
      sortBy: "last_name",
      // Lists for dropdown options
      coursesList: [],
      yearLevelsList: [],
      sectionsList: [],
    };
  },

  mounted() {
    this.fetchStudents();
    this.fetchFilterOptions();
  },

  methods: {
    async fetchStudents() {
      this.loading = true;
      this.error = null;
      try {
        // Build query parameters for server-side filtering and sorting
        const params = new URLSearchParams();

        if (this.searchQuery) {
          params.append("search", this.searchQuery);
        }

        if (this.selectedYearLevel) {
          params.append("year_level_id", this.selectedYearLevel);
        }

        if (this.selectedCourse) {
          params.append("course_id", this.selectedCourse);
        }

        if (this.selectedSection) {
          params.append("section_id", this.selectedSection);
        }

        // Parse sort option
        let sortField = "last_name";
        let sortDir = "ASC";

        if (this.sortBy === "year_level_id_desc") {
          sortField = "year_level_id";
          sortDir = "DESC";
        } else if (this.sortBy === "course_desc") {
          sortField = "course_id";
          sortDir = "DESC";
        } else if (this.sortBy === "section_desc") {
          sortField = "section_id";
          sortDir = "DESC";
        } else if (this.sortBy) {
          sortField = this.sortBy;
        }

        params.append("sort_by", sortField);
        params.append("sort_dir", sortDir);

        const url = `http://localhost:8080/capstone/admin/backend/api/fetchstudent.php?${params.toString()}`;

        const response = await axios.get(url);

        if (response.data && response.data.success) {
          this.students = response.data.data;
        } else {
          throw new Error("Failed to fetch student data");
        }

        this.loading = false;
      } catch (error) {
        this.error = "Failed to fetch students. Please try again.";
        this.loading = false;
        console.error("Error fetching students:", error);
      }
    },

    async fetchFilterOptions() {
      try {
        // In a real application, you would fetch these from your backend
        // but for now we'll extract them from the student data when it loads
        this.$watch("students", () => {
          const coursesSet = new Set();
          const yearLevelsSet = new Set();
          const sectionsSet = new Set();

          this.students.forEach((student) => {
            coursesSet.add(
              JSON.stringify({ id: student.course_id, name: student.course })
            );
            yearLevelsSet.add(
              JSON.stringify({
                id: student.year_level_id,
                name: student.year_level,
              })
            );
            sectionsSet.add(
              JSON.stringify({ id: student.section_id, name: student.section })
            );
          });

          this.coursesList = Array.from(coursesSet).map((item) =>
            JSON.parse(item)
          );
          this.yearLevelsList = Array.from(yearLevelsSet).map((item) =>
            JSON.parse(item)
          );
          this.sectionsList = Array.from(sectionsSet).map((item) =>
            JSON.parse(item)
          );
        });
      } catch (error) {
        console.error("Error fetching filter options:", error);
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
      // Since we're doing server-side filtering, this is just a placeholder
      // In case we want to do additional client-side filtering
      return this.students;
    },

    paginatedStudents() {
      const start = (this.currentPage - 1) * this.studentsPerPage;
      const end = start + this.studentsPerPage;
      return this.filteredStudents.slice(start, end);
    },

    totalPages() {
      return Math.ceil(this.filteredStudents.length / this.studentsPerPage);
    },
  },

  watch: {
    // Trigger student data reload when filters change
    selectedYearLevel() {
      this.currentPage = 1; // Reset to first page
      this.fetchStudents();
    },
    selectedCourse() {
      this.currentPage = 1;
      this.fetchStudents();
    },
    selectedSection() {
      this.currentPage = 1;
      this.fetchStudents();
    },
    sortBy() {
      this.fetchStudents();
    },

    searchQuery() {
      // Add debounce for search if needed
      const timeoutId = setTimeout(() => {
        this.currentPage = 1;
        this.fetchStudents();
      }, 500);

      return () => clearTimeout(timeoutId);
    },
  },
};
</script>

<style>
/* Add any custom styles here */
</style>
