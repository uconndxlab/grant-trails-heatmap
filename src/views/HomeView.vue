<template>
  <div class="home">
    <v-container fluid>
      <v-row class="d-block d-md-flex">
        <v-col cols="12" md="3">
          <ExpansionPanelVue />
        </v-col>
        <v-col cols="12" md="9">
          <div id="mapView">
            <!--This is where the mapbox map goes-->
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
// @ is an alias to /src
import ExpansionPanelVue from '@/components/ExpansionPanel.vue';

export default {
  name: "HomeView",
  components: {
    ExpansionPanelVue
  }
};
</script>

<style>
 @import '../assets/index.css';
</style>