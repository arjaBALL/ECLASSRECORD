<!-- @format -->

<template>
  <div id="app">
    <router-view />
    <!-- This will load Login, Register, etc. -->
  </div>
</template>

<script setup></script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

html,
body,
#app {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
}

body {
  background-color: #b0d9e8;
}
</style>
