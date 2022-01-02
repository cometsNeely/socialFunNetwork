<template>
    <div id="app">
      <section>
        <article>
          <h5 style="margin-left:10px;"> Chat for <h4 style="color: blue;">{{ currentUserNickNameForProfile }}</h4></h5>
            <b-jumbotron class="info" :header="Chat" :lead="Time">
                  <b-form-textarea
                    id="textarea_chat"
                    v-model="chatField"
                    placeholder="Please, write your message to this user..."
                    rows="3"
                    max-rows="6"
                  ></b-form-textarea>
            <b-button class="send_button" @click="sendMessageToThisUserInChat(chatField, currentUserNickNameForProfile)" variant="outline-primary">Send message!</b-button>

        <b-list-group v-for="chatMessage in chatMessages" v-b-scrollspy:listgroup-ex style="max-height: 1800px;" horizontal class="chat_list">
            <b-list-group-item id="listgroup-ex" class="d-flex justify-content-between">
             {{ chatMessage.message }}

            <b-badge variant="primary" pill>{{ chatMessage.user_req }}</b-badge>
            </b-list-group-item>
        </b-list-group>
        </b-jumbotron>
        </article>

        <article>
        </article>
      </section>
    </div>
</template>



<script>
import Vue from 'vue';
import vueRouter from 'vue-router';
import { BootstrapVue } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(vueRouter);

const channel = new BroadcastChannel('app-data');

export default {
    data: () => ({
      currentUserNickNameForProfile: '',
      chatField: '',
      chatMessages: [],
      Chat:"Chat",
      Time:"Time"
    }),
    computed: {
   
    },
    mounted() {
    if(this.$store.state.currentUserNickNameForProfile != '') {
      this.currentUserNickNameForProfile = this.$store.state.currentUserNickNameForProfile;
    }
    this.downloadMessageToChat(this.currentUserNickNameForProfile);
    },
    updated() {

    },
    methods: {
    downloadMessageToChat(currentUser) {
         axios.post('api/download_message_to_chat', {  user_req: this.$store.state.currentUserName, user_resp: currentUser }).then((response) => {
              if(response.data.isHistory == true && response.data.userIsActive == true) {
                this.chatMessages = response.data.chat_history;
                this.chatMessages.reverse();
              } 
              else { 
                return; 
              }

               channel.addEventListener ('message', (event) => {

               console.log(event.data.message+event.data.user_resp);
               if(event.data.user_resp == this.$store.state.currentUserName) {
                  this.chatMessages = event.data.message;
               }

              });
                
                })
                .catch(function (error) {
                    console.log("error");
                }); 
    },
    sendMessageToThisUserInChat(chatMsg, currentUser) {
        axios.post('api/send_message_to_chat', { chatField: chatMsg, user_req: this.$store.state.currentUserName, user_resp: currentUser }).then((response) => {

              this.chatMessages.unshift({message:response.data.message, user_req: this.$store.state.currentUserName});

              channel.postMessage({message: this.chatMessages, user_resp: this.currentUserNickNameForProfile});
      
                })
                .catch(function (error) {
                    console.log("error");
                }); 
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

article .chat_list {
    padding-top: 20px;
    padding-left: 20px;
}

</style>