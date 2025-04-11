<!-- @format -->

<template>
  <div class="container-fluid p-2">
    <div class="card">
      <div class="card-header bg-light">
        <h4 class="mb-0">Teacher Registration Approvals</h4>
      </div>
      <div class="card-body">
        <!-- Status filter tabs -->
        <ul class="nav nav-tabs mb-3">
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{ active: currentStatus === 'pending' }"
              href="#"
              @click.prevent="changeStatus('pending')">
              Pending
              <span v-if="pendingCount > 0" class="badge bg-danger ms-1">{{
                pendingCount
              }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{ active: currentStatus === 'approved' }"
              href="#"
              @click.prevent="changeStatus('approved')">
              Approved
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{ active: currentStatus === 'rejected' }"
              href="#"
              @click.prevent="changeStatus('rejected')">
              Rejected
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              :class="{ active: currentStatus === 'all' }"
              href="#"
              @click.prevent="changeStatus('all')">
              All
            </a>
          </li>
        </ul>

        <!-- Search bar -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-search"></i>
            </span>
            <input
              type="text"
              class="form-control"
              placeholder="Search by name, ID or email"
              v-model="searchQuery" />
          </div>
        </div>

        <!-- Status message -->
        <div
          v-if="message"
          :class="`alert alert-${messageType} alert-dismissible fade show`"
          role="alert">
          {{ message }}
          <button
            type="button"
            class="btn-close"
            @click="message = ''"
            aria-label="Close"></button>
        </div>

        <!-- Loading indicator -->
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-2">Loading teachers data...</p>
        </div>

        <!-- Table with teachers -->
        <div
          v-else-if="filteredTeachers.length > 0"
          class="table-responsive text-center rounded border">
          <table class="table table-hover rounded">
            <thead class="table-light">
              <tr>
                <th>Teacher ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="teacher in filteredTeachers" :key="teacher.id">
                <td>{{ teacher.teacher_id }}</td>
                <td>{{ teacher.lastname }}, {{ teacher.firstname }}</td>
                <td>{{ teacher.email }}</td>
                <td>{{ formatDate(teacher.created_at) }}</td>
                <td>
                  <span
                    :class="`badge ${statusBadgeClass(
                      teacher.approval_status
                    )}`">
                    {{ teacher.approval_status.toUpperCase() }}
                  </span>
                </td>
                <td>
                  <div
                    class="btn-group"
                    v-if="teacher.approval_status === 'pending'">
                    <button
                      class="btn btn-sm btn-success me-1"
                      @click="approveTeacher(teacher.teacher_id)"
                      :disabled="processingId === teacher.teacher_id">
                      <span
                        v-if="
                          processingId === teacher.teacher_id &&
                          approvalAction === 'approve'
                        "
                        class="spinner-border spinner-border-sm me-1"
                        role="status"></span>
                      Approve
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click="rejectTeacher(teacher.teacher_id)"
                      :disabled="processingId === teacher.teacher_id">
                      <span
                        v-if="
                          processingId === teacher.teacher_id &&
                          approvalAction === 'reject'
                        "
                        class="spinner-border spinner-border-sm me-1"
                        role="status"></span>
                      Reject
                    </button>
                  </div>
                  <div v-else>
                    <button
                      v-if="teacher.approval_status === 'rejected'"
                      class="btn btn-sm btn-outline-success"
                      @click="approveTeacher(teacher.teacher_id)"
                      :disabled="processingId === teacher.teacher_id">
                      <span
                        v-if="processingId === teacher.teacher_id"
                        class="spinner-border spinner-border-sm me-1"
                        role="status"></span>
                      Approve Now
                    </button>
                    <span v-else class="text-muted">No action needed</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- No data message -->
        <div v-else class="text-center py-5">
          <div class="text-muted">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>No teachers found with the current filters</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      teachers: [],
      currentStatus: "pending",
      loading: true,
      searchQuery: "",
      message: "",
      messageType: "info",
      messageTimeout: null,
      processingId: null,
      approvalAction: null,
      pendingCount: 0,
    };
  },
  computed: {
    filteredTeachers() {
      if (!this.searchQuery) {
        return this.teachers;
      }

      const query = this.searchQuery.toLowerCase();
      return this.teachers.filter(
        (teacher) =>
          teacher.teacher_id.toLowerCase().includes(query) ||
          teacher.firstname.toLowerCase().includes(query) ||
          teacher.lastname.toLowerCase().includes(query) ||
          teacher.email.toLowerCase().includes(query)
      );
    },
  },
  mounted() {
    this.fetchTeachers();
  },
  methods: {
    async fetchTeachers() {
      this.loading = true;
      try {
        const response = await axios.get(
          `http://localhost:8080/capstone/admin/backend/api/get-pending-teacher.php?status=${this.currentStatus}`
        );

        if (response.data.success) {
          this.teachers = response.data.data;

          // Count pending applications for the badge
          const pendingResponse = await axios.get(
            `http://localhost:8080/capstone/admin/backend/api/get-pending-teacher.php?status=pending`
          );

          if (pendingResponse.data.success) {
            this.pendingCount = pendingResponse.data.data.length;
          }
        } else {
          this.showMessage(response.data.message, "danger");
        }
      } catch (error) {
        console.error("Error fetching teachers:", error);
        this.showMessage("Failed to load teachers data", "danger");
      } finally {
        this.loading = false;
      }
    },

    async approveTeacher(teacherId) {
      this.processingId = teacherId;
      this.approvalAction = "approve";

      try {
        const response = await axios.post(
          "http://localhost:8080/capstone/admin/backend/api/approve-teacher.php",
          {
            teacher_id: teacherId,
            approval_status: "approved",
          }
        );

        if (response.data.success) {
          this.showMessage("Teacher approved successfully", "success");
          await this.fetchTeachers(); // Refresh list
        } else {
          this.showMessage(response.data.message, "danger");
        }
      } catch (error) {
        console.error("Error approving teacher:", error);
        this.showMessage("Failed to approve teacher", "danger");
      } finally {
        this.processingId = null;
        this.approvalAction = null;
      }
    },

    async rejectTeacher(teacherId) {
      this.processingId = teacherId;
      this.approvalAction = "reject";

      try {
        const response = await axios.post(
          "http://localhost:8080/capstone/admin/backend/api/approve-teacher.php",
          {
            teacher_id: teacherId,
            approval_status: "rejected",
          }
        );

        if (response.data.success) {
          this.showMessage("Teacher registration rejected", "warning");
          await this.fetchTeachers(); // Refresh list
        } else {
          this.showMessage(response.data.message, "danger");
        }
      } catch (error) {
        console.error("Error rejecting teacher:", error);
        this.showMessage("Failed to reject teacher", "danger");
      } finally {
        this.processingId = null;
        this.approvalAction = null;
      }
    },

    changeStatus(status) {
      this.currentStatus = status;
      this.fetchTeachers();
    },

    formatDate(dateString) {
      const options = {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },

    statusBadgeClass(status) {
      switch (status) {
        case "pending":
          return "bg-warning text-dark";
        case "approved":
          return "bg-success";
        case "rejected":
          return "bg-danger";
        default:
          return "bg-secondary";
      }
    },

    showMessage(msg, type = "info") {
      // Clear any existing timeout
      if (this.messageTimeout) {
        clearTimeout(this.messageTimeout);
      }

      this.message = msg;
      this.messageType = type;

      // Auto-hide message after 5 seconds
      this.messageTimeout = setTimeout(() => {
        this.message = "";
      }, 5000);
    },
  },
};
</script>

<style scoped>
.table th {
  vertical-align: middle;
}

.table td {
  vertical-align: middle;
}

/* Make the search icon color match the border */
.input-group-text {
  background-color: #f8f9fa;
  border-right: none;
}

.form-control:focus {
  border-color: #86b7fe;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Ensure the input and input-group-text have matching borders when focused */
.input-group .form-control:focus + .input-group-text {
  border-color: #86b7fe;
}
</style>
