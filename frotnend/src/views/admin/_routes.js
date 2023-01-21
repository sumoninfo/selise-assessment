const AdminRoutes = [
    {
        path     : '/dashboard',
        name     : 'AdminDashboard',
        component: () => import('./pages/Dashboard'),
        meta     : {
            title: 'Admin Dashboard'
        }
    }, {
        path     : '/profile',
        name     : 'Profile',
        component: () => import('./pages/Profile'),
        meta     : {
            title: 'Profile'
        }
    }
];

export default AdminRoutes;
