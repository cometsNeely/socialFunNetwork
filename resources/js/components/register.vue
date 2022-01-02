<template>
    <div id="app">
    <div class="d-flex justify-content-center">
    <b-form style="margin-top: 100px;">
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

      <b-form-group 
      id="input-group-2" 
      label="Your Password:" 
      label-for="input-3">

        <b-form-input
          id="input-3"
          v-model="form.password"
          type="password"
          placeholder="Enter password"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group 
      id="input-group-2" 
      label="Confirm Your Password:" 
      label-for="input-4">

        <b-form-input
          id="input-4"
          v-model="form.confirm_password"
          type="password"
          placeholder="Enter password"
          required
        ></b-form-input>
      </b-form-group>


      <b-button variant="primary" @click="confirmPassword">Register</b-button>

      <b-alert
      v-model="confirm_password_warning"
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

Vue.use(BootstrapVue);
Vue.use(vueRouter);

//Vue.prototype.$eventBus = new Vue();

export default {

    data() {
      return {
        form: {
          email: '',
          name: '',
          password: '',
          confirm_password: ''
        },
        confirm_password_warning: false,
        current_user: 'user',
        userId: null
      }
    },
    computed: {
        getCurrentUser () {

            this.$store.state.userChecked = true;
            this.$store.state.currentUserName = this.form.name;

        }
    },
    methods: {
    userIdIncrement() {
      this.$store.dispatch('userIdIncrementAction');
    },
     register() {
            axios.post('api/register', {name: this.form.name, email: this.form.email, password: this.form.password}).then((response) => {
                
                })
                .catch(function (error) {
                    console.log("error");
                })

          this.getCurrentUser;
          this.userIdIncrement();
          this.$store.state.userRegister = true;


          //this.$eventBus.$emit('currentUserIdIncrementChangeEvent', { userId: this.userChecked });
                
    },
      confirmPassword() {
        if (this.form.password == this.form.confirm_password) {
          this.register();
          this.$router.push('/');
        }
        else {
          this.confirm_password_warning = true;
        }
      }
    }

}
</script>

<style>

</style>