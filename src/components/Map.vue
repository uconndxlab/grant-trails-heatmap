<template>
    <div id="mapView"></div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import { mapActions, mapGetters } from "vuex";

var currentMarkers = [];

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
            this.clearMarkers(this.grants)
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
            for (const grant of grantObj) {
                console.log(grant.grants_location);

                const el = document.createElement("div");
                const diam = 20 + 0.8 * Math.pow(grant.total_amount, 1/4);
                el.className = "marker";
                el.style.width = `${diam}px`;
                el.style.height = `${diam}px`;

                this.marker = new mapboxgl.Marker(el)
                    .setLngLat(JSON.parse(grant.grants_location).reverse())
                    .addTo(this.map);
                currentMarkers.push(this.marker);
            }
        },
        async clearMarkers() {
            if (currentMarkers !== null) {
                for (var i = currentMarkers.length - 1; i >= 0; i--) {
                    currentMarkers[i].remove();
                }
            }
        }
    }
}

</script>

<style>
    /*@import '../assets/index.css';*/
    .marker {
        background-color: #0a2a77;
        background-size: 100%;
        display: block;
        border: solid #ffffff;
        border-radius: 50%;
        cursor: pointer;
        padding: 0;
    }
</style>