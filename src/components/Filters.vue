<template>
    <div>
        <v-select
            v-model="current_type"
            :items="['All', 'Federal', 'State', 'Corporate', 'Other']"
            @change="filterResultsByCurrentState()"
            height="50"
            chips
            dense
            variant="underlined"
            label="Grant Type">
        </v-select>

        <v-select
            :items="['All', '2014', '2015', '2016', '2017', '2018', '2019', '2020']" 
            chips 
            label="Fiscal Year" 
            height="50" 
            dense
            v-model="current_year"
            variant="underlined"
            @change="filterResultsByCurrentState()">
        </v-select>
    </div>
</template>

<script>

export default ({
    name: 'FiltersVue'
})

</script>