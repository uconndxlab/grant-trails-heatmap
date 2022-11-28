<template>
  <div id="homeView" align-content="left">
    <v-container fluid>
      <v-row class="d-block d-md-flex">
        <v-col cols="12" md="3">
          <ExpansionPanelVue />
        </v-col>
        <v-col cols="12" md="9">
            <!--This is where the mapbox map goes-->
            <MapVue />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
// @ is an alias to /src
import ExpansionPanelVue from '@/components/ExpansionPanel.vue';
import MapVue from '@/components/Map.vue';

export default {
  name: "HomeView",
  components: {
    ExpansionPanelVue,
    MapVue
  }
};
</script>

<style>
 @import '../assets/index.css';
</style>