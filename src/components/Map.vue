<template>
    <div id="map-container" class="heatmap"></div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import supabase from "../supabase"

export default {
    name: "MapVue",
    data() {
        return {
            accessToken: process.env.MAPBOX_ACCESS_TOKEN
        };
    },
    mounted() {
        this.createMap();
    },
    methods: {
        async createMap() {
            try {
                mapboxgl.accessToken = this.accessToken;

                this.map = new mapboxgl.Map({
                    container: "map-container",
                    style: "mapbox://styles/mapbox/streets-v11",
                    center: [-72.7, 41.45],
                    zoom: 8.5
                });

                let geocoder = new MapboxGeocoder({
                    accessToken: this.accessToken,
                    mapboxgl: mapboxgl,
                    marker: false
                });

                this.map.addControl(geocoder); // temporary - we want to fetch from Supabase

                geocoder.on("result", (e) => {
                    const marker = new mapboxgl.Marker({
                        draggable: false,
                        color: "#0a009c" // change color to fit nsf grants
                    })
                    .setLngLat(e.result.center)
                    .addTo(this.map);

                    this.center = e.result.center;

                });

            } 
            catch (err) {
                console.log("map error", err);
            }
        }
    }
}

</script>