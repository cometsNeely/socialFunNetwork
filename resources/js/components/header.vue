<template>

<b-navbar type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item :to="main_page">Home</b-nav-item>

    {{ userRegister }} 
    {{ userLogin }}
    {{ checkGetCurrentUserAlerts }}

      <b-nav-item-dropdown text="TV-Shows" right v-if="isRegister || isLogin">
      <div v-for="show in shows">
        <b-dropdown-item @click="showHref(show.href)">{{ show.title }}</b-dropdown-item>
      </div>
      </b-nav-item-dropdown>

      <b-nav-item-dropdown text="Movies" right v-if="isRegister || isLogin">
        <b-dropdown-item href="#">...</b-dropdown-item>
      </b-nav-item-dropdown>

    </b-navbar-nav>




    <b-nav pills class="ml-auto">
    {{getCurrentUser}}

    <div style="font-size: 1.7rem;" class="d-flex">
    <b-icon icon="bell-fill" v-if="userChecked && !showReviewInAlerts"></b-icon>
    <b-icon icon="bell-fill" v-if="userChecked && showReviewInAlerts" @click="personalAlerts" variant="warning"></b-icon>
    </div>


    <b-nav-item active v-if="userChecked && userNameInfoPanel" @click="personalInfoOpen"> 
    Welcome, {{current_user}}
    </b-nav-item>

    </b-nav>

    <b-button variant="danger" v-if="userChecked && userNameInfoPanel" @click="userExit" style="margin-left: 15px;"> 
    Exit
    </b-button>

<b-navbar-nav>
    <b-nav-item :to="login">Login</b-nav-item>
    <b-nav-item :to="register">Register</b-nav-item>
</b-navbar-nav>


  </b-navbar>

</template>

<script>

import vueRouter from 'vue-router';

Vue.use(vueRouter);

//Vue.prototype.$eventBus = new Vue();

export default {
data() {
        return {
        current_user: '',
        userChecked: false,
            main_page: "/",
            login: "/login",
            register: "/register",
            shows: [
                {
                    title: "The 100",
                    href: "/the_100"
                },
                {
                    title: "Game of Thrones",
                    href: "/got"
                }
            ],
            userNameInfoPanel: false,
            isRegister: false,
            isLogin:false,
            showReviewInAlerts: false

        }
    },
    computed: {
        getCurrentUser () {
            this.userChecked = this.$store.state.userChecked;
            this.current_user = this.$store.state.currentUserName;
            this.rateUserChecked = this.$store.state.rateCheckedUserGlobal;
            this.userNameInfoPanel = this.$store.state.userNameInfoPanel;
        },
        userRegister () {
            this.isRegister = this.$store.state.userRegister;
            console.log("its userRegister Header"+this.isRegister);
        },
        userLogin () {
            this.isLogin = this.$store.state.userLogin;
            console.log("its userLogin Header"+this.isLogin);
        },
        checkGetCurrentUserAlerts () {
            axios.post('api/checked_current_user_have_alerts', {user_name: this.$store.state.currentUserName}).then((response) => {
            this.showReviewInAlerts = response.data;
       })
        }
    },
    mounted() {
      //this.checkCurrentUserHaveAlerts();
    },
    updated() {
      if (!this.showReviewInAlerts) {
        //this.checkCurrentUserHaveAlerts();
      }
    },
    methods: {
     showHref(showHr) {
        if (showHr == '/the_100') {
          this.$store.state.globalHref = showHr;
          this.$store.state.currentShowId = 1;
          this.$router.push(showHr);
        }
        else if (showHr == '/got') {
          this.$store.state.globalHref = showHr;
          this.$store.state.currentShowId = 2;
          this.$router.push(showHr);
        }
    },
     personalInfoOpen() {
        this.$router.push('/personal_user_page');
    },
     personalAlerts() {
        this.showReviewInAlerts = false;
        this.$store.state.showOrHideUserAlerts = true;
        this.$router.push('/alerts');
    },
     showUserIdUpdate() {
      this.$store.dispatch('showUserIdUpdateAction');
    },
     userExit() {
     this.$store.state.likeCounter= [{
      color:''
     }];
      axios.post('api/refresh_user_click_like', { user_name: this.current_user })
            .then(res => {

            });

      this.$store.state.reviewUserNameTemp = [];
     
      this.showUserIdUpdate();
    {
      this.$store.state.currentUserName = '';
      this.$store.state.userId = 0;
      this.$store.state.userChecked = false;
      this.$store.state.rateCheckedUserGlobal = true;
      this.$store.state.userNameInfoPanel = true;
      this.$store.state.userRegister = false;
      this.$store.state.userLogin = false;
      this.$store.state.mainPageButtonRegister = false;
      this.$store.state.userFavorites = [];
      this.$store.state.currentUserNickNameForProfile = '';

      this.$store.state.clickAddFavorites = true;

      this.$router.push('/');
    }
} 
}
}
</script>

<style>

 .b-navbar .b-nav .b-nav-item{
      color:white;
    }

    .b-navbar .exitButton {
        color: green;

    }

</style>
