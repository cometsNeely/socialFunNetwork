<template>
    <div id="app">
    <div class="d-flex justify-content-center">
    <b-form <b-form style="margin-top: 100px;">
      <b-form-group
        id="input-group-1"
        label="Email address:"
        label-for="input-1"
        description="We'll never share your email with anyone else.">

        <b-form-input
          id="input-1"
          v-model="form.email"
          type="email"
          placeholder="Enter email"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group 
      id="input-group-2" 
      label="Your Name:" 
      label-for="input-2">

        <b-form-input
          id="input-2"
          v-model="form.name"
          placeholder="Enter name"
          required
        ></b-form-input>
      </b-form-group>

      <b-button variant="primary" @click="userLogin">Login</b-button>

      <!--<div>{{message}}</div>-->

      <b-alert
      v-model="warningLogin"
      class="position-fixed fixed-bottom m-0 rounded-0"
      style="z-index: 2000;"
      variant="warning"
      dismissible>
      WARNING: Please. try again!
      </b-alert>


      </b-form>
      </div>



    </div>
</template>



<script>
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import vueRouter from 'vue-router';

Vue.use(vueRouter);
Vue.use(BootstrapVue);

export default {
    data() {
      return {
        message: '',
        form: {
          email: '',
          name: ''
        },
        isLoginChecked: false,
        warningLogin: false
      }
    },
    computed: {
        getCurrentUser () {
            this.$store.state.userChecked = true;
            this.$store.state.currentUserName = this.form.name;
        }
    },
    methods: {
      userLogin() {

        axios.post("api/user_login", { email: this.form.email, name: this.form.name}).then((response) => {
                    this.isLoginChecked = response.data.message;
                    this.$store.state.userId = response.data.userId;
                    console.log("isLoginChecked=="+this.isLoginChecked);

                     if(this.isLoginChecked) {
                        this.$store.state.userLogin = true;
                        this.$store.state.mainPageButtonRegister = false;
                        this.getCurrentUser;

                        if (this.$store.state.userAuthor == this.$store.state.currentUserName && this.$store.state.userAuthor != '' && this.$store.state.currentUserName != '') {
                            console.log("Yep");
                            this.$store.state.showOrHideUserAlert = true;
                          }
                        this.$router.push('/');
                    }
                      else {
                          this.warningLogin = true;
                     }    

                })
                .catch(function (error) {
                    console.log("error");
                }); 


      }
  }
}
</script>

<style>

</style>