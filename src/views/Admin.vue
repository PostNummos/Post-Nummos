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
              <h4>Create Project</h4>
            </v-card-title>
            <v-form>
              <v-container>
                <v-layout>
                  <v-flex
                    xs12
                    md4
                  >
                    <v-text-field
                      v-model="logDetails.title"
                      label="Title"
                      v-on:keyup="keymonitor"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="logDetails.description"
                      label="Description"
                      v-on:keyup="keymonitor"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="logDetails.imagelink"
                      label="Image Link"
                      v-on:keyup="keymonitor"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="logDetails.pubkey"
                      label="Public Key of Project"
                      v-on:keyup="keymonitor"
                      required
                    ></v-text-field>
                    <div class="currency-input">
                      <form action="" novalidate>
                        <input type="number" name="price" lable="Goal" v-model="logDetails.goal" @keypress="stripTheGarbage($event)" @blur="formatDollars()" required/>
                        <span class="currency-symbol">$</span>
                      </form>
                    </div>
                  </v-flex>
                </v-layout>
              </v-container>
              <v-card-actions>
                <v-btn @click="submitProj()" primary large block>Add Project</v-btn>
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
export default {
  data() {
    return {
      logDetails: {title: '', description: '', imagelink: '', pubkey: '', goal: ''}
    };
  },
  methods: {
    stripTheGarbage: function(e) {
      if (e.keyCode < 48 && e.keyCode !== 46 || e.keyCode > 59) {
        e.preventDefault()
      }
    },
    formatDollars: function() {
      if (this.price != '') {
        var num = this.price;
        
        num = Number(num);
                
        var countDecimals = function (value) {
          if(Math.floor(value) === value) return 0;
        }
        
        var decimal = countDecimals(num);
        
        if (decimal < 2) {
          num = num.toFixed(2)
        }
        
        if (decimal > 2) {
          num = num.toFixed(decimal)
        }
        
        if (parseInt(num) < 1) {
          num = "." + String(num).split(".")[1];
        }

        this.price = num;
      }
    },

    submitProj: async function() {
      const self = this;
      const axios = require('axios')
      var logForm = this.toFormData(this.logDetails);
      axios.post('https://www.copiedcode.com/createproject.php', logForm)
        .then(function(response){
            if(response.data.error!=""){
              console.log(response.data.message);
            }
            else{
              console.log(response.data.message);
              self.$router.push('home');
            }
        });
      },

    keymonitor: function(event) {
          if(event.key == "Enter"){
            this.handleLogin();
          }
        },

 
  
    toFormData: function(obj){
      var form_data = new FormData();
      for(var key in obj){
        form_data.append(key, obj[key]);
      }
      console.log(obj);
      return form_data;
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
</script>
