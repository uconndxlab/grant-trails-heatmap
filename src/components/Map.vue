<template>
    <div id="mapView"></div>
</template>

<script>

import supabase from "@/supabase";
import mapboxgl from "mapbox-gl";
import { ref } from "vue";
//import { supabase } from "../supabase"


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
                
                // for each new zipcode in "purchases" we want to geocode it and add a marker to map
                
                const data = ref([]);
                const dataLoaded = ref(null);

                const getData = async() => {
                    try {
                        const { data: purchases, error } = await supabase.from("purchases").select("Zip Codes");
                        if (error) throw error;
                        data.value = purchases;
                        dataLoaded.value = true;
                        console.log(data.value);
                    } catch (error) {
                        console.warn(error.message)
                    }
                };

                getData();
                for (let i = 0; i < data.length; i++) this.addMarker(data[i]);
                

                //let zips = ["06269", "06071", "01741"];
                //for (let i = 0; i < zips.length; i++) this.addMarker(zips[i]);

            }
            catch (err) {
                console.log("map error", err);
            }

            
        },
        async addMarker(zip_target) {
                const endpoint = `https://api.mapbox.com/geocoding/v5/mapbox.places/${zip_target}.json?access_token=${this.accessToken}`;
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