/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Filament/**/*.php",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#4A90E2',
          hover: '#357ABD',
          light: '#E8F4FD',
          dark: '#2E5A8A',
        },
        accent: {
          warm: '#FF9F43',
          'warm-hover': '#F58C2A',
          'warm-light': '#FFF3E6',
          pink: '#FFC0CB',
          'pink-hover': '#FFB3C1',
          'pink-light': '#FFF5F7',
        },
        success: {
          DEFAULT: '#27AE60',
          light: '#E8F8F0',
          dark: '#1E8449',
        },
        warning: {
          DEFAULT: '#F39C12',
          light: '#FEF5E7',
          dark: '#D68910',
        },
        error: {
          DEFAULT: '#E74C3C',
          light: '#FADBD8',
          dark: '#C0392B',
        },
        info: {
          DEFAULT: '#3498DB',
          light: '#EBF5FB',
          dark: '#2874A6',
        },
        gray: {
          900: '#2C3E50',
          800: '#34495E',
          700: '#5A6C7D',
          600: '#7B8794',
          500: '#95A5A6',
          400: '#BDC3C7',
          300: '#D5DBDB',
          200: '#ECF0F1',
          100: '#F8F9FA',
        },
      },
      fontFamily: {
        sans: ['Nunito', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
        serif: ['Playfair Display', 'Georgia', 'Times New Roman', 'serif'],
        mono: ['Inter', 'SF Mono', 'Monaco', 'Courier New', 'monospace'],
      },
      fontSize: {
        xs: ['0.75rem', { lineHeight: '1rem' }],
        sm: ['0.875rem', { lineHeight: '1.25rem' }],
        base: ['1rem', { lineHeight: '1.6' }],
        lg: ['1.125rem', { lineHeight: '1.7' }],
        xl: ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1.2' }],
        '6xl': ['3.75rem', { lineHeight: '1.1' }],
      },
      borderRadius: {
        DEFAULT: '8px',
        sm: '4px',
        md: '8px',
        lg: '12px',
        xl: '16px',
        '2xl': '24px',
      },
      boxShadow: {
        sm: '0 2px 4px rgba(0, 0, 0, 0.06)',
        DEFAULT: '0 2px 8px rgba(0, 0, 0, 0.08)',
        md: '0 4px 12px rgba(0, 0, 0, 0.1)',
        lg: '0 8px 24px rgba(0, 0, 0, 0.12)',
        xl: '0 12px 36px rgba(0, 0, 0, 0.15)',
      },
      transitionDuration: {
        fast: '150ms',
        base: '200ms',
        slow: '300ms',
        slower: '500ms',
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

