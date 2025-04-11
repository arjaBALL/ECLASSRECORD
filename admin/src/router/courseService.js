/** @format */

// services/courseService.js

const API_BASE_URL = "http://localhost:8080/capstone/backend/api"; // Base URL for API requests

export const fetchCourses = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/courses.php`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error ${response.status}: ${response.statusText}`);
    }

    const data = await response.json();

    if (!Array.isArray(data)) {
      throw new Error("Invalid API response format");
    }

    return data;
  } catch (error) {
    console.error("Error fetching courses:", error.message);
    throw error;
  }
};
