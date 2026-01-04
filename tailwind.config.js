import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: ({ opacityVariable, opacityValue }) => {
                    if (opacityValue !== undefined)
                        return `rgb(var(--color-primary-rgb) / ${opacityValue})`;
                    if (opacityVariable !== undefined)
                        return `rgb(var(--color-primary-rgb) / var(${opacityVariable}, 1))`;
                    return `rgb(var(--color-primary-rgb))`;
                },
                accent: ({ opacityVariable, opacityValue }) => {
                    if (opacityValue !== undefined)
                        return `rgb(var(--color-accent-rgb) / ${opacityValue})`;
                    if (opacityVariable !== undefined)
                        return `rgb(var(--color-accent-rgb) / var(${opacityVariable}, 1))`;
                    return `rgb(var(--color-accent-rgb))`;
                },
                success: ({ opacityVariable, opacityValue }) => {
                    if (opacityValue !== undefined)
                        return `rgb(var(--color-success-rgb) / ${opacityValue})`;
                    if (opacityVariable !== undefined)
                        return `rgb(var(--color-success-rgb) / var(${opacityVariable}, 1))`;
                    return `rgb(var(--color-success-rgb))`;
                },
                warning: ({ opacityVariable, opacityValue }) => {
                    if (opacityValue !== undefined)
                        return `rgb(var(--color-warning-rgb) / ${opacityValue})`;
                    if (opacityVariable !== undefined)
                        return `rgb(var(--color-warning-rgb) / var(${opacityVariable}, 1))`;
                    return `rgb(var(--color-warning-rgb))`;
                },
                danger: ({ opacityVariable, opacityValue }) => {
                    if (opacityValue !== undefined)
                        return `rgb(var(--color-danger-rgb) / ${opacityValue})`;
                    if (opacityVariable !== undefined)
                        return `rgb(var(--color-danger-rgb) / var(${opacityVariable}, 1))`;
                    return `rgb(var(--color-danger-rgb))`;
                },
                surface: "var(--color-surface)",
                bg: "var(--color-bg)",
                muted: "var(--color-muted)",
            },
            boxShadow: {
                'soft': '0 2px 10px rgba(0, 0, 0, 0.03)',
                'soft-lg': '0 10px 25px rgba(0, 0, 0, 0.04)',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
            }
        },
    },

    plugins: [forms],
};
