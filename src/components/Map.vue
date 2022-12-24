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
                //console.log(locArr);

                this.marker = new mapboxgl.Marker({
                    scale: 1 + 0.000000075 * totalAmount, // arbitrary sizing method - change later
                    color: "#0a009c" // change to whatever color we want later
                })
                .setLngLat(locArr)
                .addTo(this.map);
        }
    }
}

</script>