<template>
  <v-container>
    <header id="header">
      <div class="container">
        <div id="logo" class="pull-left">
          <h1><a href="/"><span>POST</span>NUMMOS</a></h1>
        </div>

        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li><a href="/">Home</a></li>
            <li class="menu-active"><a href="login">Sign In</a></li>
            <li class="action"><a href="signup">Create Profile</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section id="register" class="section-bg wow">
      <div class="container">
        <div class="section-header">
          <h2>Sign In</h2>
        </div>
        <div class="text-center"><button @click="handleLogin()" type="submit">Login</button></div>
      </div>
    </section>
  </v-container>
</template>

<style>
  #app h2 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #fff;
    }

    #app h3 {
      font-size: 18px;
      font-weight: bold;
      text-transform: uppercase;
      margin-bottom: 10px;
      color: #fff;
    }

    #app p, label {
      font-size: 14px;
      margin-bottom: 20px;
      color: #fff;
    }

    #app button[type="submit"] {
      background: #e8732f;
      border: 0;
      padding: 10px 40px;
      color: #fff;
      transition: 0.4s;
      cursor: pointer;
    }

    div.application--wrap {
      min-height: 0;
    }
  </style>


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
