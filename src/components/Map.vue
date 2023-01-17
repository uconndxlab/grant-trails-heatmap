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
            accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN
        };
    },
    computed: {
        ...mapGetters({
            coordinates: 'coordinates',
            grants: 'grants'
        })
    },
    watch:{
        grants(){
            this.addMarkers(this.grants)
        }
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
            this.addMarkers(this.grants);

        },
        async addMarkers(grantObj) {
            console.log('Adding markers!')
            for (let grant of grantObj) {
                const el = document.createElement("div");
                const diam = 20 + 0.01 * Math.sqrt(grant.total_amount);
                el.className = "marker";
                el.style.width = `${diam}px`;
                el.style.height = `${diam}px`;

                this.marker = new mapboxgl.Marker(el)
                    .setLngLat(JSON.parse(grant.grants_location))
                    .addTo(this.map);
            }
        }
    }
}

</script>

<style>
    @import '../assets/index.css';
</style>