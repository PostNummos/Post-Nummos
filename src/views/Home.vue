<template>
  <v-container>

  <v-card-title primary-title>
    <h4>Non-Admin User Page</h4>
  </v-card-title>
  <v-card flat>
            <v-card-title primary-title>
              <h4>Login</h4>
            </v-card-title>
            <v-form>
              <v-card-actions>
                <v-btn @click="donate()" primary large block>Login</v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
            </v-container>
</template>

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
  methods:{
    /*
    getJSON: async function(){
      var xhttp = new XMLHttpRequest();
      var url = 'https://www.copiedcode.com/getprojects.php';
      xhttp.open("GET", url);
      xhttp.send();
      xhttp.onreadystatechange=(e)=>{
        if(xhttp.readyState == 4 && xhttp.status == 200){
          var projects = JSON.parse(xhttp.responseText);
          for(key in projects){
            //create project
          }
        }
      }
    },
    */
    donate: async function() {
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
        await this.eosio.transferToken('donate')
      ) {
          console.log("success");
        }
      }
  }
};
/*
getProfiles() {
    this.rpc
      .get_table_rows({
        json: true,
        code: "youraccname1", // contract who owns the table
        scope: "youraccname1", // scope of the table
        table: "users", // name of the table as specified by the contract abi
        limit: 100
      })
      .then(result => this.setState({ users: result.rows }));
  }
*/
//}
</script>
