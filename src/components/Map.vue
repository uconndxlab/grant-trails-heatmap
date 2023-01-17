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
    created() {
        // this.bootstrap();
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

        },
        async addMarkers(grantObj) {
            for (let grant in grantObj) {
                const el = document.createElement("div");
                const diam = 20 + 0.01 * Math.sqrt(grant.total_amount);
                el.className = "marker";
                el.style.width = `${diam}px`;
                el.style.height = `${diam}px`;

                this.marker = new mapboxgl.Marker(el)
                    .setLngLat([JSON.parse(grant.grant_location)])
                    .addTo(this.map);
            }
        }
    }
}

</script>

<style>
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