<template>
    <div>
        <v-select
            :items="['All', 'Federal', 'State/CT', 'State(Not CT)', 'Corporate' ]"
            v-model="current_type"
            chips
            color="blue"
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
            color="blue"
            density="compact"
            variant="underlined"
            @update:modelValue="filterResultsByCurrentState()"
            label="Fiscal Year" >
        </v-select>

        <v-text-field
            v-model="searchTerm" 
            color="blue" 
            label="Filter by Town or Zip"
            variant="underlined"
            clearable 
            @input="filterResultsBySearchTerm()">
        </v-text-field>

        <v-list id="result-list">
            <v-item-group>
                <v-list-item v-for="grant in filteredGrants" :key="grant.id">
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
import { mapActions, mapGetters } from 'vuex';

export default ({
    name: 'FiltersVue',
    data: () => ({
        current_type: "All",
        current_year: "2020",
        searchTerm: ''
    }),
    computed: {
        ...mapGetters({
            grants: 'grants'
        }),
        limitedResults() {
            return this.grants.slice(0, 500)
        },
        filteredGrants() {
            return this.limitedResults.filter(grant => {
                let zip = grant.grants_zip.toString().padStart(5, '0');
                if (this.searchTerm) {
                    return (grant.grants_city.toLowerCase().includes(this.searchTerm.toLowerCase()) || zip.includes(this.searchTerm))
                }
                else {
                    return this.limitedResults
                }
            })
        }
    },
    methods: {
        ...mapActions({
            filteringGrants: 'fetchFilterGrants'
        }),
        filterResultsByCurrentState() {
            console.log('filtering')
            const searchOptions = []
            searchOptions.push(this.current_year)
            searchOptions.push(this.current_type)
            this.filteringGrants(searchOptions)
        },
        filterResultsBySearchTerm() {
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

<style>
    @import '../assets/index.css';
</style>