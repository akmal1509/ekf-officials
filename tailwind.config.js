/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/js/**/*.vue',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                rkYellow: '#f8ce00;',
                rkRed: '#f00'
            },
            backgroundImage: {
                'gradient': 'linear-gradient(127deg, #e31e28 28.31%, #f3cd1b 91.65%)',
                'b-g': 'linear-gradient(127deg, #e31e28 28.31%, #746211 91.65%)!important'
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['disabled'],
            textColor: ['disabled']
        }
    },
    plugins: [
        require('flowbite/plugin')
    ],
}

