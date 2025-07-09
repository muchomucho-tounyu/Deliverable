import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                kawaii: [
                    '"Zen Kaku Gothic New"',
                    ...defaultTheme.fontFamily.sans,
                ],
            },
        },
    },
    plugins: [forms],
};
