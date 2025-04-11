/** @format */

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // Import router
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from "@fortawesome/free-solid-svg-icons";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js"; // For modals, tooltips, etc.
import PrimeVue from "primevue/config";

// Import a PrimeVue theme (choose one)
import Aura from "@primeuix/themes/aura";
import "primeicons/primeicons.css"; // PrimeIcons for icons
import DataTable from "primevue/datatable";
import Column from "primevue/column";

const app = createApp(App);
app.use(PrimeVue);
app.component("DataTable", DataTable);
app.component("Column", Column);
app.use(router); // Make sure Vue uses router
app.mount("#app"); // Mount app to HTML
