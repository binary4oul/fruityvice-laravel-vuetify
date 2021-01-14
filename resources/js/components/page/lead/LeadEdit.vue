<template>
  <div>
    <person-edit-form v-if="lead" :person="lead['person']" :project_id="lead_id"></person-edit-form>

    <v-row v-if="lead_id!='new' && lead.lead">
      <v-col cols="12" sm="3">
        <v-checkbox v-model="lead.lead.active" label="Active" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-8 my-0">Acive</v-checkbox>
      </v-col>
    </v-row>

    <project-edit :project_id="lead_id"></project-edit>
    <lead-detail :leaddetail="lead['leaddetail']"></lead-detail>
    <template v-if="lead_id != 'new'">
      <phone-edit-form v-if="lead['person']" :project_id="lead_id" :phone="lead['person']['phones']"></phone-edit-form>
      <address-edit-form v-if="lead['person']" :project_id="lead_id" :address="lead['person']['addresses']" ></address-edit-form>
    </template>
    <template v-else>
      <phone-edit-form :project_id="lead_id" :phone="[]"></phone-edit-form>
      <address-edit-form :project_id="lead_id" :address="[]" ></address-edit-form>
    </template>
    <v-row>
      <v-spacer></v-spacer>
      <v-btn color="green" dark class="mx-2 my-4" @click="saveLead">Save</v-btn>
      <v-btn color="error" dark class="mx-2 my-4" v-if="lead_id != 'new'" @click="deleteLead">Delete</v-btn>
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
import ProjectEdit from '../component/ProjectEdit'
import PhoneEditForm from '../component/PhoneEditForm'
import AddressEditForm from '../component/AddressEditForm'
import LeadDetail from './LeadDetail'

export default {
components: {
    PersonEditForm,
    ProjectEdit,
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
    this.lead_id = this.$route.params.leadid
    if(this.lead_id != 'new') this.getLead(this.lead_id)

    let data = {'title': 'Lead'}
    if(this.lead_id == 'new') data['title'] = "New Lead"
    this.$store.dispatch('title/setTitle', data)
},

data: () => ({
    lead: {},
    items: ['Home', 'Office', 'Mobile'],
}),

methods: {
    success(data) {

    },
    getLead(lead_id) {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.get(api.path('project') +"/"+ lead_id)
          .then(res => {
            this.lead  = res.data
            this.lead['leaddetail'] = {}
            this.lead['leaddetail']['email'] = this.lead['email']
            this.lead['leaddetail']['hearaboutus'] = this.lead['hearaboutus']
            this.lead['leaddetail']['besttimetocall'] = this.lead['besttimetocall']
            this.lead['leaddetail']['howcanwehelp'] = this.lead['howcanwehelp']
          })
          .catch(err => {
              this.$toast.error('Server Error!')
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
    saveLead(){
      if(this.lead_id == 'new')
      {
        let project_data = { ...this.leaddetail }
        project_data['person'] = this.person
        project_data['phone'] = this.phone
        project_data['address'] = this.address
        project_data['project_detail'] = store.getters['project/projectDetail']
        project_data['project_detail']['project_detail_styles'] = store.getters['project/projectDetailStyles']

        this.$store.dispatch('loader/setLoader', { loader: true })
        axios.post(api.path('project'), project_data)
            .then(res => {
              if(res.data['status']){
                if(res.data.status === 'error') this.$toast.error(res.data.message)
              }
              else {
                this.lead_id = res.data['id']
                this.$toast.success('Saved successfully!')
                this.$router.go(-1)
              }
            })
            .catch(err => {
                this.$toast.error("Lead data error!")
            })
            .then(()=>{
              this.$store.dispatch('loader/setLoader', { loader: false })
            })
        }
        else
        {
          let project_data = { ...this.leaddetail }
          this.$store.dispatch('loader/setLoader', { loader: true })
          axios.put(api.path('project') +'/'+ this.lead_id, project_data)
              .then(res => {
                this.$toast.success('Updated successfully!')
                this.$router.go(-1)
              })
              .catch(err => {
                  this.$toast.error("Lead data error!")
              })
              .then(()=>{
                this.$store.dispatch('loader/setLoader', { loader: false })
              })
        }
    },
    deleteLead(){

    }

},

}
</script>