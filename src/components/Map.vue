<template>
    <div id="mapView">
    <v-dialog v-model="dialog" max-width="500" :grant="selectedGrant">
        <template v-slot:activator="{ openDialog }">
            <v-btn @click="openDialog" />
        </template>
        <v-card>
            <v-card-title>
                <span>
                    {{ titleCase(selectedGrant.grants_city) }}
                </span>
                <v-spacer>
                    <span class="text-body-2">
                        <v-chip class="ma-1" color="blue" variant="outlined" size="xsmall">
                            {{currentType}}
                        </v-chip>
                        <v-chip class="ma-1" color="blue" variant="outlined"
                        size="xsmall">
                            {{yearsDisplay(currentYear)}}
                        </v-chip>
                    </span> 
                </v-spacer>
            </v-card-title>
            <v-card-text>
                <span>0{{ selectedGrant.grants_zip }} CT, US</span><br />
                <span><strong>{{ toUSD(selectedGrant.total_amount) }}</strong></span>
            </v-card-text>
            <v-card-actions>
                <v-btn text @click="dialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    </div>
</template>

<script>

import mapboxgl from "mapbox-gl";
import { mapActions, mapGetters } from "vuex";

var currentMarkers = [];

export default {
    name: "MapVue",
    data() {
        return {
            accessToken: process.env.VUE_APP_MAPBOX_ACCESS_TOKEN,
            dialog: false,
            selectedGrant: null,
        };
    },
    computed: {
        ...mapGetters({
            coordinates: 'coordinates',
            grants: 'grants',
            currentType: 'currentType',
            currentYear: 'currentYear',
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
                //console.log(grant);
                const el = document.createElement("div");
                const diam = 20 + 0.8 * Math.pow(grant.total_amount, 1/4);
                el.className = "marker";
                el.style.width = `${diam}px`;
                el.style.height = `${diam}px`;
                el.addEventListener('click', () => {
                    this.selectedGrant = grant;
                    this.dialog = true;
                });
                this.marker = new mapboxgl.Marker(el)
                    .setLngLat(JSON.parse(grant.grants_location).reverse()) //originally the coordinates were reversed for some reason, had to reverse them back
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
        },
        toUSD(amount) {
            const formattedNumber = amount.toLocaleString('en-US', {
                style: 'currency', currency: 'USD' });
            return formattedNumber
        },
        titleCase(str) {
            if (str != null) {
                return str.toLowerCase()
              .split(' ')
              .map(function(word) {
                return word[0].toUpperCase() + word.slice(1);
              })
              .join(' ');
            }
            else {
                return str
            }
    },
    openDialog() {
          this.dialog = true;
      },
      yearsDisplay(years) {
        let returnString = "";
        years.forEach(year => {
            returnString += year + ", ";
        })
        return returnString.slice(0, -2);
      }
    }
}

</script>

<style>
    @import '../assets/index.css';
</style>