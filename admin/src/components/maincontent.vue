<!-- @format -->

<template>
  <section class="main-container">
    <slot />
  </section>
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
export default {
  name: "mainContent",
  components: {
    FontAwesomeIcon,
  },
};
</script>

<style scoped>
.main-container {
  grid-area: main;
  height: auto; /* Adjust for header and sub-navigation */
  background-color: #ffffff;
  padding: 1rem;
  overflow-y: auto;
  box-sizing: border-box;
  margin: 0.75rem;
  border-radius: 0.5rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
