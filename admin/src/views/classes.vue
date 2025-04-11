<!-- @format -->

<template>
  <div class="app-wrapper">
    <div
      class="box-container"
      :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
      <section
        class="nav-container border-end"
        :class="{ collapsed: isSidebarCollapsed }">
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
        <div class="header-content border-bottom">
          <button
            class="btn btn-sm btn-outline-light toggle-btn text-black"
            @click="toggleSidebar">
            <font-awesome-icon :icon="['fas', 'bars']" />
          </button>
          <!-- Add other header content here if needed -->
        </div>
      </section>

      <section class="sub-navigation"></section>
      <section class="main-container m-3">
        <!-- Add Course Card -->
        <div class="year card">
          Add Course
          <form @submit.prevent="handleaddcourse" class="login-form w-100">
            <div class="inpt-grp">
              <label>Course</label>
              <input type="text" v-model="course" placeholder="Enter Course" />
              <p class="error-message">{{ courseError }}</p>
            </div>
            <div class="inpt-grp">
              <label>Course Details</label>
              <input
                type="text"
                v-model="coursedetails"
                placeholder="Enter Course Details" />
              <p class="error-message">{{ coursedetailsError }}</p>
            </div>
            <div class="inpt-grp">
              <button type="submit" class="btn-style">Add Course</button>
            </div>
            <!-- Response Message -->
            <div
              v-if="responsecourseMessage"
              :class="['response-message', responseType]">
              {{ responsecourseMessage }}
            </div>
          </form>
        </div>

        <!-- Add Subject Card -->
        <div class="subject card">
          Add Subject
          <form @submit.prevent="handleaddsubject" class="login-form w-100">
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
              <label>Course</label>
              <select v-model="selectedCourse" id="course" class="form-select">
                <option value="" disabled>Select Course</option>
                <option
                  v-for="course in courses"
                  :key="course.course_id"
                  :value="course.course_id">
                  {{ course.course_name }}
                </option>
              </select>
              <p v-if="courseError" class="error-message">
                {{ courseError }}
              </p>
              <p v-if="courseLoading" class="loading-message">
                Loading courses...
              </p>
            </div>
            <div class="name-container">
              <div class="inpt-grp">
                <label>Subject code</label>
                <input
                  type="text"
                  v-model="subjectcode"
                  placeholder="Enter subject code" />
                <p class="error-message">{{ subjectcodeError }}</p>
              </div>
              <div class="inpt-grp">
                <label>Subject Name</label>
                <input
                  type="text"
                  v-model="subjectname"
                  placeholder="Enter subject name" />
                <p class="error-message">{{ subjectnameError }}</p>
              </div>
            </div>
            <div class="inpt-grp">
              <button type="submit" class="btn-style">Add Subject</button>
            </div>
            <div
              v-if="responsesubjectMessage"
              :class="['response-message', responseType]">
              {{ responsesubjectMessage }}
            </div>
          </form>
        </div>

        <!-- Add Block Card -->
        <div class="block card">
          Add Block
          <form @submit.prevent="handleaddblock" class="login-form w-100">
            <div class="inpt-grp">
              <label>Block Name</label>
              <input
                type="text"
                v-model="blockname"
                placeholder="Enter Block name" />
              <p class="error-message">{{ blocknameError }}</p>
            </div>
            <div class="inpt-grp">
              <button type="submit" class="btn-style">Add Block</button>
            </div>
            <div
              v-if="responseblockMessage"
              :class="['response-message', responseType]">
              {{ responseblockMessage }}
            </div>
          </form>
        </div>

        <!-- Add Schedule Card -->
        <div class="schedule card">
          Add Schedule
          <form @submit.prevent="handleaddschedule" class="login-form">
            <div class="inpt-grp">
              <label>Class Code</label>
              <input
                type="text"
                v-model="classcode"
                placeholder="Enter Class Code" />
              <p class="error-message">{{ classcodeError }}</p>
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
            <div class="name-container">
              <div class="inpt-grp">
                <label>Course</label>
                <select
                  v-model="selectedCourse"
                  id="course"
                  class="form-select">
                  <option value="" disabled>Select Course</option>
                  <option
                    v-for="course in courses"
                    :key="course.course_id"
                    :value="course.course_id">
                    {{ course.course_name }}
                  </option>
                </select>
                <p v-if="courseError" class="error-message">
                  {{ courseError }}
                </p>
                <p v-if="courseLoading" class="loading-message">
                  Loading courses...
                </p>
              </div>
              <div class="inpt-grp">
                <label>Block</label>
                <select v-model="selectedBlock" id="block" class="form-select">
                  <option value="" disabled>Select Block</option>
                  <option
                    v-for="block in blocks"
                    :key="block.block_id"
                    :value="block.block_id">
                    {{ block.block_name }}
                  </option>
                </select>
                <p v-if="blockError" class="error-message">
                  {{ blockError }}
                </p>
                <p v-if="blockLoading" class="loading-message">
                  Loading blocks...
                </p>
              </div>
            </div>
            <div class="inpt-grp">
              <label>Subject</label>
              <select
                v-model="selectedSubject"
                id="subject"
                class="form-select">
                <option value="" disabled>Select Subject</option>
                <option
                  v-for="subject in filteredSubjects"
                  :key="subject.subject_id"
                  :value="subject.subject_id">
                  {{ subject.subject_name }}
                </option>
              </select>
              <p v-if="subjectError" class="error-message">
                {{ subjectError }}
              </p>
              <p v-if="subjectLoading" class="loading-message">
                Loading subjects...
              </p>
            </div>
            <div class="inpt-grp">
              <label class="main-label">Schedule Time</label>

              <!-- Schedule Time Dropdown -->
              <div id="time-dropdown-container" class="custom-dropdown">
                <div class="dropdown-header" @click="toggleTimeDropdown">
                  <span v-if="selectedtime.length">{{
                    selectedtimeText()
                  }}</span>
                  <span v-else>Select Time</span>
                  <span class="dropdown-arrow">{{
                    timeIsOpen ? "▲" : "▼"
                  }}</span>
                </div>

                <div class="dropdown-content" v-if="timeIsOpen">
                  <div class="checkbox-grids">
                    <div
                      v-for="timeItem in time"
                      :key="timeItem.id"
                      class="checkbox-item">
                      <input
                        type="checkbox"
                        :id="'time-' + timeItem.id"
                        :value="timeItem.id"
                        v-model="selectedtime"
                        @click.stop />
                      <label :for="'time-' + timeItem.id" @click.stop>{{
                        timeItem.name
                      }}</label>
                    </div>
                  </div>

                  <div class="dropdown-footer">
                    <button
                      type="button"
                      class="action-btn select-all-btn"
                      @click.stop="handleSelectAllTimes"
                      :disabled="selectedtime.length === time.length">
                      Select All
                    </button>
                    <button
                      type="button"
                      class="action-btn clear-btn"
                      @click.stop="handleClearTimeSelection"
                      :disabled="!selectedtime.length">
                      Clear
                    </button>
                  </div>
                </div>
              </div>

              <!-- Error and Loading Messages -->
              <p v-if="timeError" class="error-message">{{ timeError }}</p>
              <p v-if="timeLoading" class="loading-message">Loading times...</p>
            </div>
            <div class="inpt-grp">
              <label class="main-label">Days of the Week</label>

              <!-- Days of the Week Dropdown -->
              <div id="days-dropdown-container" class="custom-dropdown">
                <div class="dropdown-header" @click="toggleDaysDropdown">
                  <span v-if="selectedDays.length">{{
                    selectedDaysText()
                  }}</span>
                  <span v-else>Select Days</span>
                  <span class="dropdown-arrow">{{
                    daysIsOpen ? "▲" : "▼"
                  }}</span>
                </div>

                <div class="dropdown-content" v-if="daysIsOpen">
                  <div class="checkbox-grid">
                    <div
                      v-for="day in days"
                      :key="day.id"
                      class="checkbox-item">
                      <input
                        type="checkbox"
                        :id="'day-' + day.id"
                        :value="day.id"
                        v-model="selectedDays"
                        @click.stop />
                      <label :for="'day-' + day.id" @click.stop>{{
                        day.acro
                      }}</label>
                    </div>
                  </div>

                  <div class="dropdown-footer">
                    <button
                      type="button"
                      class="action-btn select-all-btn"
                      @click.stop="handleSelectAllDays"
                      :disabled="selectedDays.length === days.length">
                      Select All
                    </button>
                    <button
                      type="button"
                      class="action-btn clear-btn"
                      @click.stop="handleClearDaysSelection"
                      :disabled="!selectedDays.length">
                      Clear
                    </button>
                  </div>
                </div>
              </div>

              <!-- Error and Loading Messages -->
              <p v-if="dayError" class="error-message">{{ dayError }}</p>
              <p v-if="dayLoading" class="loading-message">Loading days...</p>
            </div>

            <div class="inpt-grp">
              <button type="submit" class="btn-style">Add Schedule</button>
            </div>
            <div
              v-if="responsescheduleMessage"
              :class="['response-message', responseType]">
              {{ responsescheduleMessage }}
            </div>
          </form>
        </div>

        <div class="display card">Schedule Display</div>
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
import useDayDropdown from "@/router/composables/daysData";
import usetimeDropdown from "@/router/composables/scheduletime";
import { string } from "yup";
import { fetchCourses } from "@/router/courseService";

export default {
  components: {
    FontAwesomeIcon,
  },

  data() {
    return {
      course: "",
      courseError: "",
      coursedetails: "",
      coursedetailsError: "",
      blockname: "",
      blocknameError: "",
      firstname: "",
      firstnameError: "",
      middlename: "",
      middlenameError: "",
      year_levels: [],
      selectedYear: "",
      yearError: "",
      yearLoading: false,
      courses: [],
      selectedCourse: "",
      courseErrorError: "",
      courseLoading: false,
      semesters: [],
      selectedSemester: "",
      semesterError: "",
      semesterLoading: false,
      responseMessage: "",
      responsecourseMessage: "",
      responseblockMessage: "",
      responsesubjectMessage: "",
      responsescheduleMessage: "",
      responseType: "",
      messageTimeout: null,
      subjects: [],
      selectedSubject: "",
      subjectError: "",
      subjectLoading: false,
      classcode: "",
      classcodeError: "",
      subjectname: "",
      subjectnameError: "",
      subjectcode: "",
      subjectcodeError: "", // Add Block form - missing properties
      blocks: [],
      selectedBlock: "",
      blockError: "",
      blockLoading: false,
      filteredSubjects: [],
      //table data
      students: [],
    };
  },

  mounted() {
    this.fetchYear_levels();
    this.fetchSemesters();
    this.fetchBlocks();
    this.fetchCourses();
    this.fetchFilteredSubjects();
  },

  methods: {
    async handleaddcourse() {
      let isValid = true;
      // Reset error messages
      this.courseError = "";
      this.coursedetailsError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.course) {
        this.courseError = "Course is required";
        isValid = false;
      }

      if (!this.coursedetails) {
        this.coursedetailsError = "Course Details is required";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/addcourse.php",
            {
              course_name: this.course,
              course_details: this.coursedetails,
            }
          );

          if (response.data.success) {
            this.responsecourseMessage = "Course added successfully!";
            this.responseType = "success";
            this.resetCourseForm();
            // Optionally refresh course list here if needed
          } else {
            this.responsecourseMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responsecourseMessage = "";
            this.responseType = "";
          }, 5000);
        } catch (error) {
          console.error("Error adding course:", error);
          if (error.response) {
            console.log("Response data:", error.response.data);
            console.log("Response status:", error.response.status);
            console.log("Response headers:", error.response.headers);
          } else if (error.request) {
            console.log("Request made but no response received", error.request);
          } else {
            console.log("Error", error.message);
          }

          this.responsecourseMessage =
            "Failed to add course. Please try again.";
          this.responseType = "error";
        }
      }
    },

    resetCourseForm() {
      this.course = "";
      this.coursedetails = "";
    },

    async handleaddsubject() {
      let isValid = true;

      // Reset error messages
      this.subjectcodeError = "";
      this.subjectnameError = "";
      this.yearError = "";
      this.semesterError = "";
      this.courseError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.subjectcode) {
        this.subjectcodeError = "Subject code is required";
        isValid = false;
      }

      if (!this.subjectname) {
        this.subjectnameError = "Subject name is required";
        isValid = false;
      }

      if (!this.selectedYear) {
        this.yearError = "Year is required";
        isValid = false;
      }

      if (!this.selectedSemester) {
        this.semesterError = "Semester is required";
        isValid = false;
      }

      if (!this.selectedCourse) {
        this.courseError = "Course is required";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/addsubjects.php",
            {
              subject_code: this.subjectcode,
              subject_name: this.subjectname,
              course_id: this.selectedCourse,
              year_id: this.selectedYear,
              semester_id: this.selectedSemester,
            }
          );

          if (response.data.success) {
            this.responsesubjectMessage = "Subject added successfully!";
            this.responseType = "success";
            this.resetSubjectForm(); // Make sure this function resets all the fields
            // Optionally refresh subject list here if needed
          } else {
            this.responsesubjectMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responsesubjectMessage = "";
            this.responseType = "";
          }, 5000);
        } catch (error) {
          console.error("Error adding subject:", error);
          // Your existing error handling code...
          this.responsesubjectMessage =
            "Failed to add subject. Please try again.";
          this.responseType = "error";
        }
      }
    },

    resetSubjectForm() {
      this.subjectcode = "";
      this.subjectname = "";
      this.selectedYear = "";
      this.selectedSemester = "";
      this.selectedCourse = "";
    },

    async handleaddblock() {
      let isValid = true;

      // Reset error messages
      this.blocknameError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.blockname) {
        this.blocknameError = "Block name is required";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/addblock.php",
            {
              block_name: this.blockname,
            }
          );

          if (response.data.success) {
            this.responseblockMessage = "Course added successfully!";
            this.responseType = "success";
            this.resetblockForm();
            // Optionally refresh course list here if needed
          } else {
            this.responseblockMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responseblockMessage = "";
            this.responseType = "";
          }, 5000);
        } catch (error) {
          console.error("Error adding block:", error);
          if (error.response) {
            console.log("Response data:", error.response.data);
            console.log("Response status:", error.response.status);
            console.log("Response headers:", error.response.headers);
          } else if (error.request) {
            console.log("Request made but no response received", error.request);
          } else {
            console.log("Error", error.message);
          }

          this.responseblockMessage = "Failed to add course. Please try again.";
          this.responseType = "error";
        }
      }
    },

    resetblockForm() {
      this.blockname = "";
    },

    resetScheduleForm() {
      // Reset all form inputs

      this.selectedYear = "";
      this.selectedSemester = "";
      this.selectedCourse = "";
      this.selectedBlock = "";
      this.selectedSubject = "";
      this.selectedtime = [];
      this.selectedDays = [];

      // Close any open dropdowns
      this.timeIsOpen = false;
      this.daysIsOpen = false;
    },

    resetForm() {
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

    async fetchSubjects() {
      this.subjectLoading = true;
      this.subjectError = "";

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_subjects.php",
          {
            params: {
              year_id: this.selectedYear,
              semester_id: this.selectedSemester,
            },
          }
        );
        this.subjects = response.data;
      } catch (error) {
        console.error("Error fetching subjects", error);
        this.subjectError = "Unable to load subjects. Please try again.";
      } finally {
        this.subjectLoading = false;
      }
    },

    async fetchBlocks() {
      this.blockLoading = true;
      this.blockError = "";

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_blocks.php",
          {
            params: {
              year_id: this.selectedYear,
              semester_id: this.selectedSemester,
            },
          }
        );
        this.blocks = response.data;
      } catch (error) {
        console.error("Error fetching blocks", error);
        this.blockError = "Unable to load blocks. Please try again.";
      } finally {
        this.blockLoading = false;
      }
    },

    async fetchCourses() {
      this.courseLoading = true;
      this.courseError = "";

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_course.php"
        );
        this.courses = response.data;
      } catch (error) {
        console.error("Error fetching course", error);
        this.courseError = "Unable to load course. Please try again.";
      } finally {
        this.courseLoading = false;
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

    async fetchFilteredSubjects() {
      this.subjectLoading = true;
      this.subjectError = "";

      try {
        // Only fetch if all required filters are selected
        if (this.selectedYear && this.selectedSemester && this.selectedCourse) {
          const response = await axios.get(
            "http://localhost:8080/capstone/admin/backend/api/fetch_subject.php",
            {
              params: {
                year_id: this.selectedYear,
                semester_id: this.selectedSemester,
                course_id: this.selectedCourse,
              },
            }
          );
          this.filteredSubjects = response.data;
          this.selectedSubject = ""; // Reset subject selection
        } else {
          // If not all filters are selected, clear the subjects
          this.filteredSubjects = [];
          this.selectedSubject = "";
        }
      } catch (error) {
        console.error("Error fetching filtered subjects:", error);
        this.subjectError =
          "Unable to load filtered subjects. Please try again.";
      } finally {
        this.subjectLoading = false;
      }
    },
  },

  // Inside the methods object, replace/add this method

  watch: {
    selectedYear(newVal, oldVal) {
      if (newVal && this.selectedSemester) {
        this.fetchSubjects();
        this.fetchBlocks();
      }
    },
    selectedSemester(newVal, oldVal) {
      if (newVal && this.selectedYear) {
        this.fetchSubjects();
        this.fetchBlocks();
      }
    },
    selectedYear() {
      this.selectedSubject = ""; // Reset subject selection
      this.fetchFilteredSubjects();
    },
    selectedSemester() {
      this.selectedSubject = ""; // Reset subject selection
      this.fetchFilteredSubjects();
    },
    selectedCourse() {
      this.selectedSubject = ""; // Reset subject selection
      this.fetchFilteredSubjects();
    },
  },

  setup() {
    // Sidebar and UI State
    const { isSidebarCollapsed, toggleSidebar } = useUIState();

    // Use the composables
    const {
      days,
      getSelectedDaysText,
      selectAll: selectAllDays,
      clearSelection: clearDaysSelection,
      loadDays,
    } = useDayDropdown();

    const {
      time,
      getSelectedtimeText,
      selectall: selectAllTimes,
      clearselection: clearTimesSelection,
      loadtime,
    } = usetimeDropdown();

    // Create separate state for each dropdown
    const selectedDays = ref([]);
    const daysIsOpen = ref(false);
    const dayError = ref("");
    const dayLoading = ref(false);

    const selectedtime = ref([]);
    const timeIsOpen = ref(false);
    const timeError = ref("");
    const timeLoading = ref(false);

    // Computed property equivalent using a function for simplicity
    const selectedDaysText = () => getSelectedDaysText(selectedDays.value);
    const selectedtimeText = () => getSelectedtimeText(selectedtime.value);

    // Methods for days dropdown
    const toggleDaysDropdown = () => {
      daysIsOpen.value = !daysIsOpen.value;
      // Close the other dropdown when this one is opened
      if (daysIsOpen.value) {
        timeIsOpen.value = false;
      }
    };

    const handleClearDaysSelection = () => {
      selectedDays.value = clearDaysSelection();
    };

    const handleSelectAllDays = () => {
      selectedDays.value = selectAllDays();
    };

    // Methods for time dropdown
    const toggleTimeDropdown = () => {
      timeIsOpen.value = !timeIsOpen.value;
      // Close the other dropdown when this one is opened
      if (timeIsOpen.value) {
        daysIsOpen.value = false;
      }
    };

    const handleClearTimeSelection = () => {
      selectedtime.value = clearTimesSelection();
    };

    const handleSelectAllTimes = () => {
      selectedtime.value = selectAllTimes();
    };

    // Load data for both dropdowns
    const handleLoadData = () => {
      dayLoading.value = true;
      loadDays(() => {
        dayLoading.value = false;
      });

      timeLoading.value = true;
      loadtime(() => {
        timeLoading.value = false;
      });
    };

    // Lifecycle hooks
    onMounted(() => {
      // Call handleLoadData when component mounts
      handleLoadData();

      // Close dropdowns when clicking outside
      document.addEventListener("click", (e) => {
        const daysContainer = document.querySelector(
          "#days-dropdown-container"
        );
        if (daysContainer && !daysContainer.contains(e.target)) {
          daysIsOpen.value = false;
        }

        const timeContainer = document.querySelector(
          "#time-dropdown-container"
        );
        if (timeContainer && !timeContainer.contains(e.target)) {
          timeIsOpen.value = false;
        }
      });
    });

    // Return everything needed in the template
    return {
      // UI state
      isSidebarCollapsed,
      toggleSidebar,
      menuItems: sidebarMenuConfig,

      // Day dropdown state and methods
      days,
      selectedDays,
      daysIsOpen,
      dayError,
      dayLoading,
      selectedDaysText,
      toggleDaysDropdown,
      handleClearDaysSelection,
      handleSelectAllDays,

      // Time dropdown state and methods
      time,
      selectedtime,
      timeIsOpen,
      timeError,
      timeLoading,
      selectedtimeText,
      toggleTimeDropdown,
      handleClearTimeSelection,
      handleSelectAllTimes,
    };
  },
};
</script>

<style scoped>
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
    "nav main"
    "nav main";
  width: 100%;
  height: 100vh;
  transition: all 0.3s ease;
}

.box-container.sidebar-collapsed {
  grid-template-columns: 5rem 1fr;
}

.top-header {
  grid-area: top-header;
  background-color: #ffffff;
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

.inpt-grp button {
  width: 100%;
  padding: 0.5rem 1rem;
  border: #ababab 1px solid;
  border-radius: 0.25rem;
}

.nav-container {
  grid-area: nav;
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
  background-color: #ffffff;
  border-radius: 0.5rem;
  height: 100%; /* Adjust for header and sub-navigation */
  overflow: auto;
  padding: 0.5rem;
  box-sizing: border-box;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-template-rows: 1fr 1fr 1fr;
  grid-template-areas:
    "card1 card2 card3"
    "card4 card5 card5"
    "card4 card5 card5";
  gap: 0.5rem;
}

.year {
  grid-area: card1;
}

.block {
  grid-area: card2; /* Corrected */
}

.schedule {
  grid-area: card4;
  height: 50rem;
}

.subject {
  grid-area: card3;
}

.display {
  grid-area: card5;
}

.card {
  background-color: #ffffff;
  padding: 1rem;
  border-radius: 0.2rem;
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
  align-items: center;
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
  padding-top: 0.5rem;
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
  background-color: #e7e7e7;
}

.main-label {
  display: flex;
}
.custom-dropdown {
  position: relative;
  width: 100%;
}
.dropdown-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: white;
  cursor: pointer;
  user-select: none;
}
.dropdown-header:hover {
  border-color: #aaa;
}
.dropdown-arrow {
  margin-left: 8px;
  font-size: 12px;
}
.dropdown-content {
  position: absolute; /* Add this line */
  top: 100%; /* This positions it right below the header */
  left: 0;
  right: 0;
  margin-top: 2px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  z-index: 100;
  padding: 8px 0;
  width: 100%;
  max-height: 300px;
  overflow-y: auto;
}
.checkbox-item {
  display: flex;
  padding: 4px 12px;
  gap: 8px;
}
.checkbox-item:hover {
  background-color: #f5f5f5;
}
.checkbox-item input[type="checkbox"] {
  width: 18px; /* Change width */
  height: 18px; /* Change height */
  cursor: pointer;
  accent-color: #4caf50;
}
.checkbox-item label {
  cursor: pointer;
  user-select: none;
  font-size: 0.8rem;
  flex: 1;
}
.dropdown-footer {
  display: flex;
  padding: 4px 8px;
  border-top: 1px solid #eee;
}

.checkbox-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  padding: 8px;
}

.checkbox-grids {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  padding: 4px;
}
.action-btn {
  padding: 2px 4px;
  background-color: #434343;
  border: 1px solid #ccc;
  border-radius: 4px;
  cursor: pointer;
}
.action-btn:hover {
  background-color: #e7e7e7;
}
.action-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.select-all-btn {
  margin-right: 8px;
}
.error-message {
  color: red;
  font-size: 0.8rem;
  margin-top: 5px;
}
.loading-message {
  color: #666;
  font-size: 0.8rem;
  margin-top: 5px;
  font-style: italic;
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
