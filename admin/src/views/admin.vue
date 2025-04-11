<!-- @format -->
<template>
  <div
    class="box-container"
    :class="{ 'sidebar-collapsed': isSidebarCollapsed }">
    <app-header
      :is-sidebar-collapsed="isSidebarCollapsed"
      @toggle-sidebar="toggleSidebar" />
    <maincontent :is-sidebar-collapsed="isSidebarCollapsed">
      <router-view />
    </maincontent>

    <app-sidebar
      :is-sidebar-collapsed="isSidebarCollapsed"
      :menu-items="menuItems" />
  </div>
</template>

<script>
import AppHeader from "@/components/header.vue";
import AppSidebar from "@/components/appsidebar.vue";
import { useUIState } from "../router/composables/useUIState";
import { adminMenuConfig } from "../router/composables/admin-menu";
import maincontent from "@/components/maincontent.vue";

export default {
  components: {
    AppHeader,
    AppSidebar,
    maincontent,
  },
  setup() {
    const { isSidebarCollapsed, toggleSidebar } = useUIState();
    return {
      isSidebarCollapsed,
      toggleSidebar,
      menuItems: adminMenuConfig,
    };
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
  grid-template-columns: 15rem auto auto;
  grid-template-rows: 3rem 3rem 1fr;
  grid-template-areas:
    "nav top-header top-header"
    "nav main main"
    "nav main main";
  width: 100%;
  height: 100vh;
  transition: all 1s ease;
  background-color: #f1f3f4;
}

.box-container.sidebar-collapsed {
  grid-template-columns: 5rem 1fr;
  transition: all 1s ease;
}

.toggle-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  font-size: 1.2rem;
}

.nav-container {
  grid-area: nav;
  transition: all 0.3s ease;
}
.top-header {
  grid-area: top-header;
  transition: all 0.3s ease;
}

.main-container {
  grid-area: main;
}
</style>
