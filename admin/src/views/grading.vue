<!-- @format -->

<template>
  <div class="app-wrapper">
    <div
      class="box-container"
      :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
      <section
        class="nav-container border-end"
        :class="{ collapsed: isSidebarCollapsed }">
        <div class="text-center py-2 justify-content-center">
          <img
            src="/image/logo.png"
            alt="Responsive image"
            class="img-fluid logo mx-auto d-block"
            :class="isSidebarCollapsed ? 'w-60' : 'w-50'" />
          <h5 class="mb-3 fs-6" v-if="!isSidebarCollapsed">
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
      <section class="top-header border-bottom">
        <div class="header-content">
          <button
            class="btn btn-sm btn-outline-light toggle-btn text-black"
            @click="toggleSidebar">
            <font-awesome-icon :icon="['fas', 'bars']" />
          </button>
          <!-- Add other header content here if needed -->
        </div>
      </section>

      <section class="main-container">
        <div
          class="box card2 border-top border-start border-end border-bottom p-3 w-100 rounded-3 h-100 d-flex justify-content-start">
          <!-- Tab Navigation -->
          <ul class="nav nav-tabs" id="tabNavigation" role="tablist">
            <li class="nav-item" role="presentation">
              <a
                class="nav-link active"
                id="home-tab"
                data-bs-toggle="tab"
                href="#home"
                role="tab"
                aria-controls="home"
                aria-selected="true">
                Quiz
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                id="profile-tab"
                data-bs-toggle="tab"
                href="#profile"
                role="tab"
                aria-controls="profile"
                aria-selected="false">
                Recitation
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                id="contact-tab"
                data-bs-toggle="tab"
                href="#contact"
                role="tab"
                aria-controls="contact"
                aria-selected="false">
                Summative
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                id="project-tab"
                data-bs-toggle="tab"
                href="#project"
                role="tab"
                aria-controls="project"
                aria-selected="false">
                Project
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                id="exam-tab"
                data-bs-toggle="tab"
                href="#exam"
                role="tab"
                aria-controls="exam"
                aria-selected="false">
                Examination
              </a>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content p-3" id="tabNavigationContent">
            <div
              class="tab-pane fade show active"
              id="home"
              role="tabpanel"
              aria-labelledby="home-tab">
              <div
                class="border-bottom w-100 pb-3 justify-content-between d-flex m-2 px-2">
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
                    style="
                      display: block;
                      background-color: rgba(0, 0, 0, 0.5);
                    ">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Create Quiz</h5>
                          <button
                            type="button"
                            class="btn-close"
                            @click="isModalOpen = false"></button>
                        </div>
                        <div class="modal-body">
                          <div class="container mt-1">
                            <form @submit.prevent="submitQuiz">
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label>Quiz number</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter quiz no. " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                                <div class="inpt-grp">
                                  <label>Topic</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter quiz topic " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                              </div>
                              <div class="name-container mb-2">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Total score</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Quiz total score
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="startDate"
                                    class="form-label custom-font"
                                    >Start Date</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control custom-font"
                                    id="startDate" />
                                </div>
                              </div>
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Year</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Year
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Course</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Course
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            @click="isModalOpen = false">
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">
                            Save changes
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="profile"
              role="tabpanel"
              aria-labelledby="profile-tab">
              <div
                class="border-bottom w-100 pb-3 justify-content-between d-flex m-2 px-2">
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
                    style="
                      display: block;
                      background-color: rgba(0, 0, 0, 0.5);
                    ">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Create recitation</h5>
                          <button
                            type="button"
                            class="btn-close"
                            @click="isModalOpen = false"></button>
                        </div>
                        <div class="modal-body">
                          <div class="container mt-1">
                            <form @submit.prevent="submitRecitation">
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label>Recitation number</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter Recitation no. " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                                <div class="inpt-grp">
                                  <label>Topic</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter Recitation topic " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                              </div>
                              <div class="name-container mb-2">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Total score</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Recitation total score
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="startDate"
                                    class="form-label custom-font"
                                    >Start Date</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control custom-font"
                                    id="startDate" />
                                </div>
                              </div>
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Year</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Year
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Course</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Course
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            @click="isModalOpen = false">
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">
                            Save changes
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="contact"
              role="tabpanel"
              aria-labelledby="contact-tab">
              <div
                class="border-bottom w-100 pb-3 justify-content-between d-flex m-2 px-2">
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
                    style="
                      display: block;
                      background-color: rgba(0, 0, 0, 0.5);
                    ">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Create Summative</h5>
                          <button
                            type="button"
                            class="btn-close"
                            @click="isModalOpen = false"></button>
                        </div>
                        <div class="modal-body">
                          <div class="container mt-1">
                            <form @submit.prevent="submitQuiz">
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label>Summ number</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter summative no. " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                                <div class="inpt-grp">
                                  <label>Topic</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter summative topic " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                              </div>
                              <div class="name-container mb-2">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Total score</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Summative total score
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="startDate"
                                    class="form-label custom-font"
                                    >Start Date</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control custom-font"
                                    id="startDate" />
                                </div>
                              </div>
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Year</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Year
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Course</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Course
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            @click="isModalOpen = false">
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">
                            Save changes
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="project"
              role="tabpanel"
              aria-labelledby="project-tab">
              <div
                class="border-bottom w-100 pb-3 justify-content-between d-flex m-2 px-2">
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
                    style="
                      display: block;
                      background-color: rgba(0, 0, 0, 0.5);
                    ">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Create Project</h5>
                          <button
                            type="button"
                            class="btn-close"
                            @click="isModalOpen = false"></button>
                        </div>
                        <div class="modal-body">
                          <div class="container mt-1">
                            <form @submit.prevent="submitQuiz">
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label>Project number</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter project no. " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                                <div class="inpt-grp">
                                  <label>Topic</label>
                                  <input
                                    type="text"
                                    v-model="studentid"
                                    placeholder="Enter Project name " />
                                  <p class="error-message">
                                    {{ studentidError }}
                                  </p>
                                </div>
                              </div>
                              <div class="name-container mb-2">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Total score</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Project total points
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="startDate"
                                    class="form-label custom-font"
                                    >Start Date</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control custom-font"
                                    id="startDate" />
                                </div>
                              </div>
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Year</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Year
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Course</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Course
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            @click="isModalOpen = false">
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">
                            Save changes
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="exam"
              role="tabpanel"
              aria-labelledby="exam-tab">
              <div
                class="border-bottom w-100 pb-3 justify-content-between d-flex m-2 px-2">
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
                    style="
                      display: block;
                      background-color: rgba(0, 0, 0, 0.5);
                    ">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Create Exam</h5>
                          <button
                            type="button"
                            class="btn-close"
                            @click="isModalOpen = false"></button>
                        </div>
                        <div class="modal-body">
                          <div class="container mt-1">
                            <form @submit.prevent="submitQuiz">
                              <div class="inpt-grp mb-2">
                                <label
                                  for="exampleSelect2"
                                  class="form-label custom-font"
                                  >Examination</label
                                >
                                <select
                                  class="form-select custom-font"
                                  id="exampleSelect2">
                                  <option value="" selected>
                                    Select grading period
                                  </option>
                                </select>
                              </div>

                              <div class="name-container mb-2">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Total score</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Exam total score
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="startDate"
                                    class="form-label custom-font"
                                    >Start Date</label
                                  >
                                  <input
                                    type="date"
                                    class="form-control custom-font"
                                    id="startDate" />
                                </div>
                              </div>
                              <div class="name-container">
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Year</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Year
                                    </option>
                                  </select>
                                </div>
                                <div class="inpt-grp">
                                  <label
                                    for="exampleSelect2"
                                    class="form-label custom-font"
                                    >Course</label
                                  >
                                  <select
                                    class="form-select custom-font"
                                    id="exampleSelect2">
                                    <option value="" selected>
                                      Select Course
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            @click="isModalOpen = false">
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">
                            Save changes
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="border w-auto border-gray-300 rounded">
            <!-- Loading indicator -->
            <div v-if="loadingSchedules" class="text-center w-100 mt-4">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <p class="mt-2">Loading schedule data...</p>
            </div>

            <!-- Error message -->
            <div
              v-else-if="schedulesError"
              class="alert alert-danger mt-3 w-25 align-self-center"
              role="alert">
              {{ schedulesError }}
              <button
                @click="refreshSchedules"
                class="btn btn-sm btn-outline-danger ms-2">
                <font-awesome-icon :icon="['fas', 'sync']" /> Retry
              </button>
            </div>

            <!-- Schedules table -->
            <table
              v-else
              class="w-100 border rounded border-light overflow-hidden mt-3 text-center">
              <thead class="bg-blue-100">
                <tr>
                  <th class="text-left px-3 py-2 border-bottom">Class Code</th>
                  <th class="text-left px-3 py-2 border-bottom">
                    Subject Code
                  </th>
                  <th class="text-left px-3 py-2 border-bottom">
                    Subject Name
                  </th>
                  <th class="text-left px-3 py-2 border-bottom">Block</th>
                  <th class="text-left px-3 py-2 border-bottom">Year</th>
                  <th class="text-left px-3 py-2 border-bottom">Semester</th>
                  <th class="text-left px-3 py-2 border-bottom">Course</th>
                  <th class="text-left px-3 py-2 border-bottom">Day</th>
                  <th class="text-left px-3 py-2 border-bottom">Time</th>
                  <th class="text-left px-5 py-2 border-bottom">Action</th>
                </tr>
              </thead>

              <tbody class="bg-white border-bottom">
                <tr v-if="filteredSchedules.length === 0">
                  <td colspan="11" class="text-center px-4 py-2">
                    No schedules found
                  </td>
                </tr>
                <tr
                  v-for="(schedule, index) in paginatedSchedules"
                  :key="index"
                  class="hover:bg-gray-100 border-bottom">
                  <td class="px-4 py-1">{{ schedule.class_code }}</td>
                  <td class="px-4 py-1">{{ schedule.subject_code }}</td>
                  <td class="px-4 py-1">{{ schedule.subject_name }}</td>
                  <td class="px-4 py-1">{{ schedule.block_name }}</td>
                  <td class="px-4 py-1">{{ schedule.year_name }}</td>
                  <td class="px-4 py-1">{{ schedule.semester_name }}</td>
                  <td class="px-4 py-1">{{ schedule.course_name }}</td>
                  <td class="px-4 py-1">{{ schedule.day_name }}</td>
                  <td class="px-4 py-1">
                    {{ schedule.start_time }} - {{ schedule.end_time }}
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
              </tbody>
            </table>

            <!-- Pagination -->
            <nav
              v-if="
                !loadingSchedules && !schedulesError && schedules.length > 0
              "
              aria-label="Schedules Pagination"
              class="d-flex justify-content-end align-items-center border-top pt-3 px-3"
              style="height: 4rem">
              <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="prevPage"
                    tabindex="-1">
                    Previous
                  </a>
                </li>

                <li
                  v-for="pageNumber in pageNumbers"
                  :key="pageNumber"
                  class="page-item"
                  :class="{ active: currentPage === pageNumber }">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="currentPage = pageNumber">
                    {{ pageNumber }}
                    <span v-if="currentPage === pageNumber" class="sr-only">
                      (current)
                    </span>
                  </a>
                </li>

                <li
                  class="page-item"
                  :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" href="#" @click.prevent="nextPage">
                    Next
                  </a>
                </li>
              </ul>
            </nav>

            <div
              v-if="
                !loadingSchedules && !schedulesError && schedules.length > 0
              "
              class="mt-2 text-end text-muted d-flex justify-content-end pe-3 py-2">
              <small
                >Total schedules: {{ schedules.length }} | Filtered:
                {{ filteredSchedules.length }}</small
              >
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
//api
import axios from "axios";
import { ref, onMounted, watchEffect } from "vue";
//libraries
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { useIconLibrary } from "@/router/composables/useIconLibrary";
import { useDataServices } from "../router/composables/useDataServices";
import { useUIState } from "../router/composables/useUIState";
import { sidebarMenuConfig } from "../router/composables/menuConfig";

//form validation
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

      //tabledata
      schedules: [],
      filteredSchedules: [],
      loadingSchedules: true,
      schedulesError: null,
      currentPage: 1,
      itemsPerPage: 10,
      searchTerm: "",
      isModalOpen: false,
    };
  },

  mounted() {},

  methods: {},

  setup() {
    // Sidebar and UI State
    const { isSidebarCollapsed, toggleSidebar } = useUIState();

    return {
      isSidebarCollapsed,
      toggleSidebar,
      menuItems: sidebarMenuConfig,
    };
  },
  computed: {
    // Pagination calculations
    paginatedSchedules() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredSchedules.slice(start, end);
    },
    pageNumbers() {
      const pageCount = Math.ceil(
        this.filteredSchedules.length / this.itemsPerPage
      );
      return Array.from({ length: pageCount }, (_, i) => i + 1);
    },
    totalPages() {
      return Math.ceil(this.filteredSchedules.length / this.itemsPerPage);
    },
  },
  watch: {
    searchTerm() {
      this.filterSchedules();
    },
    isModalOpen(val) {
      if (val) {
        document.body.classList.add("modal-open");
      } else {
        document.body.classList.remove("modal-open");
      }
    },
  },
  beforeUnmount() {
    document.body.classList.remove("modal-open");
  },
};
</script>

<style scoped>
table {
  font-size: 14px;
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
}

.container-color {
  background-color: #ffffff;
}

.nav-container {
  grid-area: nav;
  padding: 1rem;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
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
  position: sticky;
  top: 3rem;
  height: 3rem;
  z-index: 999;
  display: flex;
  align-items: center;
}

.main-container {
  grid-area: main;
  height: 100vh; /* Adjust for header and sub-navigation */
  background-color: #f1f3f4;
  padding: 1rem;
  overflow: auto;
  box-sizing: border-box;
}

.logo {
  width: 3rem !important;
  height: 3rem;
}

.nav-link {
  color: rgb(0, 0, 0) !important;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
  width: 100%;
}

.nav-link:hover {
  background-color: #2e92fe !important;
  color: #fff !important;
}

/* Ensure navbar items are fully responsive */
.nav-pills {
  width: 100%;
}

.box {
  background-color: #ffffff;
  display: flex;
  justify-content: center;
}

.card2 {
  grid-area: card2;
  gap: 0.5rem;
  display: flex;
  flex-direction: column;
}

.container1,
.container2,
.container3,
.container4 {
  background-color: #ffffff;
}

.custom-hover:hover {
  background-color: green;
}
.custom-hover1:hover {
  background-color: blue;
}
.custom-hover2:hover {
  background-color: red;
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
  gap: 0.75rem;
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

button:hover,
.btn-custom:hover {
  background-color: #2e92fe;
  color: #ffffff;
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
