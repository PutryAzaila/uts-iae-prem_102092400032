/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        // === PALETTE UTAMA ===
        // Biru Muda (Primary)
        sky: {
          50:  '#f0f9ff',
          100: '#e0f2fe',
          200: '#bae6fd',
          300: '#7dd3fc',
          400: '#38bdf8',
          500: '#0ea5e9',
          600: '#0284c7',
          700: '#0369a1',
        },
        // Pink Soft (Accent)
        rose: {
          50:  '#fff1f2',
          100: '#ffe4e6',
          200: '#fecdd3',
          300: '#fda4af',
          400: '#fb7185',
          500: '#f43f5e',
        },
        // Brand Custom
        brand: {
          blue:       '#60C3F5', // #60C3F5 - biru muda segar
          'blue-dark':'#2E86C1', // #2E86C1 - biru medium
          pink:       '#F48FB1', // #F48FB1 - pink soft
          'pink-dark':'#EC4899', // #EC4899 - pink lebih tegas
          light:      '#F8FAFC', // #F8FAFC - putih bersih
          gray:       '#94A3B8', // #94A3B8 - abu netral
          dark:       '#0F172A', // #0F172A - dark navy
          'dark-card':'#1E293B', // #1E293B - card dark
          'dark-nav': '#0D1B2A', // #0D1B2A - navbar dark
        },
      },
      fontFamily: {
        display: ['"Sora"', 'sans-serif'],
        body:    ['"DM Sans"', 'sans-serif'],
        mono:    ['"JetBrains Mono"', 'monospace'],
      },
      borderRadius: {
        'pill': '9999px',
        '2xl':  '1rem',
        '3xl':  '1.5rem',
        '4xl':  '2rem',
      },
      animation: {
        'fade-in':      'fadeIn 0.6s ease-out forwards',
        'fade-up':      'fadeUp 0.7s ease-out forwards',
        'fade-down':    'fadeDown 0.5s ease-out forwards',
        'slide-in-left':'slideInLeft 0.6s ease-out forwards',
        'slide-in-right':'slideInRight 0.6s ease-out forwards',
        'float':        'float 3s ease-in-out infinite',
        'pulse-soft':   'pulseSoft 2s ease-in-out infinite',
        'shimmer':      'shimmer 2s linear infinite',
        'bounce-soft':  'bounceSoft 1.5s ease-in-out infinite',
        'spin-slow':    'spin 8s linear infinite',
      },
      keyframes: {
        fadeIn: {
          '0%':   { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeUp: {
          '0%':   { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeDown: {
          '0%':   { opacity: '0', transform: 'translateY(-20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideInLeft: {
          '0%':   { opacity: '0', transform: 'translateX(-30px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideInRight: {
          '0%':   { opacity: '0', transform: 'translateX(30px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%':      { transform: 'translateY(-10px)' },
        },
        pulseSoft: {
          '0%, 100%': { opacity: '1' },
          '50%':      { opacity: '0.7' },
        },
        shimmer: {
          '0%':   { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        bounceSoft: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%':      { transform: 'translateY(-5px)' },
        },
      },
      boxShadow: {
        'glow-blue': '0 0 20px rgba(96, 195, 245, 0.3)',
        'glow-pink': '0 0 20px rgba(244, 143, 177, 0.3)',
        'card':      '0 4px 24px rgba(0,0,0,0.08)',
        'card-dark': '0 4px 24px rgba(0,0,0,0.4)',
        'nav':       '0 2px 20px rgba(0,0,0,0.1)',
        'nav-dark':  '0 2px 20px rgba(0,0,0,0.5)',
      },
      backdropBlur: {
        xs: '2px',
      },
      transitionDuration: {
        '400': '400ms',
      },
    },
  },
  plugins: [],
}