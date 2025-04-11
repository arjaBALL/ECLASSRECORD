<!-- @format -->

<template>
  <div class="btn-container border-1 d-flex gap-3">
    <button
      @click="isModalOpen = true"
      class="w-20 px-3 h-100 rounded-1 border border-gray-300 btn-custom">
      + New
    </button>

    <!-- Bootstrap Modal -->
    <div
      v-if="isModalOpen"
      class="modal fade show"
      tabindex="-1"
      style="display: block; background-color: rgba(0, 0, 0, 0.5)">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Schedule</h5>
            <button
              type="button"
              class="btn-close"
              @click="isModalOpen = false"></button>
          </div>
          <div class="modal-body m-2">
            <form @submit.prevent="handleaddschedule" class="login-form">
              <div class="">
                <label>Class Code</label>
                <input
                  type="text"
                  v-model="classcode"
                  placeholder="Enter Class Code" />
                <p v-if="classcodeError" class="error-message">
                  {{ classcodeError }}
                </p>
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
                  <select
                    v-model="selectedBlock"
                    id="block"
                    class="form-select">
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
                <p v-if="timeError" class="error-message">
                  {{ timeError }}
                </p>
                <p v-if="timeLoading" class="loading-message">
                  Loading times...
                </p>
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

              <div class="inpt-grp d-flex justify-content-end">
                <button
                  type="submit"
                  class="btn-style p-2 rounded border color:red">
                  Add Schedule
                </button>
              </div>
              <div
                v-if="responsescheduleMessage"
                :class="['response-message', responseType]">
                {{ responsescheduleMessage }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container rounded border mt-3 h-50"></div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, watchEffect } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import useDayDropdown from "@/router/composables/daysData";
import usetimeDropdown from "@/router/composables/scheduletime";

export default {
  components: {
    FontAwesomeIcon,
  },

  setup() {
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
      subjectcodeError: "",
      blocks: [],
      selectedBlock: "",
      blockError: "",
      blockLoading: false,
      filteredSubjects: [],
      students: [],
      isModalOpen: false,
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
    async handleaddschedule() {
      let isValid = true;
      // Reset error messages
      this.classcodeError = "";
      this.yearError = "";
      this.semesterError = "";
      this.courseError = "";
      this.blockError = "";
      this.subjectError = "";
      this.timeError = "";
      this.dayError = "";

      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      // Validate fields
      if (!this.classcode) {
        this.classcodeError = "Class code is required";
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

      if (!this.selectedBlock) {
        this.blockError = "Block is required";
        isValid = false;
      }

      if (!this.selectedSubject) {
        this.subjectError = "Subject is required";
        isValid = false;
      }

      if (!this.selectedtime.length) {
        this.timeError = "Schedule time is required";
        isValid = false;
      }

      if (!this.selectedDays.length) {
        this.dayError = "Days are required";
        isValid = false;
      }

      if (isValid) {
        try {
          // Send data to backend API using axios with JSON format
          const response = await axios.post(
            "http://localhost:8080/capstone/admin/backend/api/addschedule.php",
            {
              class_code: this.classcode,
              year_id: this.selectedYear,
              semester_id: this.selectedSemester,
              course_id: this.selectedCourse,
              block_id: this.selectedBlock,
              subject_id: this.selectedSubject,
              time_ids: this.selectedtime,
              day_ids: this.selectedDays,
            }
          );

          if (response.data.success) {
            this.responsescheduleMessage = "Schedule added successfully!";
            this.responseType = "success";
            this.resetScheduleForm();
          } else {
            this.responsescheduleMessage = "Error: " + response.data.message;
            this.responseType = "error";
          }

          // Auto-clear message after 5 seconds
          this.messageTimeout = setTimeout(() => {
            this.responsescheduleMessage = "";
            this.responseType = "";
          }, 5000);
        } catch (error) {
          console.error("Error adding schedule:", error);
          this.responsescheduleMessage =
            "Failed to add schedule. Please try again.";
          this.responseType = "error";
        }
      }
    },

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

    resetScheduleForm() {
      // Reset all form inputs
      this.classcode = "";
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

    resetCourseForm() {
      this.course = "";
      this.coursedetails = "";
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

    async fetchFilteredSubjects() {
      this.subjectLoading = true;
      this.subjectError = "";

      // Only proceed if we have the required parameters
      if (!this.selectedYear || !this.selectedSemester) {
        this.filteredSubjects = [];
        this.subjectLoading = false;
        return;
      }

      try {
        const response = await axios.get(
          "http://localhost:8080/capstone/admin/backend/api/fetch_filtered_subjects.php",
          {
            params: {
              year_id: this.selectedYear,
              semester_id: this.selectedSemester,
              course_id: this.selectedCourse || "",
            },
          }
        );
        this.filteredSubjects = response.data;
      } catch (error) {
        console.error("Error fetching filtered subjects", error);
        this.subjectError =
          "Unable to load filtered subjects. Please try again.";
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
  },

  watch: {
    selectedYear(newVal) {
      if (newVal && this.selectedSemester) {
        this.fetchSubjects();
        this.fetchBlocks();
        this.fetchFilteredSubjects();
      }
    },
    selectedSemester(newVal) {
      if (newVal && this.selectedYear) {
        this.fetchSubjects();
        this.fetchBlocks();
        this.fetchFilteredSubjects();
      }
    },
    selectedCourse() {
      this.selectedSubject = ""; // Reset subject selection
      if (this.selectedYear && this.selectedSemester) {
        this.fetchFilteredSubjects();
      }
    },
  },
};
</script>

<style scoped>
.input-group {
  text-align: left;
  border-radius: 0.25rem;
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
  padding: 4px 8px; /* Comfortable spacing */
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
</style>
