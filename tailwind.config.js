const colors = require("tailwindcss/colors");

/** @type {import("tailwindcss").Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    theme: {
        extend: {
            screens: {
                xs: "475px",
            },
            colors: {
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("flowbite/plugin"),
        require("daisyui"),
    ],
    daisyui: {
        styled: true,
        themes: ["bumblebee"],
        base: true,
        utils: true,
    },
};