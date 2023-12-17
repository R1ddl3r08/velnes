import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/main.css',
                'resources/js/app.js',
                'resources/js/passwordValidation.js',
                'resources/js/navbar.js',
                'resources/js/homepage.js',
                'resources/js/calendar.js',
                'resources/js/customers.js',
                'resources/js/products.js',
                'resources/js/customer.js',
                'resources/js/settingsMenu.js',
                'resources/js/generalSettings.js',
                'resources/js/userAccounts.js',
                'resources/js/employeeAccounts.js',
                'resources/js/resources.js',
                'resources/js/services.js',
                'resources/js/customerGroups.js',
                'resources/js/accountSettings.js',
            ],
            refresh: true,
        }),
    ],
});
