<template>
  <v-container>
    <v-layout row class="text-xs-center">
      <v-flex xs3 style="background-image: url('http://cdn.wallpapersafari.com/7/86/gqiGH7.jpg')">
        <v-card height="500px"></v-card>
      </v-flex>
      <v-flex xs4 class="grey lighten-4">
        <v-container style="position: relative;top: 13%;" class="text-xs-center">
          <v-card flat>
            <v-card-actions>
                <v-btn @click="openScatter()" primary large block>Open Scatter</v-btn>
            </v-card-actions>
          </v-card>
            <v-card-title primary-title>
              <h4>Login</h4>
            </v-card-title>
            <v-form>
              <v-card-actions>
                <v-btn @click="handleLogin()" primary large block>Login</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-container>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
    window.open('scatter://','_self');
</script>
<script>
import EosService from '@/eosio/EosService';
export default {
  data() {
    return {
      accountName: '',
      logDetails: {pubkey: ''},
      eosio: null
    };
  },
  methods: {
    openScatter: async function(){
      window.open('scatter://','_self');
    },
    handleLogin: async function() {
      const self = this;
      if (this.eosio === null) {
        this.eosio = new EosService(
          process.env.VUE_APP_DAPP_NAME,
          process.env.VUE_APP_SMART_CONTRACT_NAME
        );
      }

      if (!(await this.eosio.connect()))
        return console.log('Failed to get Scatter account');

      if (
        await this.eosio.transaction('login', { user: this.eosio.account.name })
      ) {
        this.logDetails.pubkey=this.eosio.account.publicKey;
        const axios = require('axios')
        var logForm = this.toFormData(this.logDetails);
        axios.post('https://www.copiedcode.com/login.php', logForm)
        .then(function(response){
            if(response.data.error){
              console.log(response.data.message);
            }
            else{
              self.$store.commit('loginStatus', true);
              if(response.data.admin)
                self.$router.push('admin');
              else
                self.$router.push('home');
            }
          });
        }
      },

    keymonitor: function(event) {
          if(event.key == "Enter"){
            this.checkLogin();
          }
        },

 
  
    toFormData: function(obj){
      var form_data = new FormData();
      for(var key in obj){
        form_data.append(key, obj[key]);
      }
      return form_data;
    }
  }
};
</script>
