/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,php,js}"], // Scans all your PHP and JS files
  theme: {
    extend: {
      colors: {
        // Deep Blue: Trust, Stability (Headers, Footers, Main Backgrounds)
        primary: {
          DEFAULT: '#1e3a8a', // The main navy blue
          light: '#2e5cb8',   // Lighter shade for hover states
          dark: '#172554',    // Darker shade for deep contrast
        },
        // Bright Blue/Cyan: Tech, Innovation (Icons, Sub-headers, Links)
        secondary: {
          DEFAULT: '#0ea5e9',
          light: '#38bdf8',
          dark: '#0284c7',
        },
        // Orange/Coral: Energy, Action (Buttons, Call-to-Actions)
        accent: {
          DEFAULT: '#f97316', 
          hover: '#ea580c',   // Darker orange for button hover
        },
        // Neutrals: Cleanliness, Readability
        neutral: {
          bg: '#f8fafc',      // Main page background (Slate-50)
          text: '#1e293b',    // Main body text (Slate-800)
          muted: '#64748b',   // Secondary text (Slate-500)
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Professional standard font
      }
    },
  },
  plugins: [],
}