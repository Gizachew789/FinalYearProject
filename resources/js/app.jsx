import './reception/ReceptionDashboard.jsx';
// resources/js/app.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import ReceptionDashboard from './reception/ReceptionDashboard.jsx';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const rootElement = document.getElementById('reception-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<ReceptionDashboard />);
}


createInertiaApp({
    resolve: name => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});

