<template>
    <div id="app">
<section>
<article>
<h5 style="margin-left:10px;">Your favorite list</h5>
{{ getUserFavoritesList }}

<b-list-group>
  <b-list-group-item class="d-flex justify-content-between align-items-center" v-for="favorite in userFavoritesList">
    {{ favorite }}

     <b-icon icon="x-circle" scale="1" variant="danger" @click="deleteFavorite(favorite)"></b-icon>

  </b-list-group-item>
</b-list-group>

</article>

<article>
<h5 style="margin-left:105px;">Upload Your Avatar Now!</h5>
<div class="avatar">
<b-form-group>
    <b-form-file id="file-large" size="lg" @change="onAvatarChange" ></b-form-file>
</b-form-group>

<img
    :src="userAvatar"
    style="max-width: 100%; width: 300px; object-fit: cover"/>
</div>

</article>
</section>
</div>
</template>



<script>
import Vue from 'vue';
import vueRouter from 'vue-router';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';


Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(vueRouter);
Vue.use(Vuetify);


export default {
    data: () => ({
      	userFavoritesList: [],
        userAvatar: null,
        file: null

    }),
    computed: {
        getUserFavoritesList () {
           this.userFavoritesList = this.$store.state.userFavorites;
           this.userAvatar = this.$store.state.userAvatar;
        }
    },
    mounted() {
      this.getAllUsers();
    },
    updated() {
      this.getAllUsers();
    },
    methods: {
      getAllUsers() {
        axios.post('api/checkedAvatarIsNotNullAndView', {user_name: this.$store.state.currentUserName}).then((response) => {
        for (var res of response.data.avatar) {
          if( res.avatar != "") { console.log(res.avatar); this.userAvatar = res.avatar; }
          else { this.userAvatar = this.$store.state.userAvatar; }
         }
       })
      },
      deleteFavorite(favoriteElement) {
        if (favoriteElement == "The Hundred") {
          this.userFavoritesList.splice(favoriteElement, 1);
          console.log("delete 100");
          this.$store.state.clickAddFavoritesThe100 = true;
        }
        if (favoriteElement == "Game of Thrones") {
          this.userFavoritesList.splice(favoriteElement, 1);
          console.log("delete GOT");
          this.$store.state.clickAddFavoritesGot = true;
        }
        else if (this.userFavoriteList == []) {
          this.$store.state.clickAddFavoritesThe100 = true;
          this.$store.state.clickAddFavoritesGot = true;
        }
    },
      onAvatarChange(payload) { 

      let file = payload.target.files[0]; 

      let form = new FormData();
      form.set('file', file);
      form.set('user_name', this.$store.state.currentUserName);

      for (var value of form.values()) {
        this.formValue = value;
      }

      if (file) {
        this.userAvatar = (window.URL || window.webkitURL).createObjectURL(new Blob([file]));

         axios.post('api/save_or_change_user_avatar', form)
         .then((response) => {
            })
                .catch(function (error) {
                    console.log("error");
                });  

        URL.revokeObjectURL(file); 
        }
      }
  }
}

</script>

<style>

section {
    display: flex;
}

article {
    flex: 1 100px;
}

article .avatar {
  margin-left: 120px;
}

</style>