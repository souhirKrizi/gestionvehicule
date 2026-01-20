module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        military: {
          50: '#f0f4f0',
          100: '#d9e5d9',
          200: '#b3cbb3',
          300: '#8db18d',
          400: '#679767',
          500: '#2d5016',
          600: '#244012',
          700: '#1a3a1a',
          800: '#11200e',
          900: '#081007',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
