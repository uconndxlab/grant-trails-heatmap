<template>
    <div class="panel">
        <v-expansion-panels multiple accordian>
            <v-expansion-panel :key="0">
                <v-expansion-panel-title>
                    Filters
                </v-expansion-panel-title>
                <v-expansion-panel-text>
                    <FiltersVue />
                </v-expansion-panel-text>
            </v-expansion-panel>
            <v-expansion-panel :key="1">
                <v-expansion-panel-title>
                    What am I looking at?
                </v-expansion-panel-title>
                <v-expansion-panel-text id="result-description">
                    <h4> Grant Trails</h4>
                    <p>While federal, state, and corporate research grants support researchers at an institution, they also play an important role in supporting local economies in a manner that often gets overlooked.</p>
                    <p>The reason for this is that grant dollars almost never stay completely within an institution, instead they are used to pay for equipment, reagents, consumables, salaries, etc. that are required for actually carrying out the research.</p>
                    <p>Not surprisingly the companies providing the goods purchased on grants, and the people (graduate students, post-doctoral fellows, technicians, etc.) employed on grant dollars, tend to be located (or live) within relatively close proximity to the institution carrying out the research.</p>
                    <!--TODO: Include a tooltip here hovering over where it says 85%
                    Content of the tooltip:
                    It's not 100% of the data because there were logistical issues that made getting some of the data challenging. That said, we have no reason to believe that the missing data would not be proportionally distributed, so the relative circle sizes shouldn't really change (though the exact dollar amounts might somewhat)-->
                    <p>What you're looking at here is a visualization of where approximately 85% of direct grant dollars received by UConn faculty were spent within Connecticut between fiscal years 2020 to 2021.</p>
                    <p>
                        Feel free to explore the visualization by typing in a location (city or zip), adjusting filters, or just panning and zooming on the map. Most importantly <a href="https://dxgroup.core.uconn.edu/">let us know</a> what you think!
                    </p>

                    <!--TODO: Add <a> tags to necessary spots below (github, license)-->
                    <h4> Credit</h4>
                    <p>Grant Trails is an open source project available for universities to showcase their geographic grant distribution. Source code can be found on <a href="https://github.com/uconndxlab/grant-trails-heatmap">GitHub</a>.</p>
                    <p>The project is built using an extensive library of open data and software. A brief list can be found in the copyright and license file.</p>
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>

<script>
import FiltersVue from '../components/Filters.vue';

export default ({
    name: "ExpansionPanelVue",
    components: { FiltersVue }
})

</script>