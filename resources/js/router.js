import Vue from 'vue';
import VueRouter from 'vue-router';

import Landing from './components/Landing';
import RoomList from './components/RoomList';
import ViewRoom from './components/ViewRoom';
import UserReservations from './components/UserReservations';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { 
            path: '/',
            redirect: '/home'
        },
        { 
            path: '/home',
            component: Landing
        },
        { 
            path: '/rooms',
            component: RoomList
        },
        { 
            path: '/user/:id',
            component: UserReservations
        },
        { 
            path: '/room/:id',
            component: ViewRoom
        },

    ],
    mode: 'history'
});