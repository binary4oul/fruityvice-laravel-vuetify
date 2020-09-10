<template>
<v-card>
    <v-card-title>
        Edit Lead
        <v-spacer></v-spacer>
    </v-card-title>
    <person-edit-form :person="lead['person']" :leadid="leadid"></person-edit-form>
    <system-edit-form :leadid="leadid"></system-edit-form>
    <lead-detail :leaddetail="lead['leaddetail']" :leadid="leadid"></lead-detail>
    <phone-edit-form :personid="personid" :phone="lead['phone']"></phone-edit-form>
    <address-edit-form :personid="personid" :address="lead['address']" ></address-edit-form>
    <v-row>
        <v-spacer></v-spacer>
        <v-btn color="green" dark class="mx-2 my-4" @click="saveLead">Save</v-btn>
        <v-btn color="error" dark class="mx-2 my-4" v-if="leadid != 'new'" @click="deleteLead">Delete</v-btn>
        <v-btn class="mx-2 my-4" @click="$router.push({name:'leads'})">Cancel</v-btn>
        <v-spacer></v-spacer>
    </v-row>

</v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import store from '~/store'
import axios from 'axios'
import { api } from '~/config'
import PersonEditForm from '../component/PersonEditForm'
import SystemEditForm from '../component/SystemEditForm'
import PhoneEditForm from '../component/PhoneEditForm'
import AddressEditForm from '../component/AddressEditForm'
import LeadDetail from './LeadDetail'

export default {
components: {
    PersonEditForm,
    SystemEditForm,
    LeadDetail,
    PhoneEditForm,
    AddressEditForm,
},

computed: mapGetters({
    person: 'person/person',
    address: 'person/address',
    phone: 'person/phone',
    leaddetail: 'leaddetail/leaddetail'
}),

created() {
    this.leadid = this.$route.params.leadid
    if(this.leadid != 'new') this.getLead(this.leadid)
    else this.personid = 'new'
},

data: () => ({
    lead: {},
    personid: '',
    items: ['Home', 'Office', 'Mobile'],
}),

methods: {
    success(data) {

    },
    getLead(leadid) {
        axios.get(api.path('lead') +"/"+ leadid)
            .then(res => {
                this.lead  = res.data
                this.personid = this.lead['person']['id']
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
            .then(() => {
                this.loading = false
        })
    },
    saveLead(){
        let personid, leadid
        if(this.leadid == 'new')
        {
            axios.post(api.path('person'), this.person)
                .then(res => {
                    personid = res.data.id
                    leadid = res.data['leadid']
                })
                .catch(err => {
                    this.handleErrors("lead data error!")
                }).then(()=>{

                    this.phone['personid'] = personid
                    axios.post(api.path('phone'), this.phone)
                        .then(res => {

                        })
                        .catch(err => {
                            this.handleErrors("phone data error!")
                        })

                    this.address['personid'] = personid
                    axios.post(api.path('address'), this.address)
                        .then(res => {

                        })
                        .catch(err => {
                            this.handleErrors("address data error!")
                        })

                    this.leaddetail['leadid'] = leadid
                    axios.post(api.path('leaddetail'), this.leaddetail)
                        .then(res => {

                        })
                        .catch(err => {
                            this.handleErrors("leaddetail data error!")
                        })
                    this.$toast.success('Saved successfully!')
                })

        }
        else
        {
            axios.put(api.path('leaddetail') +'/'+ this.leaddetail['id'], this.leaddetail)
                .then(res => {

                })
                .catch(err => {
                    this.handleErrors("leaddetail data error!")
                })
            this.$toast.success('Updated successfully!')
        }

    },
    deleteLead(){

    }
},

}
</script>