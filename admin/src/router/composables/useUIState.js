/** @format */

import { ref } from "vue";

export function useUIState() {
  const activeDropdown = ref(null);
  const isSidebarCollapsed = ref(false);
  const searchQuery = ref("");

  function toggleSidebar() {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    if (isSidebarCollapsed.value) activeDropdown.value = null;
  }

  function toggleDropdown(index) {
    if (isSidebarCollapsed.value) return;
    activeDropdown.value = activeDropdown.value === index ? null : index;
  }

  function isDropdownOpen(index) {
    return activeDropdown.value === index;
  }

  return {
    activeDropdown,
    isSidebarCollapsed,
    searchQuery,
    toggleSidebar,
    toggleDropdown,
    isDropdownOpen,
  };
}
