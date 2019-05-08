<template>
  <v-container>
    <span v-html="rawHTML"></span>
  </v-container>
</template>
<script src="axios.js"></script>
<script>
export default {
  data() {
    return {
      // Just like JSX! Oh wait...
      rawHTML: `
        <div id="login">
      <div class="col-md-4 col-md-offset-4">
   
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="glyphicon glyphicon-lock"></span> Sign in</div>
            <div class="panel-body">
              <label>Email:</label>
              <input type="text" class="form-control" v-model="logDetails.email" v-on:keyup="keymonitor">
            </div>
            <div class="panel-footer">
              <button class="btn btn-primary btn-block" @click="handleLogin();"><span class="glyphicon glyphicon-log-in"></span> Login</button>
            </div>
        </div>
   
        <div class="alert alert-danger text-center" v-if="errorMessage">
          <button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
        </div>
   
        <div class="alert alert-success text-center" v-if="successMessage">
          <button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
        </div>
   
      </div>
    </div>
      `
    }
  }
}
</script>
<script>
import EosService from '@/eosio/EosService';

export default {
  data() {
    return {
      accountName: '',
      successMessage: '',
      errorMessage: '',
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
      var logForm = this.toFormData(this.logDetails);
      axios.post('/php/signup.php', logForm)
        .then(function(response){
 
          if(response.data.error){
            this.errorMessage = response.data.message;
          }
          else{
            this.successMessage = response.data.message;
            this.logDetails = {email: '', pubkey:''};
            setTimeout(function(){
              this.$store.commit('loginStatus', true);
              this.$router.push('home');
            },2000);
 
          }
        });
    },
  
    toFormData: function(obj){
      var form_data = new FormData();
      for(var key in obj){
        form_data.append(key, obj[key]);
      }
      return form_data;
    },
 
    clearMessage: function(){
      this.errorMessage = '';
      this.successMessage = '';
    }
  }
};
</script>
