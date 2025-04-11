/** @format */

import * as yup from "yup";
import { useForm, useField } from "vee-validate";

// Define the validation schema based on the database structure
const validationSchema = yup.object({
  // In the database, student_id is an auto-incrementing int,
  // but we'll validate the input as a string that will be converted to an int
  studentid: yup
    .string()
    .required("Student ID is required")
    .matches(/^[0-9]+$/, "Student ID must contain only numbers")
    .test(
      "valid-length",
      "Student ID must be a valid length",
      (value) => value && value.length > 0 && value.length <= 11
    ),

  // Maps to lname in the students table
  lastname: yup
    .string()
    .required("Last name is required")
    .matches(
      /^[A-Za-z\s'-]+$/,
      "Last name must contain only letters, spaces, hyphens, and apostrophes"
    )
    .max(50, "Last name cannot exceed 50 characters")
    .min(2, "Last name must be at least 2 characters"),

  // Maps to fname in the students table
  firstname: yup
    .string()
    .required("First name is required")
    .matches(
      /^[A-Za-z\s'-]+$/,
      "First name must contain only letters, spaces, hyphens, and apostrophes"
    )
    .max(50, "First name cannot exceed 50 characters")
    .min(2, "First name must be at least 2 characters"),

  // Maps to mname in the students table, which is nullable
  middlename: yup
    .string()
    .nullable()
    .transform((value) => (value === "" ? null : value))
    .matches(
      /^[A-Za-z\s'-]*$/,
      "Middle name must contain only letters, spaces, hyphens, and apostrophes"
    )
    .max(50, "Middle name cannot exceed 50 characters")
    .optional(),

  // Maps to course_id in the student_enrollment table
  selectedCourse: yup
    .number()
    .typeError("Course selection must be a number")
    .required("Course selection is required")
    .positive("Course ID must be positive"),

  // Maps to year_id in the student_enrollment table
  selectedYear_levels: yup
    .number()
    .typeError("Year level selection must be a number")
    .required("Year level selection is required")
    .positive("Year ID must be positive"),

  // Maps to semester_id in the student_enrollment table
  selectedSemesters: yup
    .number()
    .typeError("Semester selection must be a number")
    .required("Semester selection is required")
    .positive("Semester ID must be positive"),

  // Block is in the database but not in the form. If needed, can be added:
  selectedBlock: yup
    .number()
    .typeError("Block selection must be a number")
    .positive("Block ID must be positive")
    .nullable()
    .optional(),
});

// Function to validate the entire form
const validateForm = async (formData) => {
  try {
    // This will throw an error if validation fails
    await validationSchema.validate(formData, { abortEarly: false });
    return { isValid: true, errors: {} };
  } catch (validationError) {
    // Convert Yup's errors into a more usable format
    const errors = {};
    validationError.inner.forEach((error) => {
      errors[error.path] = error.message;
    });
    return { isValid: false, errors };
  }
};

export { validationSchema, validateForm };
