<template>
    <div id="app">
<section>
{{ getCurrentUser }}
    <article>
        <b-jumbotron class="info" v-for="show in shows" v-if="currentShowId==show.id" :header="show.title" :lead="show.status">
            <p>{{ show.description }}</p>
        </b-jumbotron>

        <div class="stars" v-for="show in shows" v-if="currentShowId==show.id">
            <b-form-rating class="rate" variant="warning" no-border size="lg" v-model="rate" v-if="rate==null && show.rateChecked!=rateCheckedUserGlobal"></b-form-rating>
            <b-form-rating class="rate" variant="warning" no-border size="lg" v-model="avg_rate=show.avg_rate" readonly v-else="rate"></b-form-rating>
        </div>

        <b-button class="add" variant="success" v-if="clickAddFavorites" @click="addFavorites(currentShowId)">Add to favorites</b-button>
        <b-button class="add" variant="info" v-else="!clickAddFavorites" disabled>Added to favorites</b-button>


        <h5>Reviews</h5>
        <div class="textarea_review">
            <b-form-textarea
                id="textarea"
                v-model="text_review"
                placeholder="Please, write your review..."
                rows="3"
                max-rows="6"
            ></b-form-textarea>
            <div></div>
            <b-button @click="postReview" class="send_button" variant="outline-primary">Send!</b-button>
        </div>


        <b-list-group v-b-scrollspy:listgroup-ex style="max-height: 1800px;" class="reviews_list" horizontal>
        <div v-for="(review, index) in reviews" :key="index">
            <b-list-group-item id="listgroup-ex" class="d-flex justify-content-between">
            {{ review.user_review }}
            <b-badge variant="primary" pill @click="openUserProfile(review.user_name)">{{ review.user_name }}</b-badge>
            </b-list-group-item>

            <div v-for="(like, likeIndex) in likeCounter" :key="likeIndex" v-model="like.counter" v-if="likeIndex == index">
            <b-icon-heart-fill :color="like.color" v-if="likeIndex == index" @click="likeThisMessage(likeIndex, review.user_review, review.user_name)"></b-icon-heart-fill> 
            {{ like.counter }}</div>
            <b-icon-hand-thumbs-down></b-icon-hand-thumbs-down>

       </div>
        </b-list-group>

    </article>
    <article>
            <b-carousel class="carousel" fade indicators :interval="4000">
            <div v-if="currentShowId==1">
                <b-carousel-slide img-src="/images/sotnya-foto-1.jpg"></b-carousel-slide>
                <b-carousel-slide img-src="/images/sotnya-foto-2.jpg"></b-carousel-slide>
                <b-carousel-slide img-src="/images/sotnya-foto-3.jpg"></b-carousel-slide>
            </div>
            <div v-else-if="currentShowId==2">
                <b-carousel-slide img-src="/images/got-foto-1.jpg"></b-carousel-slide>
                <b-carousel-slide img-src="/images/got-foto-2.jpg"></b-carousel-slide>
                <b-carousel-slide img-src="/images/got-foto-3.jpg"></b-carousel-slide>
            </div>
            </b-carousel>
        <div class="tags" v-for="tag in tags" v-if="currentShowId==tag.show_id">
            <b-badge variant="info" >{{ tag.tag_name }}</b-badge>
        </div>

    </article>
</section>
    </div>
</template>


<script>
import axios from 'axios';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import vueRouter from 'vue-router';

Vue.use(vueRouter);
Vue.use(BootstrapVue);

export default {
    data: () => ({
        shows: [],
        tags: [],
        tags_search: ["ddd"],
        reviews: [],
        text_review: '',
        user_name: '',
        user_id: null,
        rate: null,
        title: '',
        description: 'description',
        status: 'end',
        message: null,
        avg_rate: null,
        switchRate: false,
        rateCheckedUserGlobal: false,
        clickAddFavorites: true,
        clickThisMessage: false,
        currIndex: null,
        currUpdIndex: null,
        likeCounter: [],
        heartIsFill: false,
        isClick: false,
        //currentShow: '',
        currentShowId: null
    }),
    computed: {
        getCurrentUser () {
            this.user_name = this.$store.state.currentUserName;
            this.user_id = this.$store.state.userId;
            this.rateCheckedUserGlobal = this.$store.state.rateCheckedUserGlobal;
            this.likeCounter = this.$store.state.likeCounter;
            this.currentShowId = this.$store.state.currentShowId;
            this.loadReviews(this.currentShowId);

        }
    },
    mounted() {
        this.loadInfo();
        this.loadTags(); 
    },
    updated: function () {
        if (this.rate != null && !this.switchRate) {
            this.postInfo();
        }
    },
    methods: {
        getCurrentUserName(data) {
            this.user_name = data.current_name;
        },
        async loadInfo() {
            axios.get('api/shows')
            .then(res => {
                this.shows = res.data;
                console.log(this.shows);
            })
        },
        async postInfo() {
            axios.post('api/post', {id: this.currentShowId, user_id: this.user_id, title: this.title, description: this.description, rate: this.rate, avg_rate: 0.4, href: '/', cover_src: '/', status: this.status, rateChecked: 1}).then((response) => {
                this.shows.forEach(function (show) {
                    if (show.id == 1) {
                        show.avg_rate = response.data.avg_rate;
                    }
                });
                })
                .catch(function (error) {
                    console.log("error");
                }); 
                this.switchRate = true;
        },
        async loadReviews(showId) {
        console.log(this.currentShowId+"shi");
            axios.post('api/reviews', { show_id: showId, user_name: this.user_name })
            .then(res => {

                this.reviews = res.data.reviews;
                this.reviews.reverse();
                console.log(this.reviews);

                if(this.likeCounter.length == 0) {
                for(let i=0;i<=this.reviews.length-1;i++) {
                console.log(this.reviews[i].isClick);
                  if(this.reviews[i].isClick==true) {
                    this.likeCounter.push(
                    {
                        counter: this.reviews[i].currentCounter,
                        currentUserClickLike: this.reviews[i].isClick,
                        color: 'red'
                    });
                  }
                 else if(this.reviews[i].isClick == false) {
                    this.likeCounter.push(
                    {
                        counter: this.reviews[i].currentCounter,
                        currentUserClickLike: false,
                        color: ''
                    });
                 }
              }    
            }
         })
        },
        async loadLikesForThisUser() {

            axios.post('api/load_likes_for_this_user', { user_name: this.user_name }).then((response) => {

            });
        },
        async postReview() {
            axios.post('api/postreview', {user_id: this.user_id, show_id: this.currentShowId, user_name: this.user_name, user_review: this.text_review}).then((response) => {
                this.reviews.push(response.data);
                this.reviews.reverse();
            })
                .catch(function (error) {
                    console.log("error");
                });
        },
        async loadTags() {
            axios.get('api/tags')
                .then(res => {
                    this.tags = res.data.tags_name_show_ids;
                    console.log(this.tags);
                })
        },
        addCurrentUserFavorites() {
            this.$store.dispatch('addUserFavoritesAction', this.title);
        },
        addFavorites(showId) {

            if(showId == 1) {

                this.title = "The Hundred";
                this.clickAddFavorites = false;
            }
            else if(showId == 2) {

                this.title = "Game of Thrones";
                this.clickAddFavorites = false;
            }

            this.addCurrentUserFavorites();
        },
        likeThisMessage(ind, reviewText, reviewUserName) {

    
            if (this.$store.state.reviewUserNameTemp.includes(reviewUserName) && this.$store.state.reviewUserTextTemp.includes(reviewText)) {
                return;
            }

            if (reviewUserName == this.user_name) {
                return;
            }

            this.likeCounter.forEach(function (likeCounter, index) {
                    if (index == ind) {
                        if (likeCounter.currentUserClickLike == false) {
                            likeCounter.counter += 1;
                            axios.post('api/reviews_update_like_counter', {likeCounter: likeCounter.counter, review: reviewText}).then((response) => {});
                            likeCounter.currentUserClickLike = true;
                            likeCounter.color = "red";
                       }
                      }
            });  

              axios.post('api/user_like_this_review', {user_like: this.user_name, user_author: reviewUserName, user_author_review: reviewText, showOrHideUserAlert: true}).then((response) => {

              this.$store.state.reviewUserNameTemp.push(reviewUserName);  
              this.$store.state.reviewUserTextTemp.push(reviewText);  
              console.log(this.$store.state.reviewUserNameTemp);
              console.log(this.$store.state.reviewUserTextTemp);

              if (response.data.resp == true) {
                return;
              }

            })
                .catch(function (error) {
                    console.log("error");
            }); 

        },
        openUserProfile(userNickName) {

            this.$store.state.currentUserNickNameForProfile = userNickName;
            this.$router.push('/user_profile');
        }
    }
}
</script>

<style>

.carousel  {
    top: 15px;
    left: 35px;
}

article .info .message_alert {
    font-size: 7px;
    font-style: italic;
}

article .stars .rate {
    width: 30%;
    height: 20%;
    float: left;
}

section {
    display: flex;
}

article {
    flex: 1 100px;
}

article .line {
    padding-top: 40px;
    padding-left: 20px;
}

article .textarea_review {
    padding-top: 10px;
    width: 70%;
    padding-left: 20px;
}

article h5 {
    padding-top: 30px;
    padding-left: 20px;
}

article p {
    padding-right: 30px;
}

article .reviews_list {
    padding-top: 20px;
    padding-left: 20px;
}

article .tags {
    display: inline-block;
    padding-top: 70px;
    padding-left: 30px;
    cursor: pointer;
}

article .add {
    padding-top: 15px;
    padding-bottom: 15px;
    padding-left: 15px;
    padding-right: 15px;
}

article .info {
    padding-left: 20px;
}


</style>
