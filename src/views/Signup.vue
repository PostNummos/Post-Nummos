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
            <li><a href="login">Sign In</a></li>
            <li class="action"><a href="signup">Create Profile</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <section id="register" class="section-bg wow">
      <div class="container">
        <div class="section-header">
          <h2>Register</h2>
        </div>
        <div class="form">
          <form action="">
            <div class="form-row">
              <div class="form-group col-md-6 col-xs-12">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Please enter a valid email" v-model="logDetails.email"
                  label="E-mail"
                  v-on:keyup="keymonitor"
                  required />
                <div class="validation"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 col-xs-6">
                <input type="radio" v-model="logDetails.status" value="0">
                <label for="one">Individual</label>
              </div>
              <div class="form-group col-md-3 col-xs-6">
                <input type="radio" v-model="logDetails.status" value="1">
                <label for="two">Organization</label>
              </div>
            </div>
            <div><button @click="handleLogin()" type="submit">Register</button></div>
          </form>
        </div>
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

  #app.form p,
  label {
    font-size: 14px;
    margin: 20px;
    color: #fff;
  }

  #app .form button[type="submit"] {
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

<script src="axios.js"></script>

<script>
  window.open('scatter://', '_self');
  import EosService from '@/eosio/EosService';

  export default {
    data() {
      return {
        accountName: '',
        logDetails: {
          email: '',
          pubkey: '',
          status: ''
        },
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
          await this.eosio.transaction('login', {
            user: this.eosio.account.name
          })
        ) {
          this.logDetails.pubkey = this.eosio.account.publicKey;
          const axios = require('axios')
          var logForm = this.toFormData(this.logDetails);
          axios.post('https://www.copiedcode.com/signup.php', logForm)
            .then(function(response) {
              if (response.data.error != "") {
                console.log(response.data.message);
              } else {
                console.log(response.data.message);
                self.$store.commit('loginStatus', true);
                self.$router.push('home');
              }
            });
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
      }

    }
  };


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