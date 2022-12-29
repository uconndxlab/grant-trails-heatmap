<template>
    <div>
        <v-select
            :items="['All', 'Federal', 'State', 'Corporate', 'Other']"
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
    </div>
</template>

<script>

export default ({
    name: 'FiltersVue'
})

</script>