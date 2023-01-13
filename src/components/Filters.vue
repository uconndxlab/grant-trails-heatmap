<template>
    <div>
        <v-select
            :items="['All', 'Federal', 'State/CT', 'State(Not CT)', 'Corporate', 'University', 'Non-profit', 'Other']"
            v-model="current_type"
            chips
            density="compact"
            variant="underlined"
            @update:modelValue="filterResultsByCurrentState()"
            label="Grant Type">
        </v-select>

        <v-select
            :items="['2020', '2021']" 
            v-model="current_year"
            chips
            multiple
            density="compact"
            variant="underlined"
            @update:modelValue="filterResultsByCurrentState()"
            label="Fiscal Year" >
        </v-select>

        <v-list id="result-list">
            <v-item-group>
                <v-list-item v-for="grant in limitedResults" :key="grant.id">
                    <v-list-item-media>
                        <v-list-item-title>{{ titleCase(grant.grants_city) }}</v-list-item-title>
                        <span>0{{ grant.grants_zip }} CT, US</span><br />
                        <span><strong>{{ toUSD(grant.total_amount) }}</strong></span>
                    </v-list-item-media>
                </v-list-item>
            </v-item-group>
        </v-list>
    </div>
</template>

<script>
//import toRaw from 'vue';
import { mapActions, mapGetters } from 'vuex';
import addMarkers from '@/components/Map.vue'

export default ({
    name: 'FiltersVue',
    data: () => ({
        current_type: "All",
        current_year: "2020",
    }),
    computed: {
        ...mapGetters({
            grants: 'grants'
        }),
        limitedResults() {
            return this.grants.slice(0, 500)
        }
    },
    mounted() {
        this.bootstrap();
    },
    methods: {
        ...mapActions({
            bootstrap: 'bootstrap',
            filteringGrants: 'fetchFilterGrants'
        }),
        filterResultsByCurrentState() {
            console.log('filtering')
            const searchOptions = []
            searchOptions.push(this.current_year)
            searchOptions.push(this.current_type)
            console.log(searchOptions)
            this.filteringGrants(searchOptions)
            addMarkers(this.grants)
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
    }
}})

</script>