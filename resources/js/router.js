import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Main_page from "./components/main_page.vue";
import viewForShow from "./components/viewForShow.vue";

import Login_page from "./components/login.vue";
import Register_page from "./components/register.vue";

import Personal_User_page from "./components/personal_user_page.vue";
import User_Alerts_page from "./components/alerts.vue";

import User_Profile from "./components/user_profile.vue";


const routes = [
    {
        path: "/",
        component: Main_page,
    },
    {
        path: "/the_100", 
        component: viewForShow
    },
    {
        path: "/got",
        component: viewForShow
    },
    {
        path: "/login",
        component: Login_page
    },
    {
        path: "/register",
        component: Register_page
    },
    {
        path: "/personal_user_page",
        component: Personal_User_page
    },
    {
        path: "/alerts",
        component: User_Alerts_page
    },
    {
        path: "/user_profile",
        component: User_Profile
    }

];

export default new vueRouter(
{
        mode: "history",
        routes
});
