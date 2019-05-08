<script src="axios.js"></script>
<script>
import EosService from '@/eosio/EosService';

export default {
  data() {
    return {
      accountName: '',
      successMessage: "",
      errorMessage: "",
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
