<!-- @format -->

<template>
  <section class="top-header border-bottom">
    <div class="header-content">
      <button
        class="btn btn-sm btn-outline-light toggle-btn text-black"
        @click="$emit('toggleSidebar')">
        <font-awesome-icon :icon="['fas', 'bars']" />
      </button>
      <!-- Add other header content here if needed -->
    </div>
  </section>
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { useUIState } from "../router/composables/useUIState";
import { sidebarMenuConfig } from "../router/composables/menuConfig";

export default {
  name: "AppHeader",
  emits: ["toggleSidebar"],
  components: {
    FontAwesomeIcon,
  },
};
</script>

<style scoped>
.top-header {
  grid-area: top-header;
  position: sticky;
  top: 0;
  z-index: 20;
  background-color: white;
}
/* New header content container */
.header-content {
  display: flex;
  align-items: center;
  height: 100%;
  padding: 0 1rem;
}
</style>
