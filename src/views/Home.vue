<template>
  <v-container>
    <v-card-title primary-title>
      <h4>Non-Admin User Page</h4>
    </v-card-title>
    <v-card flat>
      <v-card-title primary-title>
        <h4>Donate</h4>
      </v-card-title>
      <ul id="v-for-object" class="demo">
        <li v-for="value in projects">
          <img src ={{value.image}}>
          {{ value.title }}
          {{ value.description}}
          EOS Public Key: {{value.key}}
        </li>
      </ul>
      <v-form>
        <v-card-actions>
          <v-btn @click="donate()" primary large block>Donate</v-btn>
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
      projects:{},
      eosio: null
    };
  },
  methods:{
    
    getJSON: async function(){
      console.log("in")
      var xhttp = new XMLHttpRequest();
      var url = 'https://www.copiedcode.com/getprojects.php';
      xhttp.open("GET", url);
      xhttp.send();
      xhttp.onreadystatechange=(e)=>{
        if(xhttp.readyState == 4 && xhttp.status == 200){
           var projectData = JSON.parse(xhttp.responseText);
           console.log(projectData);
          for(var key in projectData){
            console.log("before: " + this.projects);
            this.projects = Object.assign({}, this.projects, {
              title: this.projects[key].title,
              id: this.projects[key].id,
              goal: this.projects[key].goal,
              image: this.projects[key].image,
              description: this.projects[key].description,
              publickey: this.projects[key].publickey
            })
            console.log("after: " + this.projects);
          }
        }
      }
    },
    
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
        //to, from, memo, quantity. see: https://eosio.stackexchange.com/questions/3587/how-to-transfer-eos-token-using-scatter-js-or-eos-js
        await this.eosio.transaction('transfer', { from: this.eosio.account.name, to: "destinationaccount", quantity: : "50.0000 EOS", memo: "Project Name" })
      ) {
          console.log("success");
        }
      }
  },
  created() {
    this.getJSON();
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
