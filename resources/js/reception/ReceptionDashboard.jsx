import React, { useState, useEffect } from 'react';
import axios from 'axios';

const ReceptionDashboard = () => {
    const [patients, setPatients] = useState([]);

    useEffect(() => {
        // Fetch patients from Laravel API (adjust the URL if needed)
        axios.get('/api/patients')
            .then(response => {
                setPatients(response.data);
            })
            .catch(error => {
                console.error("There was an error fetching patients!", error);
            });
    }, []);

    return (
        <div>
            <h1>Reception Dashboard</h1>
            <h2>List of Patients</h2>
            <h3>Appointments</h3>
            <ul>
                {patients.map(patient => (
                    <li key={patient.id}>{patient.name}</li>
                ))}
            </ul>
        </div>
    );
};

// Make sure to render the component only after the DOM is ready
const root = document.getElementById('reception-root');
if (root) {
    const { createRoot } = require('react-dom/client');
    const rootElement = createRoot(root);
    rootElement.render(<ReceptionDashboard />);
}

export default ReceptionDashboard;
