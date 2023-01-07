<template>
    <div id="mapView"></div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import { mapActions, mapGetters } from "vuex";
import supabase from "@/supabase"

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
        //this.bootstrap();
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
                
                // plotting markers with pre-computed lat long coordinates
                const { data, error } = await supabase
                    .from("purchases_condensed")
                    .select();
                if (error) throw error;
                //console.log(data);
                
                for (let i = 0; i < data.length; i++) {
                    this.addMarker(data[i]["location"], data[i]["totalamount"]);
                }

            }
            catch (err) {
                console.log("map error", err);
            }

        },
        async addMarker(location, totalAmount) {
                let locArr = location.split(",").map(Number);

                // DOM element for each marker
                const el = document.createElement("div");
                const diameter = 20 + 0.01 * Math.sqrt(totalAmount); // one way to show scale of different amounts
                el.className = "marker";
                el.style.width = `${diameter}px`;
                el.style.height = `${diameter}px`;

                this.marker = new mapboxgl.Marker(el)
                    .setLngLat(locArr)
                    .addTo(this.map);
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