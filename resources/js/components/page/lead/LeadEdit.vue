<template>
<div>
    <person-edit-form :person="lead['person']" :leadid="leadid"></person-edit-form>

    <v-row v-if="leadid!='new' && lead.lead">
        <v-col cols="12" sm="3">
          <v-checkbox v-model="lead.lead.active" label="Active" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-8 my-0">Acive</v-checkbox>
        </v-col>
    </v-row>

    <system-edit-form :leadid="leadid"></system-edit-form>
    <lead-detail :leaddetail="lead['leaddetail']" :leadid="leadid"></lead-detail>
    <phone-edit-form :personid="personid" :phone="lead['phone']"></phone-edit-form>
    <address-edit-form :personid="personid" :address="lead['address']" ></address-edit-form>
    <v-row>
        <v-spacer></v-spacer>
        <v-btn color="green" dark class="mx-2 my-4" @click="saveLead">Save</v-btn>
        <v-btn color="error" dark class="mx-2 my-4" v-if="leadid != 'new'" @click="deleteLead">Delete</v-btn>
        <v-btn class="mx-2 my-4" @click="$router.go(-1)">Cancel</v-btn>
        <v-spacer></v-spacer>
    </v-row>
</div>
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
    leaddetail: 'leaddetail/leaddetail',
    project_store: 'project/project'
}),

created() {
    this.leadid = this.$route.params.leadid
    if(this.leadid != 'new') this.getLead(this.leadid)
    else this.personid = 'new'

    let data = {'title': 'Lead'}
    if(this.leadid == 'new') data['title'] = "New Lead"
    this.$store.dispatch('title/setTitle', data)
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
                    let lead_data = this.lead['lead']
                    axios.put(api.path('lead') +'/'+ leadid, lead_data)
                        .then(res => {

                        })
                        .catch(err =>{
                            this.handleErrors('Lead data error!')
                        })

                    this.phone['personid'] = personid
                    if('number' in this.phone){
                        axios.post(api.path('phone'), this.phone)
                            .then(res => {
                            })
                            .catch(err => {
                                this.handleErrors("phone data error!")
                            })
                    }

                    this.address['personid'] = personid
                    if('address1' in this.address){
                        axios.post(api.path('address'), this.address)
                            .then(res => { })
                            .catch(err => {
                                this.handleErrors("address data error!")
                            })
                    }

                    this.leaddetail['leadid'] = leadid
                    axios.post(api.path('leaddetail'), this.leaddetail)
                        .then(res => {  })
                        .catch(err => {
                            this.handleErrors("leaddetail data error!")
                        })

                    let project = { 'leadid': leadid }
                    axios.post(api.path('project'), project)
                        .then(res => {
                            project = res.data
                            this.project_store.projectdetails.map(detail => {
                                detail['projectid'] = project['id']
                                axios.post(api.path('projectdetail'), detail)
                                    .then(res => {

                                    })
                            })
                            let projectnote = { note: project_store['note'], projectid: project['id']}
                            axios.post(api.path('projectdetail'), detail)
                                    .then(res => {

                            })
                        })
                        .catch(err => {
                            this.handleErrors("leaddetail data error!")
                        })

                    this.$toast.success('Saved successfully!')
                    this.$route.go(-1)
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
            let lead_data = this.lead['lead']
                    axios.put(api.path('lead') +'/'+ this.leadid, lead_data)
                        .then(res => {

                        })
                        .catch(err =>{
                            this.handleErrors('Lead data error!')
                        })
            this.$toast.success('Updated successfully!')
            this.$route.go(-1)
        }

    },
    deleteLead(){

    }

},

}
</script>