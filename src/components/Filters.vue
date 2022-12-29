<template>
    <div>
        <v-select
            :items="['All', 'Federal', 'State', 'Corporate', 'University', 'Non-profit', 'Other']"
            chips
            density="compact"
            variant="underlined"
            @change="filterResultsByCurrentState()"
            label="Grant Type">
        </v-select>

        <v-select
            :items="['All', '2014', '2015', '2016', '2017', '2018', '2019', '2020']" 
            chips
            density="compact"
            variant="underlined"
            @change="filterResultsByCurrentState()"
            label="Fiscal Year" >
        </v-select>

        <v-list id="result-list">
            <v-item-group>
                <v-list-item v-for="i in results" :key="i.fund_type ">
                    <v-list-item-media>
                        <v-list-item-title>Grant Name Here</v-list-item-title>
                            <!-- <span v-if="current_year !== 'All'"><strong>{{current_year}}: </strong>{{ins['Award_Amount_' + current_year]}} </span>
                            <span v-if="current_year == 'All'"><strong>Total Awards (2011-2022) </strong>{{ins['total_award']}} </span>

                            <span v-if="current_year !== 'All'"><strong>{{current_year}} Jobs: </strong>{{ins['jobs_' + current_year]}} </span>
                            <span v-if="current_year == 'All'"><strong> Total Jobs (2011-2022) </strong>{{ins['total_jobs']}} </span> -->
                    </v-list-item-media>
                </v-list-item>
            </v-item-group>
        </v-list>
    </div>
</template>

<script>

export default ({
    name: 'FiltersVue'
})

</script>