import React from 'react';
import { Link } from '@inertiajs/react';

const AdminDashboard = () => {
    return (
        <div className="container mt-5">
            <h1>Admin Dashboard</h1>
            <Link href="/admin/register-user" className="btn btn-success">
            Register New User
            </Link>
        </div>
    );
};

export default AdminDashboard;