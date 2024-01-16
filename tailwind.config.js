/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: 'class',
    theme: {
      extend: {},
      fontFamily: {
          sans: ['Inter', 'sans-serif'],
      },
  },
  plugins: [],
}
