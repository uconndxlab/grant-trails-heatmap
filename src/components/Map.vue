<template>
    <div id="mapView"></div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import { mapActions, mapGetters } from "vuex";

export default {
    name: "MapVue",
    data() {
        return {
            //accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN
            accessToken: "pk.eyJ1IjoidWNvbm5keGdyb3VwIiwiYSI6ImNrcTg4dWc5NzBkcWYyd283amtpNjFiZXkifQ.iGpZ5PfDWFWWPkuDeGQ3NQ"
        };
    },
    computed: {
        ...mapGetters({
            coordinates: 'coordinates'
        })
    },
    created() {
        this.bootstrap();
    },
    mounted() {
        this.createMap();
    },
    methods: {
        ...mapActions({
            bootstrap: 'bootstrap'
        }),
        async createMap() {
            try {
                mapboxgl.accessToken = this.accessToken;

                this.map = new mapboxgl.Map({
                    container: "mapView",
                    style: "mapbox://styles/mapbox/streets-v11",
                    center: [-72.7, 41.45],
                    zoom: 8.5
                });
            }
            catch (err) {
                console.log("map error", err);
            }

        }
        
    }
}

</script>

<style>
    @import '../assets/index.css';
</style>