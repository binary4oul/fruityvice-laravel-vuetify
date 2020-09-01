<template>
    <v-container fluid>
        <template f fluid>
            <v-btn block @click="changeOpenState" color="rgb(236,151,31)" dark>LEAD DETAIL</v-btn>
        </template>
        <v-spacer></v-spacer>

        <template v-if="open && leaddetail != null">
            <v-text-field label="Email" v-model="leaddetail.email"  class="pt-8"></v-text-field>
            <v-textarea
                label="Best time to call"
                v-model="leaddetail.besttimetocall"
                @input="change"
                auto-grow
                outlined
                rows="2"
                row-height="15"
            ></v-textarea>
            <v-textarea
                label="How did you hear about us"
                v-model="leaddetail.hearaboutus"
                @input="change"
                auto-grow
                outlined
                rows="2"
                row-height="15"
            ></v-textarea>
            <v-textarea
                label="How can we help?"
                v-model="leaddetail.howcanwehelp"
                @input="change"
                auto-grow
                outlined
                rows="2"
                row-height="15"
            ></v-textarea>
        </template>
    </v-container>
</template>
<script>
import { mapGetters } from 'vuex'

export default {

data: () => ({
    open: false,

}),
props: ['leaddetail'],

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    change(){
        let data = {'leaddetail': this.leaddetail}
        this.$store.dispatch('leaddetail/setLeaddetail', data)
    }
},

mounted() {
    setTimeout(() => {
        if(this.leaddetail == null){
            this.leaddetail = {}
            this.leaddetail['email'] =''
            this.leaddetail['besttimetocall'] =''
            this.leaddetail['hearaboutus'] =''
            this.leaddetail['howcanwehelp'] =''
        }
        this.change()
    }, 2000)
},
}
</script>