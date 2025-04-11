<!-- @format -->

<template>
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
</template>
<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { useUIState } from "../router/composables/useUIState";
import { sidebarMenuConfig } from "../router/composables/menuConfig";

export default {
  name: "AppSidebar", // Match the import name in main.vue
  components: {
    FontAwesomeIcon,
  },
  props: {
    isSidebarCollapsed: {
      type: Boolean,
      default: false,
    },
    menuItems: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const handleMenuAction = (item) => {
      console.log("Menu action triggered:", item);
      // Add your menu action handling logic here
    };

    return {
      handleMenuAction,
    };
  },
};
</script>
<style scoped>
.logo {
  width: 3rem !important;
  height: 3rem;
}

.nav-container {
  grid-area: nav;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
  overflow-y: auto;
  background-color: #ffffff;
}

.nav-container.collapsed {
  width: 5rem;
  padding: 1rem 0.5rem;
}

.nav-container.collapsed .nav-link {
  padding: 0.5rem;
  justify-content: center;
}

.nav-link {
  color: rgb(0, 0, 0) !important;
  border-radius: 5px;
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
</style>
