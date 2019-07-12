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
            <li><a href="/dashboard">Dashboard</a></li>
            <li class="action"><a href="#logout">Logout</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="section-header">
      <h2>Profile</h2>
    </div>
    <v-layout row wrap>
      <v-flex class="project" xs12 sm12 md9>
        <div v-if="myDonations.length > 0">
          <div class="row schedule-item">
            <div id="project_name" class="col-md-2"><h3>Project</h3></div>
            <div id="donation_amount" class="col-md-2"><h3>Amount</h3></div>
            <div id="donation_date" class="col-md-2"><h3>Date</h3></div>
          </div>
          <div class="row schedule-item" v-for="value in myDonations"  :key="value.id">
            <div class="col-md-2"><p>{{ projects[value.projId].title }}</p></div>
            <div class="col-md-2">${{ value.amount }}</div>
            <div class="col-md-2">{{ value.timestamp }}</div>
          </div>
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

  img {
    margin-bottom: 20px;
  }

  .form-group {
    padding: 0;
  }

  .left-sidebar-scrolled {
    position: fixed;
    top: 290px;
  }
  @media only screen and (max-width: 959px) {
    #back-nav {
      margin-bottom: 15px;
    }
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

    // Donate left side-bar fixed on scroll
    $(window).scroll(function() {
      if ($(this).scrollTop() > 720 && $(this).innerWidth() >= 960) {
        $('#left-sidebar').addClass('left-sidebar-scrolled');
      } else {
        $('#left-sidebar').removeClass('left-sidebar-scrolled');
      }
    });

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
        },
        projects: [],
        donations:[],
        eosio: null
      };
    },
    created() {
        console.log(this.$route.query)
      console.log(this.$route.path)
        var parts = this.$route.path.split('/')
        this.logDetails.pubKey = this.$store.getters.pubKey
        if(this.logDetails.pubKey == '')
          this.logDetails.pubKey = 'EOS8mbav3V438XowNbwKGjwC7M9qFhMX49GXBYhAkjKFqERmv6dRn'
        this.projects = this.$store.getters.projects
        if (this.projects.length == 0) {
          this.getProjects()
        }
        //if (this.projects.length == 0 || this.projects[this.projId]== null) {
         // this.$router.push('home');
       // }
        this.getDonations()
      },
    computed: {
      myDonations() {
       return this.donations.filter(d => d.publickey == this.logDetails.pubKey)
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
            this.donations = []
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
          this.donate();
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
      }
    }
  };
</script>