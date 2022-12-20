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
            accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN
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

                const { data, error } = await supabase
                    .from("purchases")
                    .select("Location");
                
                if (error) throw error;
                console.log(data);
                
                for (let i = 0; i < 10000; i++) {
                    this.addMarker(data[i]);
                }

            }
            catch (err) {
                console.log("map error", err);
            }

        },
        // async loadPageToMap(page = 1) {
        //     // pagination func
        //     const getPagination = (page, size) => {
        //         const limit = size ? +size : 3;
        //         const from = page ? page * limit : 0;
        //         const to = page ? from + size : size;

        //         return { from, to };
        //     };

            // for each new zipcode in "purchases" we want to geocode it and add a marker to map
            // we want to paginate this to not overwhelm the site
        //},
        async addMarker(location) {
                if (!location) return; // for when we have no coords

                //only looking for places in the US
                //const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${zip_target}.json?country=US&access_token=${this.accessToken}`;
                //const response = await fetch(endpoint);
                //const results = await response.json()

                //location = JSON.stringify(location)
                this.marker = new mapboxgl.Marker({
                    draggable: false,
                    color: "#0a009c" // change to whatever color we want later
                })
                .setLngLat(location["Location"])
                .addTo(this.map);
        }
    }
}

</script>