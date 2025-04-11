<!-- @format -->

<template>
  <div class="student d-flex justify-content-center align-items-center">
    <div class="container mt-1">
      <div class="fs-3 fw-medium my-2">Courses</div>
      <!-- Loading indicator -->
      <div
        v-if="loading"
        class="d-flex justify-content-center align-yems-center text-center h-64 py-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="ml-3 mt-2 text-gray-600">Loading Courses...</p>
      </div>

      <!-- Error message -->
      <div
        v-else-if="error"
        class="alert alert-danger px-4 py-3 rounded relative d-flex justify-content-center align-items-center"
        role="alert">
        <span class="block sm:inline">{{ error }}</span>
        <button
          @click="fetchCourses"
          class="ml-4 btn btn-sm btn-outline-danger py-1 px-2 rounded">
          Retry
        </button>
      </div>

      <!-- Courses Table -->
      <div v-else class="overflow-x-auto border p-3 rounded">
        <div class="flex items-center space-x-4">
          <div class="flex items-center d-flex gap-1 justify-content-end pb-3">
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

            <!-- Filter by Year Level -->
            <select
              v-model="selectedYearLevel"
              class="px-3 py-2 border rounded-md w-auto align-text-center rounded">
              <option value="">All Year Levels</option>
              <option
                v-for="yearLevel in yearLevelsList"
                :key="yearLevel.id"
                :value="yearLevel.id">
                {{ yearLevel.name }}
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
              <option value="c.name">Course Name (A-Z)</option>
              <option value="course_id">Course ID (Low to High)</option>
              <option value="y.name">Year Level (A-Z)</option>
              <option value="year_level_id">Year Level ID (Low to High)</option>
              <option value="s.name">Section (A-Z)</option>
            </select>

            <input
              v-model="searchQuery"
              placeholder="Search Course..."
              class="px-3 py-2 border rounded-md w-auto d-flex rounded" />
          </div>
          <div
            class="text-gray-600 p-3s d-flex justify-content-between align-items-center">
            Total Courses: {{ filteredCourses.length }}
            <button class="btn btn-primary" @click="handleAddProgramClick">
              Add Program
            </button>
          </div>
        </div>

        <table
          class="w-full border-collapse bg-white border rounded shadow-md rounded-lg overflow-hidden w-100 text-center">
          <thead class="bg-blue-100">
            <tr class="border-bottom">
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
              v-for="(course, index) in paginatedCourses"
              :key="index"
              class="border-b hover:bg-gray-100 transition-colors">
              <td class="px-4 py-3 border-bottom">
                {{ course.course }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ course.year_level || "N/A" }}
              </td>
              <td class="px-4 py-3 border-bottom">
                {{ course.section || "N/A" }}
              </td>
              <td
                class="px-4 py-3 d-flex border-bottom d-flex justify-content-center align-items-center">
                <!-- Create Button -->
                <button
                  @click="createCourse(course)"
                  class="btn btn-outline-success btn-sm mx-1 custom-hover">
                  <font-awesome-icon :icon="['fas', 'file-lines']" />
                </button>

                <!-- Edit Button -->
                <button
                  @click="editCourse(course)"
                  class="btn btn-outline-primary btn-sm mx-1 custom-hover1">
                  <font-awesome-icon :icon="['fas', 'edit']" />
                </button>

                <!-- Delete Button -->
                <button
                  @click="deleteCourse(course)"
                  class="btn btn-outline-danger btn-sm mx-1 custom-hover2">
                  <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
              </td>
            </tr>
            <tr v-if="filteredCourses.length === 0">
              <td colspan="4" class="text-center py-4 text-gray-500">
                No courses found
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
      courses: [],
      loading: true,
      error: null,
      searchQuery: "",
      currentPage: 1,
      coursesPerPage: 10,
      selectedYearLevel: "", // for year level filtering
      selectedCourse: "", // for program/course filtering
      selectedSection: "", // for section filtering
      sortBy: "c.name",
      // Lists for dropdown options
      coursesList: [],
      yearLevelsList: [],
      sectionsList: [],
    };
  },

  mounted() {
    this.fetchCourses();
  },

  methods: {
    handleAddProgramClick() {
      // Option 1: Use Vue Router if it's set up
      this.$router.push("/admin-si");

      // OR Option 2: Use Event Bus pattern
      this.$emit("show-admin-si");

      // OR Option 3: Use a simple event that a parent component can listen to
      this.$emit("add-program-click");
    },
    async fetchCourses() {
      this.loading = true;
      this.error = null;
      try {
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

        let sortField = "c.name";
        let sortDir = "ASC";

        // Set sort field and direction based on this.sortBy
        if (this.sortBy) {
          sortField = this.sortBy;
        }

        params.append("sort_by", sortField);
        params.append("sort_dir", sortDir);

        const url = `http://localhost:8080/capstone/admin/backend/api/fetchprograms.php?${params.toString()}`;

        const response = await axios.get(url);

        if (response.data && response.data.success) {
          this.courses = response.data.data;
          this.extractFilterOptions();
        } else {
          throw new Error("Failed to fetch course data");
        }

        this.loading = false;
      } catch (error) {
        this.error = "Failed to fetch courses. Please try again.";
        this.loading = false;
        console.error("Error fetching courses:", error);
      }
    },

    extractFilterOptions() {
      // Extract unique courses, year levels, and sections for filter dropdowns
      const coursesSet = new Set();
      const yearLevelsSet = new Set();
      const sectionsSet = new Set();

      this.courses.forEach((course) => {
        if (course.course_id && course.course) {
          coursesSet.add(
            JSON.stringify({ id: course.course_id, name: course.course })
          );
        }

        if (course.year_level_id && course.year_level) {
          yearLevelsSet.add(
            JSON.stringify({
              id: course.year_level_id,
              name: course.year_level,
            })
          );
        }

        if (course.section_id && course.section) {
          sectionsSet.add(
            JSON.stringify({ id: course.section_id, name: course.section })
          );
        }
      });

      this.coursesList = Array.from(coursesSet)
        .map((item) => JSON.parse(item))
        .filter((item) => item.id && item.name);

      this.yearLevelsList = Array.from(yearLevelsSet)
        .map((item) => JSON.parse(item))
        .filter((item) => item.id && item.name);

      this.sectionsList = Array.from(sectionsSet)
        .map((item) => JSON.parse(item))
        .filter((item) => item.id && item.name);
    },

    createCourse(course) {
      // Implement create functionality
      console.log("Create course:", course);
      // Will need to implement modal/form to create new course
    },

    editCourse(course) {
      // Implement edit functionality
      console.log("Edit course:", course);
      // Will need to implement modal/form to edit course
    },

    deleteCourse(course) {
      // Implement delete functionality
      console.log("Delete course:", course);
      // Will need to implement confirmation dialog before deleting
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
    filteredCourses() {
      // Since we're doing server-side filtering, this is just passing through the courses
      return this.courses;
    },

    paginatedCourses() {
      const start = (this.currentPage - 1) * this.coursesPerPage;
      const end = start + this.coursesPerPage;
      return this.filteredCourses.slice(start, end);
    },

    totalPages() {
      return Math.ceil(this.filteredCourses.length / this.coursesPerPage);
    },
  },

  watch: {
    // Trigger course data reload when filters change
    selectedYearLevel() {
      this.currentPage = 1; // Reset to first page
      this.fetchCourses();
    },
    selectedCourse() {
      this.currentPage = 1;
      this.fetchCourses();
    },
    selectedSection() {
      this.currentPage = 1;
      this.fetchCourses();
    },
    sortBy() {
      this.fetchCourses();
    },
    searchQuery() {
      // Add debounce for search if needed
      const timeoutId = setTimeout(() => {
        this.currentPage = 1;
        this.fetchCourses();
      }, 500);

      return () => clearTimeout(timeoutId);
    },
  },
};
</script>

<style>
/* You can add custom styles here */
.custom-hover:hover {
  background-color: #28a745;
  color: white;
}

.custom-hover1:hover {
  background-color: #007bff;
  color: white;
}

.custom-hover2:hover {
  background-color: #dc3545;
  color: white;
}
</style>
