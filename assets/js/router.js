import { createRouter, createWebHistory } from 'vue-router';
import Fruits from './components/Fruits.vue';
import Favorites from './components/Favorites.vue';

const routes = [

    {
        path: '/',
        name: 'Fruits',
        component: Fruits,
    },
    {
        path: '/favorites',
        name: 'Favorites',
        component: Favorites,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
