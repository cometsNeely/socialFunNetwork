<template>
    <div id="app">
      <section>
        <article>

         <b-list-group v-for="(review, index) in reviews" :key="index" v-b-scrollspy:listgroup-ex style="max-height: 1800px;" horizontal>

            <b-list-group-item v-model="currentIndex=index" id="listgroup-ex" class="d-flex justify-content-between">
            <b-badge variant="primary" pill>{{ review.user_like }} liked your review: </b-badge>
            {{ review.user_author_review }}
             <b-icon icon="exclamation-circle-fill" variant="success" @click="hideCurrentAlert(review.id, index)"></b-icon>
            </b-list-group-item>
      
        </b-list-group>
        </article>

        <article>
        </article>

      </section>
    </div>
</template>



<script>
import Vue from 'vue';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

export default {
    data() {
        return {
        reviews: [],
        currentIndex: null
        }
    },
    computed: {
       
    },
    mounted() {
     if (this.$store.state.showOrHideUserAlerts == true) {
      this.getAllLikes();
     }
    },
    methods: {

      getAllLikes() {
         axios.post('api/likes', { user_name: this.$store.state.currentUserName })
            .then(res => {
                this.reviews = res.data;
                console.log(this.reviews); 
          })


      },
      hideCurrentAlert(reviewId, index) {
         this.reviews.splice(index, 1);
         console.log("delete"+index);
            axios.post('api/hide_this_alert', { review_id: reviewId })
              .then(res => {
          })
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

</style>