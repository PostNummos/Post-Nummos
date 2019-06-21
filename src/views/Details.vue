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
            <li class="menu-active"><a href="dashboard">Dashboard</a></li>
            <li class="action"><a href="#logout">Logout</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="section-header">
      <h2>{{ projects[projId].title }}</h2>
    </div>
    <v-layout row wrap>
      <v-flex class="project"  xs12 sm6 md3>
        <img v-bind:src="projects[projId].image" class="img-fluid">
        <div class="details">
          <h3>{{ projects[projId].title }}</h3>
          <p>{{ projects[projId].description }}</p>
          <div class="form-group col-md-6 col-xs-12">
            <input type="number" class="form-control" name="price" id="amount" placeholder="Donation Amount ($)" data-rule="number" data-msg="Please enter a donation amount." v-model="logDetails.amount"
              label="Donation Amount"
              v-on:keyup="keymonitor"
              @keypress="stripTheGarbage($event)" 
              @blur="formatDollars()" 
              required />
            <div class="validation"></div>
          </div>
          <div><button @click="donate()" type="submit">Donate</button></div> <!--This currently doesn't do anything, still working on it-->
        </div>
      </v-flex>
    </v-layout>
    <v-layout row wrap>
      <v-flex class="project" v-for="value in projDonations"  :key="value.id" xs12 sm6 md3>
        <div class="details">
          <li><a>{{ value.publickey }} donated {{ value.amount }} on {{ value.timestamp }}</a></li> <!--Sort into table maybe? Not sure best way to display -->
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
  jQuery(document).ready(function($) {

    // Back to top button
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn('slow');
      } else {
        $('.back-to-top').fadeOut('slow');
      }
    });
    $('.back-to-top').click(function() {
      $('html, body').animate({
        scrollTop: 0
      }, 1500, 'easeInOutExpo');
      return false;
    });

    // Header fixed on scroll
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#header').addClass('header-scrolled');
      } else {
        $('#header').removeClass('header-scrolled');
      }
    });

    if ($(window).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    }

    // Real view height for mobile devices
    if (window.matchMedia("(max-width: 767px)").matches) {
      $('#intro').css({
        height: $(window).height()
      });
    }

    // Initiate the wowjs animation library
    new WOW().init();

    // Initialize Venobox
    $('.venobox').venobox({
      bgcolor: '',
      overlayColor: 'rgba(6, 12, 34, 0.85)',
      closeBackground: '',
      closeColor: '#fff'
    });

    // Initiate superfish on nav menu
    $('.nav-menu').superfish({
      animation: {
        opacity: 'show'
      },
      speed: 400
    });

    // Mobile Navigation
    if ($('#nav-menu-container').length) {
      var $mobile_nav = $('#nav-menu-container').clone().prop({
        id: 'mobile-nav'
      });
      $mobile_nav.find('> ul').attr({
        'class': '',
        'id': ''
      });
      $('body').append($mobile_nav);
      $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
      $('body').append('<div id="mobile-body-overly"></div>');
      $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

      $(document).on('click', '.menu-has-children i', function(e) {
        $(this).next().toggleClass('menu-item-active');
        $(this).nextAll('ul').eq(0).slideToggle();
        $(this).toggleClass("fa-chevron-up fa-chevron-down");
      });

      $(document).on('click', '#mobile-nav-toggle', function(e) {
        $('body').toggleClass('mobile-nav-active');
        $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
        $('#mobile-body-overly').toggle();
      });

      $(document).click(function(e) {
        var container = $("#mobile-nav, #mobile-nav-toggle");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          if ($('body').hasClass('mobile-nav-active')) {
            $('body').removeClass('mobile-nav-active');
            $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
            $('#mobile-body-overly').fadeOut();
          }
        }
      });
    } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
      $("#mobile-nav, #mobile-nav-toggle").hide();
    }

    // Smooth scroll for the menu and links with .scrollto classes
    $('.nav-menu a, #mobile-nav a, .scrollto').on('click', function() {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        if (target.length) {
          var top_space = 0;

          if ($('#header').length) {
            top_space = $('#header').outerHeight();

            if (!$('#header').hasClass('header-fixed')) {
              top_space = top_space - 20;
            }
          }

          $('html, body').animate({
            scrollTop: target.offset().top - top_space
          }, 1500, 'easeInOutExpo');

          if ($(this).parents('.nav-menu').length) {
            $('.nav-menu .menu-active').removeClass('menu-active');
            $(this).closest('li').addClass('menu-active');
          }

          if ($('body').hasClass('mobile-nav-active')) {
            $('body').removeClass('mobile-nav-active');
            $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
            $('#mobile-body-overly').fadeOut();
          }
          return false;
        }
      }
    });

  });

  import EosService from '@/eosio/EosService';
  export default {

    data() {
      return {
        accountName: '',
        logDetails: {
          pubkey: '',
          amount: '',
          projId: ''
        },
        projects: [],
        donations:[],
        projId: '',
        eosio: null
      };
    },
    created() {
        var parts = this.$route.path.split('/')
        this.projId = Number(parts[parts.length-1])
        this.logDetails.projId = Number(parts[parts.length-1])
        this.projects = this.$store.getters.projects
        if (this.projects.length == 0) {
          this.getProjects()
        }
        if (this.projects.length == 0 || this.projects[this.projId]== null) {
          self.$router.push('home');
        }
        this.getDonations()
      },
    watch: {
    '$route' (to, from) {
      var parts = this.$route.path.split('/')
        this.projId = parts[parts.length-1]
        this.projects = this.$store.getters.projects
        if (this.projects.length == 0) {
          this.getJSON()
        }
        if (this.projects.length == 0 || this.projects[this.projId]== null) {
          self.$router.push('home');
        }
      }
    },
    updated: function () {
      this.$nextTick(function () {
      var parts = this.$route.path.split('/')
        this.projId = parts[parts.length-1]
        this.projects = this.$store.getters.projects
        if (this.projects.length == 0) {
          this.getJSON()
        }
        if (this.projects.length == 0 || this.projects[this.projId]== null) {
          self.$router.push('home');
        }
      })
    },
    computed: {
      projDonations() {
       return this.donations.filter(d => d.projId== this.projId)
      }
    },
    methods: {
      getProjects: async function() {
        var self = this;
        var xhttp = new XMLHttpRequest();
        var url = 'https://www.copiedcode.com/getprojects.php';
        xhttp.open("GET", url);
        xhttp.send();
        xhttp.onreadystatechange = () => {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            var projectData = JSON.parse(xhttp.responseText);
            for (var key in projectData) {
              let newObj = {
                title: projectData[key].title,
                id: projectData[key].id,
                goal: projectData[key].goal,
                image: projectData[key].image,
                description: projectData[key].description,
                publickey: projectData[key].publickey
              };
              self.projects.push(newObj)
              self.$store.commit('addProject', newObj);
            }
          }
        }
      },
      getDonations: async function() {
        var self = this;
        var xhttp = new XMLHttpRequest();
        var url = 'https://www.copiedcode.com/getdonations.php';
        xhttp.open("GET", url);
        xhttp.send();
        xhttp.onreadystatechange = () => {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            var donationData = JSON.parse(xhttp.responseText);
            for (var key in donationData) {
              let newObj = {
                timestamp: donationData[key].timestamp,
                id: donationData[key].id,
                amount: donationData[key].amount,
                name: donationData[key].name,
                projId: donationData[key].projId,
                publickey: donationData[key].publickey
              };
              self.donations.push(newObj)
            }
          }
        }
      },

      keymonitor: function(event) {
        if (event.key == "Enter") {
          this.handleLogin();
        }
      },
      toFormData: function(obj) {
        var form_data = new FormData();
        for (var key in obj) {
          form_data.append(key, obj[key]);
        }
        console.log(obj);
        return form_data;
      },
      stripTheGarbage: function(e) {
        if (e.keyCode < 48 && e.keyCode !== 46 || e.keyCode > 59) {
          e.preventDefault()
        }
      },
      formatDollars: function() {
        if (this.price != '') {
          var num = this.price;

          num = Number(num);

          var countDecimals = function(value) {
            if (Math.floor(value) === value) return 0;
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

        if (await this.eosio.transaction('login', {
            user: this.eosio.account.name
          })
          ){
          this.logDetails.pubkey = this.eosio.account.publicKey;
          const axios = require('axios')
          var logForm = this.toFormData(this.logDetails);
          axios.post('https://www.copiedcode.com/createdonation.php', logForm)
            .then(function(response) {
              if (response.data.error != "") {
                console.log(response.data.message);
              } else {
                console.log(response.data.message);
                self.getDonations()
              }
          });
        }
      }
        //donate: async function(){
          //Below is for when we get on the EOS mainnet

        /*if (this.eosio === null) {
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
          await this.eosio.transaction2('login', {
            user: this.eosio.account.name
          })
        ) {
          console.log("success");
        }*/
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