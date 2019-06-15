<template>
  <v-container>
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