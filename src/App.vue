<template>
  <v-app id="app">
    <header-vue />
    <div id="main">
      <router-view />
    </div>
    <footer-vue id="footer"/>
  </v-app>
</template>

<script>
import HeaderVue from './components/Header.vue';
import FooterVue from './components/Footer.vue';

export default {
  components: {
    HeaderVue,
    FooterVue
  }
}

</script>

<style>
 @import '@/assets/index.css';
</style>
