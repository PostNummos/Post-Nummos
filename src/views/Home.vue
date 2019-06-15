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
            <li><a href="login">Sign In</a></li>
            <li class="action"><a href="signup">Create Profile</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <v-layout row wrap>
      <v-flex class="about" lg6>
        <h2>Who We Are</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet auctor tellus. Donec pharetra
            mollis orci eu gravida. Aliquam gravida in dui quis iaculis. Sed quis blandit arcu. Donec risus velit, 
            ullamcorper vel tincidunt at, ornare at leo. Cras pretium dictum vehicula. Vivamus sit amet leo euismod, 
            pharetra est eget, aliquet nulla.
        </p>
        <p>Nullam mollis, urna eget pharetra ornare, elit dui luctus neque, non finibus mi elit vitae risus. Ut at 
          lacus odio. Suspendisse volutpat porta nisi, non tristique velit dapibus sit amet. Sed vitae efficitur 
          urna, sed semper felis. Fusce bibendum leo dui, id facilisis tellus tincidunt quis. Duis in ullamcorper 
          nibh, ut cursus velit. Etiam venenatis felis non dolor faucibus finibus. Morbi maximus velit sit amet justo 
          convallis feugiat. Nullam id imperdiet justo. Nullam luctus tortor nec eros consectetur finibus. Cras 
          consectetur felis ut ipsum scelerisque, ut luctus felis rutrum. Pellentesque habitant morbi tristique senectus 
          et netus et malesuada fames ac turpis egestas. Sed eu massa a sem molestie auctor euismod sit amet massa. 
          Ut id quam in ante laoreet congue aliquam nec eros. Aenean ut ex a ipsum facilisis hendrerit quis pharetra 
          neque.
        </p>
      </v-flex>
      <v-flex class="about" lg6>
        <h2>About Post Nummos</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sit amet auctor tellus. Donec pharetra
           mollis orci eu gravida. Aliquam gravida in dui quis iaculis. Sed quis blandit arcu. Donec risus velit, 
           ullamcorper vel tincidunt at, ornare at leo. Cras pretium dictum vehicula. Vivamus sit amet leo euismod, 
           pharetra est eget, aliquet nulla.
        </p>
        <p>Nullam mollis, urna eget pharetra ornare, elit dui luctus neque, non finibus mi elit vitae risus. Ut at 
              lacus odio. Suspendisse volutpat porta nisi, non tristique velit dapibus sit amet. Sed vitae efficitur 
              urna, sed semper felis. Fusce bibendum leo dui, id facilisis tellus tincidunt quis. Duis in ullamcorper 
              nibh, ut cursus velit. Etiam venenatis felis non dolor faucibus finibus. Morbi maximus velit sit amet justo 
              convallis feugiat. Nullam id imperdiet justo. Nullam luctus tortor nec eros consectetur finibus. Cras 
              consectetur felis ut ipsum scelerisque, ut luctus felis rutrum. Pellentesque habitant morbi tristique senectus 
              et netus et malesuada fames ac turpis egestas. Sed eu massa a sem molestie auctor euismod sit amet massa. 
              Ut id quam in ante laoreet congue aliquam nec eros. Aenean ut ex a ipsum facilisis hendrerit quis pharetra 
              neque.
        </p>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
</script>

<style>
#app {
  background: url("/img/about-bg.jpg");
  background-size: cover;
  overflow: hidden;
  position: relative;
  color: #fff;
  padding: 60px 0 40px 0;
}

div.application--wrap {
  min-height: 0;
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

#app p {
  font-size: 14px;
  margin-bottom: 20px;
  color: #fff;
}

.about {
  padding: 25px;
}
</style>

<script>
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