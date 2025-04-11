<!-- @format -->

<template>
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 mb-4">
        <!-- First Column -->
        <div class="card shadow h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Upload Excel File</h5>
            <form @submit.prevent="submitForm" class="w-100">
              <div
                class="border border-secondary rounded p-3 bg-light text-center mb-3 w-100"
                :class="{ 'border-primary bg-opacity-25': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleFileDrop">
                <div class="mb-3">
                  <i
                    class="bi bi-file-earmark-arrow-up fs-1 text-secondary"></i>
                  <p class="mb-1 text-primary fw-semibold">Choose Excel file</p>
                  <small class="text-muted">or drag and drop here</small>
                </div>

                <input
                  type="file"
                  id="file-upload-1"
                  accept=".xlsx, .xls"
                  @change="handleFileUpload"
                  class="d-none" />

                <label for="file-upload-1" class="btn btn-primary">
                  Choose File
                </label>
              </div>

              <div
                v-if="excelFile"
                class="alert alert-info d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center">
                  <i
                    class="bi bi-file-earmark-excel-fill text-success me-2"></i>
                  <span class="text-truncate">{{ excelFile.name }}</span>
                </div>
                <button
                  @click="clearFile"
                  type="button"
                  class="btn btn-sm btn-outline-danger ms-3">
                  <i class="bi bi-x-lg"></i>
                </button>
              </div>

              <button
                type="submit"
                class="btn btn-success w-100"
                :disabled="loading || !excelFile">
                <span v-if="loading">
                  <span class="spinner-border spinner-border-sm me-1"></span>
                  Importing...
                </span>
                <span v-else>Upload & Import</span>
              </button>
            </form>

            <transition name="fade">
              <div
                v-if="message"
                class="alert alert-success mt-3 d-flex align-items-center w-100">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span>{{ message }}</span>
              </div>
            </transition>

            <transition name="fade">
              <div
                v-if="error"
                class="alert alert-danger mt-3 d-flex align-items-center w-100">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span>{{ error }}</span>
              </div>
            </transition>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 mb-4">
        <!-- Course Import Column -->
        <div class="card shadow h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Import Courses</h5>
            <form @submit.prevent="submitCourseImport" class="w-100">
              <div
                class="border border-secondary rounded p-3 bg-light text-center mb-3 w-100"
                :class="{ 'border-primary bg-opacity-25': isCourseDragging }"
                @dragover.prevent="isCourseDragging = true"
                @dragleave.prevent="isCourseDragging = false"
                @drop.prevent="handleCourseFileDrop">
                <div class="mb-3">
                  <i
                    class="bi bi-file-earmark-arrow-up fs-1 text-secondary"></i>
                  <p class="mb-1 text-primary fw-semibold">
                    Choose Courses Excel File
                  </p>
                  <small class="text-muted">or drag and drop here</small>
                </div>

                <input
                  type="file"
                  id="course-file-upload"
                  accept=".xlsx, .xls"
                  @change="handleCourseFileUpload"
                  class="d-none" />
                <label for="course-file-upload" class="btn btn-primary">
                  Choose File
                </label>
              </div>

              <div
                v-if="courseExcelFile"
                class="alert alert-info d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center">
                  <i
                    class="bi bi-file-earmark-excel-fill text-success me-2"></i>
                  <span class="text-truncate">{{ courseExcelFile.name }}</span>
                </div>
                <button
                  @click="clearCourseFile"
                  type="button"
                  class="btn btn-sm btn-outline-danger ms-3">
                  <i class="bi bi-x-lg"></i>
                </button>
              </div>

              <button
                type="submit"
                class="btn btn-success w-100"
                :disabled="courseLoading || !courseExcelFile">
                <span v-if="courseLoading">
                  <span class="spinner-border spinner-border-sm me-1"></span>
                  Importing...
                </span>
                <span v-else>Upload & Import Courses</span>
              </button>
            </form>

            <transition name="fade">
              <div
                v-if="courseMessage"
                class="alert alert-success mt-3 d-flex align-items-center w-100">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span>{{ courseMessage }}</span>
              </div>
            </transition>

            <transition name="fade">
              <div
                v-if="courseError"
                class="alert alert-danger mt-3 d-flex align-items-center w-100">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span>{{ courseError }}</span>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import axios from "axios";

// Student Import Variables
const excelFile = ref(null);
const message = ref("");
const error = ref("");
const loading = ref(false);
const isDragging = ref(false);
const messageTimeout = ref(null);
const errorTimeout = ref(null);

// Course Import Variables
const courseExcelFile = ref(null);
const courseMessage = ref("");
const courseError = ref("");
const courseLoading = ref(false);
const isCourseDragging = ref(false);
const courseMessageTimeout = ref(null);
const courseErrorTimeout = ref(null);

// Clear any existing timeouts when setting new messages
const setMessage = (text) => {
  clearTimeout(messageTimeout.value);
  message.value = text;

  // Set timeout to clear message after 5 seconds
  if (text) {
    messageTimeout.value = setTimeout(() => {
      message.value = "";
    }, 5000);
  }
};

const setError = (text) => {
  clearTimeout(errorTimeout.value);
  error.value = text;

  // Set timeout to clear error after 5 seconds
  if (text) {
    errorTimeout.value = setTimeout(() => {
      error.value = "";
    }, 5000);
  }
};

// Set course message with timeout
const setCourseMessage = (text) => {
  clearTimeout(courseMessageTimeout.value);
  courseMessage.value = text;

  // Set timeout to clear message after 5 seconds
  if (text) {
    courseMessageTimeout.value = setTimeout(() => {
      courseMessage.value = "";
    }, 5000);
  }
};

// Set course error with timeout
const setCourseError = (text) => {
  clearTimeout(courseErrorTimeout.value);
  courseError.value = text;

  // Set timeout to clear error after 5 seconds
  if (text) {
    courseErrorTimeout.value = setTimeout(() => {
      courseError.value = "";
    }, 5000);
  }
};

// Student File Handling
const handleFileUpload = (event) => {
  excelFile.value = event.target.files[0];
};

const handleFileDrop = (event) => {
  isDragging.value = false;
  const files = event.dataTransfer.files;
  if (files.length) {
    const file = files[0];
    if (file.name.endsWith(".xlsx") || file.name.endsWith(".xls")) {
      excelFile.value = file;
    } else {
      setError("Please upload an Excel file (.xlsx or .xls)");
    }
  }
};

const clearFile = () => {
  excelFile.value = null;
  const input = document.getElementById("file-upload-1");
  if (input) input.value = "";
};

// Course File Handling
const handleCourseFileUpload = (event) => {
  courseExcelFile.value = event.target.files[0];
};

const handleCourseFileDrop = (event) => {
  isCourseDragging.value = false;
  const files = event.dataTransfer.files;
  if (files.length) {
    const file = files[0];
    if (file.name.endsWith(".xlsx") || file.name.endsWith(".xls")) {
      courseExcelFile.value = file;
    } else {
      setCourseError("Please upload an Excel file (.xlsx or .xls)");
    }
  }
};

const clearCourseFile = () => {
  courseExcelFile.value = null;
  const input = document.getElementById("course-file-upload");
  if (input) input.value = "";
};

// Submit Functions
const submitForm = async () => {
  if (!excelFile.value) return;

  loading.value = true;
  setMessage("");
  setError("");

  const formData = new FormData();
  formData.append("excel_file", excelFile.value);

  try {
    const response = await axios.post(
      "http://localhost:8080/capstone/admin/backend/api/import_students.php",
      formData
    );
    setMessage(response.data);
  } catch (err) {
    setError(
      "Failed to import students. Please check the file format and try again."
    );
  } finally {
    loading.value = false;
  }
};

const submitCourseImport = async () => {
  if (!courseExcelFile.value) return;

  courseLoading.value = true;
  setCourseMessage("");
  setCourseError("");

  const formData = new FormData();
  formData.append("excel_file", courseExcelFile.value);

  try {
    const response = await axios.post(
      "http://localhost:8080/capstone/admin/backend/api/import_courses.php",
      formData
    );
    setCourseMessage(response.data);
  } catch (err) {
    setCourseError(
      "Failed to import courses. Please check the file format and try again."
    );
  } finally {
    courseLoading.value = false;
  }
};

// Clean up timers when component is unmounted
watch(
  () => message.value,
  (newValue, oldValue) => {
    if (!newValue && messageTimeout.value) {
      clearTimeout(messageTimeout.value);
    }
  }
);

watch(
  () => error.value,
  (newValue, oldValue) => {
    if (!newValue && errorTimeout.value) {
      clearTimeout(errorTimeout.value);
    }
  }
);

// Watch for course message and error changes to clean up timers
watch(
  () => courseMessage.value,
  (newValue, oldValue) => {
    if (!newValue && courseMessageTimeout.value) {
      clearTimeout(courseMessageTimeout.value);
    }
  }
);

watch(
  () => courseError.value,
  (newValue, oldValue) => {
    if (!newValue && courseErrorTimeout.value) {
      clearTimeout(courseErrorTimeout.value);
    }
  }
);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
