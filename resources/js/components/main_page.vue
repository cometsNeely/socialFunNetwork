<template>
    <div id="app">
    <div class="d-flex justify-content-center" v-if="mainPageButtonRegister">
    <b-button class="btn btn-primary btn-lg" style="display: block; width: 200px; margin-top: 100px;" variant="success" v-if="!isRegister" :to="register">Register Now!</b-button>
    </div>
    {{userRegister}}
    {{userLogin}}
    <div v-if="isRegister || isLogin">
       <div class="tags_search">
            <b-form-tags
                input-id="tags-search"
                v-model="tags_search"
                tag-variant="primary"
                tag-pills
                size="lg"
                separator=" "
                placeholder="Please, select the tags..."></b-form-tags>
            <!--<p class="mt-2">Value: {{ tags_search }}</p>-->
       </div>
        <div class="search_button">
            <b-button variant="success" @click="loadInfo">Search!</b-button>
        </div>



        <div class="tags" v-for="tag in tags">
            <b-badge variant="info" @click="addTagsSearch(tag)">{{ tag }}</b-badge>
        </div>

<div v-for="s_id in show_id">
        <div class="cards" v-if="searchOn && show.id==s_id" v-for="show in shows">
            <b-card no-body class="overflow-hidden" style="max-width: 1800px; height: 430px;">
                <b-row no-gutters>
                    <b-col md="6">
                        <b-card-img v-bind:src="show.cover_src" alt="Image" class="rounded-0"></b-card-img>
                    </b-col>
                    <b-col class="body" md="6">
                        <b-card-body title="">
                            <h1>{{ show.title }}</h1>
                            <b-card-text>
                                {{ show.description }}
                            </b-card-text>
                            <b-form-rating class="rate" v-model="avg_rate=show.avg_rate" variant="warning" no-border size="lg" style="width: 30%;" readonly></b-form-rating>
                            <b-button variant="info" @click="showInfo(show.href)">Go to TV-Show</b-button>
                        </b-card-body>
                    </b-col>
                </b-row>
            </b-card>
        </div>
</div>
</div>
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
        tags: [],
        //show_ids: [],
        tags_search: [],
        searchOn: false,
        shows: [],
        avg_rate: null,
        show_id: [],
        isRegister: false,
        isLogin: false,
        register: "/register",
        mainPageButtonRegister: true
    }),
    mounted() {
        this.loadTags();
        },
    computed: {
        userRegister () {
            this.isRegister = this.$store.state.userRegister;
        },
        userLogin () {
            this.isLogin = this.$store.state.userLogin;
            this.mainPageButtonRegister = this.$store.state.mainPageButtonRegister;
        }
    },
    methods: {
    showInfo(showHref) {

     if (showHref == '/the_100') {
          this.$store.state.globalHref = showHref;
          this.$store.state.currentShowId = 1;
          this.$router.push(showHref);
        }
        else if (showHref == '/got') {
          this.$store.state.globalHref = showHref;
          this.$store.state.currentShowId = 2;
          this.$router.push(showHref);
        }

    },
        loadTags: function () {
            axios.get('api/tags')
                .then(res => {
                    this.tags = res.data.tags_name;
                    console.log(this.tags);
                })
        },
        addTagsSearch(tagName) {
            this.tags_search.push(tagName);
        },
        loadInfo() {
        console.log(this.tags_search);

            axios.get('api/shows')
                .then(res => {
                    this.shows = res.data;
                    this.searchOn = true;
                }),
            axios.post('api/tags_search', {tags_search: this.tags_search})
                .then(res => {
                    this.show_id = res.data;
                    console.log(this.show_id);
                })

        }
    }
}
</script>

<style scoped>

.tags {
    margin: 5px;
    display: inline-block;
    padding-bottom: 50px;
}

.cards {
    padding-top: 140px;
    display: inline;
    margin: 10px;
}

.tags_search {
    padding-top: 25px;
    width: 90%;
}

.tags_search, .search_button {
    display: inline-block;
    padding-bottom: 30px;
}



</style>
