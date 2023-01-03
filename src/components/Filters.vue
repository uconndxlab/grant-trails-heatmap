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
            :items="['All', '2014', '2015', '2016', '2017', '2018', '2019', '2020']" 
            v-model="current_year"
            chips
            density="compact"
            variant="underlined"
            @update:modelValue="filterResultsByCurrentState()"
            label="Fiscal Year" >
        </v-select>

        <v-list id="result-list">
            <v-item-group>
                <v-list-item v-for="grant in grants" :key="grant.city ">
                    <v-list-item-media>
                        <v-list-item-title>{{ toUSD(grant.city) }}</v-list-item-title>
                        <span>{{ grant.zip }} CT, US</span><br />
                        <span><strong>{{ toUSD(grant.totalamount) }}</strong></span>
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
        current_year: "All",

        combinedResults: []
    }),
    computed: {
        ...mapGetters({
            grants: 'grants'
        }),
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
        },
        toUSD(amount) {
            const formattedNumber = amount.toLocaleString('en-US', {
                style: 'currency', currency: 'USD' });
            return formattedNumber
            }
        }
    }

)

</script>