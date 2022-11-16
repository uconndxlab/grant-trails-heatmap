<template>
    <div>
        <v-footer bottom fixed padless>
            <v-card flat tile width="100%">
                <v-card-text>
                    <v-row>
                        <v-col>
                            <a class="footer-link" href="https://uconn.edu/">&copy; University of Connecticut</a>
                            <a class="footer-link" href="https://uconn.edu/disclaimers-privacy-copyright/">Disclaimers, Privacy &amp; Copyright</a>
                            <a class="footer-link" href="https://accessibility.uconn.edu/">Accessibility</a>
                        </v-col>
                        <v-col>
                            <img width="26px" src="../assets/img/dx.png">
                            Developed by the <a href="https://dxgroup.core.uconn.edu" class="px-1"> UConn Digital Experience Group</a> | <a href="https://core.uconn.edu" class="px-1">Center for Open Research Resources & Equipment </a>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-footer>
    </div>
</template>

<script>
export default ({
    name: "FooterVue"
})

</script>