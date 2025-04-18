import './reception/ReceptionDashboard.jsx';

import '../css/app.css'; // Import TailwindCSS styles
import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import ReceptionDashboard from './reception/ReceptionDashboard.jsx';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const rootElement = document.getElementById('reception-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(
        <div className="min-h-screen bg-gray-100 flex items-center justify-center">
            <ReceptionDashboard />
        </div>
    );
}

createInertiaApp({
    resolve: name => resolvePageComponent(`./admin/${name}.jsx`, import.meta.glob('./resources/js/admin/**/*.jsx')),
    setup({ el, App, props }) {
        createRoot(el).render(
            <div className="min-h-screen bg-gray-50 text-gray-800">
                <App {...props} />
            </div>
        );
    },
});