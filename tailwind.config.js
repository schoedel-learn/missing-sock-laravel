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
        // Primary Brand Colors
        primary: {
          // Coral Orange - Primary CTA buttons, key actions
          DEFAULT: '#FF5E3F',
          hover: '#E84A2F',
          light: '#FFE5E0',
          dark: '#CC4B32',
          50: '#FFF5F3',
          100: '#FFE5E0',
          200: '#FFC7BA',
          300: '#FFA894',
          400: '#FF896E',
          500: '#FF5E3F',
          600: '#E84A2F',
          700: '#CC4B32',
          800: '#A83D28',
          900: '#85301F',
        },
        // Accent Colors
        accent: {
          // Golden Yellow - Accent color for sections, buttons, text
          golden: '#F1BF61',
          'golden-hover': '#E5B04D',
          'golden-light': '#F9E8C0',
          'golden-dark': '#C99A4E',
          50: '#FEFBF3',
          100: '#F9E8C0',
          200: '#F5D893',
          300: '#F1BF61',
          400: '#E5B04D',
          500: '#C99A4E',
          600: '#B08540',
          700: '#9A7032',
          800: '#845B24',
          900: '#6E4616',
        },
        // Background Colors
        background: {
          // Main background color - soft beige
          main: '#ECE9E6',
          'main-light': '#F5F3F1',
          'main-dark': '#D9D5D0',
          white: '#FFFFFF',
          page: '#ECE9E6',
        },
        // Semantic Colors
        success: {
          DEFAULT: '#27AE60',
          light: '#E8F8F0',
          dark: '#1E8449',
          50: '#E8F8F0',
          100: '#D4F0E1',
          200: '#A7E1C3',
          300: '#7AD2A5',
          400: '#4DC387',
          500: '#27AE60',
          600: '#1E8449',
          700: '#185A32',
          800: '#12301B',
          900: '#0C0604',
        },
        warning: {
          DEFAULT: '#F39C12',
          light: '#FEF5E7',
          dark: '#D68910',
          50: '#FEF5E7',
          100: '#FDE9CF',
          200: '#FBD39F',
          300: '#F9BD6F',
          400: '#F7A73F',
          500: '#F39C12',
          600: '#D68910',
          700: '#B9760E',
          800: '#9C630C',
          900: '#7F500A',
        },
        error: {
          DEFAULT: '#f23a3c',
          light: '#fff4f4',
          dark: '#d32f31',
          50: '#fff4f4',
          100: '#ffe8e8',
          200: '#ffd1d1',
          300: '#ffbaba',
          400: '#ff6b6d',
          500: '#f23a3c',
          600: '#d32f31',
          700: '#b42527',
          800: '#951b1d',
          900: '#761113',
        },
        info: {
          DEFAULT: '#039dcf',
          light: '#e6f5fa',
          dark: '#027a9f',
          50: '#e6f5fa',
          100: '#ccebf5',
          200: '#99d7eb',
          300: '#66c3e1',
          400: '#33afd7',
          500: '#039dcf',
          600: '#027a9f',
          700: '#02586f',
          800: '#01353f',
          900: '#00120f',
        },
        // Neutral Colors
        gray: {
          50: '#F8F9FA',
          100: '#F8F9FA',
          200: '#ecedf3',
          300: '#D5DBDB',
          400: '#BDC3C7',
          500: '#95A5A6',
          600: '#8894AB',
          700: '#5A6C7D',
          800: '#34495E',
          900: '#2C3E50',
        },
      },
      fontFamily: {
        sans: ['Nunito', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
        serif: ['Playfair Display', 'Georgia', 'Times New Roman', 'serif'],
        mono: ['Inter', 'SF Mono', 'Monaco', 'Courier New', 'monospace'],
      },
      fontSize: {
        // Body text sizes
        xs: ['0.75rem', { lineHeight: '1rem', letterSpacing: '0.025em' }],      // 12px - Labels, captions
        sm: ['0.875rem', { lineHeight: '1.25rem', letterSpacing: '0.01em' }],   // 14px - Small body text
        base: ['1rem', { lineHeight: '1.6', letterSpacing: '0' }],              // 16px - Body text
        lg: ['1.125rem', { lineHeight: '1.7', letterSpacing: '-0.01em' }],      // 18px - Large body, lead text
        xl: ['1.25rem', { lineHeight: '1.75rem', letterSpacing: '-0.015em' }],  // 20px - H5, emphasized text
        
        // Heading sizes
        '2xl': ['1.5rem', { lineHeight: '2rem', letterSpacing: '-0.02em' }],   // 24px - H4
        '3xl': ['1.875rem', { lineHeight: '2.25rem', letterSpacing: '-0.025em' }], // 30px - H3
        '4xl': ['2.25rem', { lineHeight: '2.5rem', letterSpacing: '-0.03em' }],   // 36px - H2
        '5xl': ['3rem', { lineHeight: '1.2', letterSpacing: '-0.035em' }],     // 48px - H1
        '6xl': ['3.75rem', { lineHeight: '1.1', letterSpacing: '-0.04em' }],   // 60px - Hero headings
        '7xl': ['4.5rem', { lineHeight: '1.1', letterSpacing: '-0.045em' }],   // 72px - Large hero
        '8xl': ['6rem', { lineHeight: '1', letterSpacing: '-0.05em' }],        // 96px - Display headings
      },
      lineHeight: {
        none: '1',
        tight: '1.1',
        snug: '1.2',
        normal: '1.5',
        relaxed: '1.6',
        loose: '1.7',
        'extra-loose': '2',
      },
      letterSpacing: {
        tighter: '-0.05em',
        tight: '-0.025em',
        normal: '0',
        wide: '0.025em',
        wider: '0.05em',
        widest: '0.1em',
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

