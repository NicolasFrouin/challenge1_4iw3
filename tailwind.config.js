/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: ["./assets/**/*.js", "./templates/**/*.html.twig", "./node_modules/flowbite/**/*.js"],
    theme: {
        extend: {},
    },
    plugins: [require("flowbite/plugin"), require("tailwind-scrollbar")({nocompatible: true})],
};
