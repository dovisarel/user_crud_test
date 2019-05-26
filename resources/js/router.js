import Vue from 'vue'
import VueRouter from 'vue-router'

import UserList from './components/UserList.vue'
import UserForm from './components/UserForm.vue'

Vue.use(VueRouter);

const routes = [
    { path: '/', redirect: '/users' },
    { path: '/users', component: UserList },
    { path: '/users/:id', component: UserForm },
];

const router = new VueRouter({
    routes,
});

export default router;
