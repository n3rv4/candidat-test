/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './templates/**/**/*.{html,twig,svg}',
        './assets/**/*.js',
        ],
      theme: {
            extend: {},
      },
      plugins: [
            require('@tailwindcss/typography'),
            require('@tailwindcss/forms'),
            require('@tailwindcss/aspect-ratio'),
      ],
}

