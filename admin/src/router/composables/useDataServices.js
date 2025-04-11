/** @format */

import { ref } from "vue";
import { fetchCourses } from "@/router/courseService";
import { fetchYear_levels } from "@/router/yearService";
import { fetchSemesters } from "@/router/semesterService";

export function useDataServices() {
  const courses = ref([]);
  const year_levels = ref([]);
  const semesters = ref([]);

  const courseError = ref("");
  const year_levelsError = ref("");
  const semestersError = ref("");

  async function loadCourses() {
    try {
      courses.value = await fetchCourses();
      courseError.value = "";
    } catch (error) {
      courseError.value = "Failed to load courses. Please try again later.";
      console.error("Error loading courses:", error);
    }
  }

  async function loadYear_levels() {
    try {
      year_levels.value = await fetchYear_levels();
      year_levelsError.value = "";
    } catch (error) {
      year_levelsError.value = "Failed to load Year. Please try again later.";
      console.error("Error loading year levels:", error);
    }
  }

  async function loadSemesters() {
    try {
      semesters.value = await fetchSemesters();
      semestersError.value = "";
    } catch (error) {
      semestersError.value = "Failed to load Semester. Please try again later.";
      console.error("Error loading semesters:", error);
    }
  }

  return {
    courses,
    year_levels,
    semesters,
    courseError,
    year_levelsError,
    semestersError,
    loadCourses,
    loadYear_levels,
    loadSemesters,
  };
}
