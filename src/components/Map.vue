<template>
    <div id="mapView"></div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
//import supabase from "../supabase"

export default {
    name: "MapVue",
    data() {
        return {
            accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN
        };
    },
    mounted() {
        this.createMap();
    },
    methods: {
        async createMap() {
            try {
                console.log(process.env.VUE_APP_MAPBOX_ACCESS_TOKEN)
                mapboxgl.accessToken = this.accessToken;

                this.map = new mapboxgl.Map({
                    container: "mapView",
                    style: "mapbox://styles/mapbox/streets-v11",
                    center: [-72.7, 41.45],
                    zoom: 8.5
                });

                /*
                // for each new zipcode in "purchases" we want to geocode it and add a marker to map
                
                let { data: purchases, error } = await supabase
                    .from("purchases")
                    .select("Zip Code") //look at zip codes
                    .not("Zip Code", "is", null); // no null values
                */
                
                
                new MapboxGeocoder({
                    accessToken: this.accessToken,
                    mapboxgl: mapboxgl,
                    types: "postcode",
                    marker: false
                });
                
                const zip_target = "06071";

                const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${zip_target}.json?access_token=${this.accessToken}`;
                const response = await fetch(endpoint);
                const results = await response.json()

                this.marker = new mapboxgl.Marker({
                    draggable: false,
                    color: "#0a009c"
                })
                .setLngLat(results["features"][0]["center"])
                .addTo(this.map);

            }
            catch (err) {
                console.log("map error", err);
            }
        }
    }
}

</script>