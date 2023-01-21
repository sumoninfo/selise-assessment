import Home  from "@/views/web/pages/Home";
import About from "@/views/web/pages/About";

const webRoutes = [
    {
        path     : '',
        name     : 'HomePage',
        component: () => import('./pages/Home'),
        meta     : {
            title: 'Home'
        }
    },
    {
        path     : '/about',
        name     : 'AboutPage',
        component: () => import('./pages/About'),
        meta     : {
            title: 'About'
        }
    },
];

export default webRoutes;
