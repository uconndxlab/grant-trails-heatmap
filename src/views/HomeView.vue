<template>
  <div class="home">
    <HeaderVue />
  </div>
</template>

<script>
// @ is an alias to /src
import HeaderVue from '@/components/Header.vue';

export default {
  name: "HomeView",
  components: {
    HeaderVue
  }
};
</script>

<style>
 @import '../assets/index.css';
</style>