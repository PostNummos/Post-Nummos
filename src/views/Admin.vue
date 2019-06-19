<template>
  <v-container>
    <header id="header">
      <div class="container">
        <div id="logo" class="pull-left">
          <h1><a href="/"><span>POST</span>NUMMOS</a></h1>
        </div>

        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li class="menu-active"><a href="/">Home</a></li>
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
      <form action="">
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
      </form>
    </div>    
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

jQuery(document).ready(function( $ ) {

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });
  $('.back-to-top').click(function(){
    $('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
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
    $('#intro').css({ height: $(window).height() });
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

          if( ! $('#header').hasClass('header-fixed') ) {
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