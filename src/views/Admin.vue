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
            <li><a href="dashboard">Dashboard</a></li>
            <li class="action"><a href="#logout">Logout</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <section id="register" class="section-bg wow">
      <div class="container">
        <div class="section-header">
          <h2>Create Project</h2>
        </div>
      </div>
    </section>
    <div class="form">
      <div>
        <div class="form-row">
          <div class="form-group col-md-6 col-xs-12">
            <input type="title" class="form-control" name="title" id="title" placeholder="Title" data-rule="title" data-msg="Please enter a title" v-model="logDetails.title"
              label="Title"
              v-on:keyup="keymonitor"
              required />
            <div class="validation"></div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6 col-xs-12">
            <input type="description" class="form-control" name="description" id="description" placeholder="Description" data-rule="description" data-msg="Please enter a description." v-model="logDetails.description"
              label="Description"
              v-on:keyup="keymonitor"
              required />
            <div class="validation"></div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6 col-xs-12">
            <input type="imagelink" class="form-control" name="imagelink" id="imagelink" placeholder="Image Link" data-rule="imagelink" data-msg="Please enter an image link." v-model="logDetails.imagelink"
              label="Image Link"
              v-on:keyup="keymonitor"
              required />
            <div class="validation"></div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6 col-xs-12">
            <input type="pubkey" class="form-control" name="pubkey" id="pubkey" placeholder="Public Key of Project" data-rule="imagelink" data-msg="Please enter an image link." v-model="logDetails.pubkey"
              label="Public Key of Project"
              v-on:keyup="keymonitor"
              required />
            <div class="validation"></div>
          </div>
          <div><button @click="generateKey()" type="submit">Generate Public Key</button></div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6 col-xs-12">
            <input type="number" class="form-control" name="price" id="goal" placeholder="Goal Amount ($)" data-rule="number" data-msg="Please enter a goal amount." v-model="logDetails.goal"
              label="Goal"
              v-on:keyup="keymonitor"
              @keypress="stripTheGarbage($event)" 
              @blur="formatDollars()" 
              required />
            <div class="validation"></div>
          </div>
        </div>
        <div><button @click="submitProj()" type="submit">Add Project</button></div>
      </div>
    </div>
    <div class="section-header">
      <h2>Your Projects</h2>
      <p>Other projects you've uploaded</p>
    </div>
    <v-layout row wrap>
      <v-flex class="project" v-for="value in myProjects" xs12 sm6 md3>
        <router-link :to="{ name: 'details', params: { projectId: value.id}}"><img v-bind:src="value.image" class="img-fluid"></router-link>
        <div class="details">
          <router-link :to="{ name: 'details', params: { projectId: value.id}}"><h3><a href="#project-details">{{ value.title }}</a></h3></router-link>
          <p>{{ value.description }}</p>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script src="axios.js"></script>
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
<script>
  export default {
    data() {
      return {
        logDetails: {
          title: '',
          description: '',
          imagelink: '',
          pubkey: '',
          goal: '',
          email: this.$store.getters.email,
        },
        projects: []
      };
    },
    computed: {
      myProjects() {
       return this.projects.filter(p => p.createdBy== this.$store.getters.email)
      }
    },
    created() {
      this.getJSON();
    },
    methods: {
      getJSON: async function() {
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
            }
          }
        }
      },
      generateKey: function(){
       var result           = '';
       var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
       var charactersLength = characters.length;
       for ( var i = 0; i < 32; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
       }
       result = 'EOS' + result;
       this.logDetails.pubkey = result;
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

      submitProj: async function() {
        const self = this;
        const axios = require('axios')
        console.log(this.$store.getters.email)
        for(var key in this.logDetails)
          console.log(key + " " + this.logDetails.key)
        var logForm = this.toFormData(this.logDetails);
        axios.post('https://www.copiedcode.com/createproject.php', logForm)
          .then(function(response) {
            if (response.data.error != "") {
              console.log(response.data.message);
            } else {
              console.log(response.data.message);
              self.$router.push('dashboard');
            }
          });
      },

      keymonitor: function(event) {
        if (event.key == "Enter") {
          this.submitProj();
        }
      },



      toFormData: function(obj) {
        var form_data = new FormData();
        for (var key in obj) {
          form_data.append(key, obj[key]);
        }
        console.log(obj);
        console.log(form_data)
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
</script>