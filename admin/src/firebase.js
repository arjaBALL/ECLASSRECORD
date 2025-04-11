/** @format */

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyD5ogtcH7TVgXibf_1ePrikPg-95hjXGig",
  authDomain: "e-class-record-ms.firebaseapp.com",
  databaseURL:
    "https://e-class-record-ms-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "e-class-record-ms",
  storageBucket: "e-class-record-ms.firebasestorage.app",
  messagingSenderId: "912382035871",
  appId: "1:912382035871:web:75021460f88f0ee857dfaa",
  measurementId: "G-BX5ZKBV78M",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
