import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Blocks from "../Views/Blocks.vue";
import ChainList from "../Views/ChainList.vue";
import ChainBlocksView from "../Views/ChainBlocksView.vue";

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/chains',
        name: 'chains',
        component: ChainList
    },
    {
        path: '/blocks',
        name: 'blocks',
        component: Blocks
    },
    {
        path: '/chain/:id(\\d+)', // только цифры в id
        name: 'ChainBlocksView',
        component: ChainBlocksView,
        props: (route) => ({
            chainId: parseInt(route.params.id, 10) // явное преобразование в число
        }),
        beforeEnter: (to, from, next) => {
            const id = parseInt(to.params.id, 10);
            if (Number.isInteger(id) && id > 0) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/',
        redirect: '/dashboard'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
