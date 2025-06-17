import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: {
          900: "#130713", // e.g. text-primary-900
          800: "#3D153D", // e.g. text-primary-800
          700: "#662466", // e.g. text-primary-700
          600: "#842F84", // e.g. text-primary-600
          500: "#A239A2", // e.g. text-primary-500
          400: "#BE47BE", // e.g. text-primary-400
          300: "#C965C9", // e.g. text-primary-300
          200: "#D383D3", // e.g. text-primary-200
          100: "#DEA1DE", // e.g. text-primary-100
          50: "#E3B0E3", // e.g. text-primary-50
        },
        secondary: {
          900: "#402104", // e.g. text-primary-900
          800: "#753C07", // e.g. text-primary-800
          700: "#AA570B", // e.g. text-primary-700
          600: "#DF730E", // e.g. text-primary-600
          500: "#F28F33", // e.g. text-primary-500
          400: "#F4A459", // e.g. text-primary-400
          300: "#F7B980", // e.g. text-primary-300
          200: "#F9CEA6", // e.g. text-primary-200
          100: "#FCE3CC", // e.g. text-primary-100
          50: "#FDEEE0", // e.g. text-primary-50
        },
      },
    },
  },

  plugins: [forms, "tailwind-scrollbar-hide"],
};
