/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    'src/partials/**/*.{php,html}',
    'src/views/**/*.{php,html}',
    'src/utils/js/**/*.{js}'
  ],
  theme: {
    extend: {
      colors: {
        'red-mary': 'rgb(var(--color-red-mary) / <alpha-value>)'
      },
      aspectRatio: {
        '16/8': '16 / 8'
      },
      height: {
        '16/8': 'calc(95vw * 8 / 16)'
      }
    }
  },
  darkMode: 'class',
  plugins: []
}
