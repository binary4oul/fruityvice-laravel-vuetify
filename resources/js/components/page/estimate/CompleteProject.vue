<template>
  <div>
    <v-row class="d-flex flex-row-reverse">
      <v-col sm="6">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>

    <v-data-table
      :headers="headers"
      :items="estimates"
      :search="search">
      <template v-slot:item="row">
        <tr @click="selectEstimate(row.item)">
          <td>{{row.item.fullname}}</td>
          <td>{{row.item.company}}</td>
          <td>${{row.item.price}}</td>
          <td>{{row.item.area}} sqft</td>
          <td>{{row.item.created_at}}</td>
        </tr>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
      search: '',
      headers: [
        { text: 'Customer', value: 'fullname' },
        { text: 'Company', value: 'company' },
        { text: 'Price', value: 'price' },
        { text: 'Area', value: 'area' },
        { text: 'Create_at', value: 'created_at' }
      ],
      estimates:[]
    }),

mounted() {
  this.getProjects()
  let data = {'title': 'Complete Projects'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getProjects() {
    let request = {}
    request['projectstatus'] = 'complete'
    request['active'] = this.active
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.post(api.path('projectlist'), request)
        .then(res => {
          let data = res.data
          if(!('error' in data)) {
            this.estimates = data.map( (item) => {
              const estimate = {}
              estimate['id'] = item['id']
              estimate['fullname'] = item['person']['firstname'] +' '+ item['person']['lastname']
              estimate['company'] = item['person']['company']
              estimate['created_at'] = item['created_at']
              estimate['area'] = 0
              estimate['price'] = 0
              item['project_details'].forEach( detail => {
                estimate['area'] += detail['area']
                estimate['price'] += detail['areaprice']
              })
              return estimate
            })
          }
        })
        .catch(err => {
          this.$toast.error(err.response.data.errors)
        })
        .then(() => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
    },
  selectEstimate(estimate){
    this.$store.dispatch('auth/setTeamRole', { team_role: 'manager' })
    this.$router.push({ name: 'estimate-edit', params:{ projectid: estimate['id']} })
  },
},
created() {
    this.status = this.$route.params.status
    this.active = this.$route.params.active
}
}
</script>