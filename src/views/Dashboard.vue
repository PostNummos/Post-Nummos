<template>
  <v-container>
    <div class="section-header">
      <h2>Projects</h2>
        <p>Here are some of our projects</p>
    </div> 
    <v-layout row wrap>
      <v-flex class="project" v-for="value in projects" xs12 sm6 md3>
        <img v-bind:src="value.image" class="img-fluid">
        <div class="details">
          <h3><a href="#project-details">{{ value.title }}</a></h3>
          <p>{{ value.description }}</p>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import EosService from '@/eosio/EosService';
export default {

  data() {
    return {
      accountName: '',
      logDetails: {pubkey: ''},
      projects:[],
      eosio: null
    };
  },
  methods:{
    
    getJSON: async function(){
      var self= this;
      var xhttp = new XMLHttpRequest();
      var url = 'https://www.copiedcode.com/getprojects.php';
      xhttp.open("GET", url);
      xhttp.send();
      xhttp.onreadystatechange=()=>{
        if(xhttp.readyState == 4 && xhttp.status == 200){
           var projectData = JSON.parse(xhttp.responseText);
          for(var key in projectData){
            let newObj = {
              title: projectData[key].title,
              id: projectData[key].id,
              goal: projectData[key].goal,
              image: projectData[key].image,
              description: projectData[key].description,
              publickey: projectData[key].publickey
            };
            self.projects.push(newObj)
          }
        }
      }
    },
    
    donate: async function() {
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
        //await this.eosio.transaction('transfer', { from: this.eosio.account.name, to: "destinationaccount", quantity: "50.0000 EOS", memo: "Project Name" })
        await this.eosio.transaction2('login', { user: this.eosio.account.name })
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

<style>
#app {
  padding: 60px 0 30px 0;
  background: url("/img/projects-bg.jpg");
  background-size: cover;
  overflow: hidden;
  position: relative;
  color: #fff;
  padding: 60px 0 40px 0;
}

#app:before {
  content: "";
  background: rgba(13, 20, 41, 0.8);
  position: absolute;
  bottom: 0;
  top: 0;
  left: 0;
  right: 0;
}

#app .section-header h2 {
  color: white;
}

.theme--light.application {
  background: none;
}

.project {
  padding: 10px;
}

img {
  padding-bottom: 10px;
}

h3 {
  margin-bottom: 5px;
  font-weight: 500;
}

a {
  color: #e8732f;
}

p {
  color: #9195a2;
}
</style>