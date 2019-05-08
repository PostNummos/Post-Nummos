<template>
  <v-container>
    <v-layout row class="text-xs-center">
      <v-flex xs3 style="background-image: url('http://cdn.wallpapersafari.com/7/86/gqiGH7.jpg')">
        <v-card height="500px"></v-card>
      </v-flex>
      <v-flex xs4 class="grey lighten-4">
        <v-container style="position: relative;top: 13%;" class="text-xs-center">
          <v-card flat>
            <v-card-title primary-title>
              <h4>Signup</h4>
            </v-card-title>
            <v-form>
              <v-container>
                <v-layout>
                  <v-flex
                    xs12
                    md4
                  >
                    <v-text-field
                      v-model="logDetails.email"
                      label="E-mail"
                      v-on:keyup="keymonitor"
                      required
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
              <v-card-actions>
                <v-btn @click="handleLogin()" primary large block>Signup</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-container>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script src="axios.js"></script>
<script>
import EosService from '@/eosio/EosService';

export default {
  data() {
    return {
      accountName: '',
      logDetails: {email: '', pubkey: ''},
      eosio: null
    };
  },
  methods: {
    handleLogin: async function() {
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
        this.checkLogin();
      }
    },

    keymonitor: function(event) {
          if(event.key == "Enter"){
            this.checkLogin();
          }
        },

 
    checkLogin: function(){
      const axios = require('axios')
      var logForm = this.toFormData(this.logDetails);
      axios.post('https://www.copiedcode.com/signup.php', logForm)
        .then(function(response){
            setTimeout(function(){
              this.$store.commit('loginStatus', true);
              //this.$router.push('home');
            },2000);
        });
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
