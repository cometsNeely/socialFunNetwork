/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import router from "./router";
import Vuex from 'vuex';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import Vue from 'vue';


window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('v-header', require('./components/header.vue').default);
Vue.component('view_for_show', require('./components/viewForShow.vue').default);
Vue.component('main_page', require('./components/main_page.vue').default);

Vue.component('login', require('./components/login.vue').default);
Vue.component('register', require('./components/register.vue').default);

Vue.component('personal_user_page', require('./components/personal_user_page.vue').default);
Vue.component('alerts', require('./components/alerts.vue').default);

Vue.component('user_profile', require('./components/user_profile.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Vuex);
Vue.use(Vuetify);

const store = new Vuex.Store({
  state: {
    currentUserName: '',
    userId: 0,
    userChecked: false,
    rateCheckedUserGlobal: true,
    userNameInfoPanel: true,
    userRegister: false,
    userLogin: false,
    mainPageButtonRegister: true,
    userFavorites: [],
    clickAddFavorites: true,
    userAvatar: "images/profile/user-blank-avatar.png",
    showOrHideUserAlert: false,
    reviewUserNameTemp: [],
    reviewUserTextTemp: [],
    likeCounter: [],
    currentUserNickNameForProfile: '',
    globalHref: '',
    currentShowId: null
  },

  getters: {
   
  },
  
  mutations: {

     getAllUsers(state) {
            axios.get('api/users')
            .then(res => {
                return res;
            });          
    },
      userIdIncrement(state) {

            axios.get('api/users')
            .then(res => {
            	let countUserId = res.data.length;
                state.userId += countUserId;
            })
    },
     showUserIdUpdate(state) {

            axios.post('api/change_rate_checked', { changeRateChecked: 0, id: [1,2] })
            .then(res => {
            	//console.log("its yes");
            })
    },
     addUserFavorites(state, isObject) {
        state.userFavorites.push(isObject);
        console.log("ARRAY is" + state.userFavorites);
     }
  },
  
  actions: {
    getAllUsersAction(context) {
      //if(context.state.userId...) {
        context.commit('getAllUsers');
     // }
    },
    userIdIncrementAction(context) {
      //if(context.state.userId...) {
        context.commit('userIdIncrement');
     // }
    },
     showUserIdUpdateAction(context) {
      //if(context.state.userId...) {
        context.commit('showUserIdUpdate');
     // }
    },
    addUserFavoritesAction(context, isObject) {
      if (context.state.userId != 0) {
       for (let i=0; i<=context.state.userFavorites.length;i++) {
        if (context.state.userFavorites[i] == isObject) {
              context.state.userFavorites.splice(i, 1);
        }
      }
        context.commit('addUserFavorites', isObject);
      }
    }
  }
});


const app = new Vue({
    el: '#app',
    router,
    store: store,
    vuetify: new Vuetify()
});

