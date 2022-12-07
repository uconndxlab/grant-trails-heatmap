<template>
    <div id="mapView"></div>
</template>

<script>

import supabase from "@/supabase";
import mapboxgl from "mapbox-gl";

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
                mapboxgl.accessToken = this.accessToken;

                this.map = new mapboxgl.Map({
                    container: "mapView",
                    style: "mapbox://styles/mapbox/streets-v11",
                    center: [-72.7, 41.45],
                    zoom: 8.5
                });
                
                const {count, error} = await supabase
                    .from("purchases")
                    .select("Zip", {count: "exact", head: "true"});
                
                if (error) throw error;
                console.log(count);
                // the line below will crash the site -- too many records
                //for (let i = 0; i < count / 1000; i++) this.loadPageToMap(i);
                this.loadPageToMap();
            }
            catch (err) {
                console.log("map error", err);
            }

            
        },
        async loadPageToMap(page = 1) {
            // pagination func
            const getPagination = (page, size) => {
                const limit = size ? +size : 3;
                const from = page ? page * limit : 0;
                const to = page ? from + size : size;

                return { from, to };
            };

            // for each new zipcode in "purchases" we want to geocode it and add a marker to map
            const { from, to } = getPagination(page, 1000);
            const { data, error } = await supabase
                .from("purchases")
                .select("*", {count: "exact"})
                .order("id", {ascending: true})
                .range(from, to);
            
            if (error) throw error;
            console.log(data);

            for (let item in data) {
                this.addMarker(item);
            }
        },
        async addMarker(zip_target) {
                if (zip_target === "") return; // for when we have no zipcode

                //only looking for places in the US
                const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${zip_target}.json?country=US&access_token=${this.accessToken}`;
                const response = await fetch(endpoint);
                const results = await response.json()

                this.marker = new mapboxgl.Marker({
                    draggable: false,
                    color: "#0a009c" // change to whatever color we want later
                })
                .setLngLat(results["features"][0]["center"])
                .addTo(this.map);
        }
    }
}

</script>