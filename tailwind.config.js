/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: ["./assets/**/*.js", "./templates/**/*.html.twig", "./node_modules/flowbite/**/*.js"],
    theme01: {
        colors: {
            'blue': '#1fb6ff',
            'purple': '#7e5bef',
            'pink': '#ff49db',
            'orange': '#ff7849',
            'green': '#13ce66',
            'yellow': '#ffc82c',
            'gray-dark': '#273444',
            'gray': '#8492a6',
            'gray-light': '#d3dce6',
        },
        fontFamily: {
            sans: ['Graphik', 'sans-serif'],
            serif: ['Merriweather', 'serif'],
        },
        roundedNone: { 'border-radius': '0' },
        rounded: { 'border-radius': '25rem' },
        roundedFull: { 'border-radius': '9999px' }
    },
    plugins: [require("flowbite/plugin"), require("tailwind-scrollbar")({nocompatible: true})],
};
