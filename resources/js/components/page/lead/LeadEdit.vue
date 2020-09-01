<template>
<v-card>
    <v-card-title>
        Edit Lead
        <v-spacer></v-spacer>
        </v-card-title>
    <person-edit-form :person="lead['person']"></person-edit-form>
    <system-edit-form></system-edit-form>
    <lead-detail :leaddetail="lead['leaddetail']"></lead-detail>

</v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'
import PersonEditForm from '../component/PersonEditForm'
import SystemEditForm from '../component/SystemEditForm'
import LeadDetail from './LeadDetail'

export default {
components: {
    PersonEditForm,
    SystemEditForm,
    LeadDetail,
},

computed: mapGetters({

}),

mounted() {
    let leadid = this.$route.params.leadid
    this.getLead(leadid)
},

data: () => ({
    lead: {},
}),

methods: {
    success(data) {

    },
    getLead(leadid) {
        axios.get(api.path('lead') +"/"+ leadid)
            .then(res => {
                this.lead  = res.data
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
            .then(() => {
                this.loading = false
        })
    },
},

}
</script>