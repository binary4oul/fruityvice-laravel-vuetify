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
                <td>{{row.item.person.fullname}}</td>
                <td>{{row.item.person.company}}</td>
                <td>${{row.item.price}}</td>
                <td>{{row.item.area}} sqft</td>
                <td>{{row.item.install}}</td>
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
        { text: 'Customer', value: 'person.fullname' },
        { text: 'Company', value: 'person.company' },
        { text: 'Price', value: 'price' },
        { text: 'Area', value: 'area' },
        { text: 'Install', value: 'install' }
      ],
      estimates:[]
    }),

mounted() {
  this.getProjects()
   let data = {'title': 'Current Project'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getProjects() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    let request = {}
    request['projectstatus'] = 'current'
    request['active'] = this.active
    axios.post(api.path('projectlist'), request)
        .then(res => {
          let data = res.data
          if(!('error' in data)) {
            data.map( (item) => {
              item['person']['fullname'] = item['person']['firstname'] +' '+ item['person']['lastname']
              item['area'] = 0
              item['price'] = 0
              item['projectdetails'].map( detail => {
                item['area'] += detail['area']
                item['price'] += detail['areaprice']
              })
            })
            this.estimates = [...data]
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
    this.$store.dispatch('auth/team_role', { team_role: 'manager' })
    this.$router.push({ name: 'project-edit', params:{ projectid: estimate['id']} })
  },
},
created() {
    this.status = this.$route.params.status
    this.active = this.$route.params.active
}
}
</script>