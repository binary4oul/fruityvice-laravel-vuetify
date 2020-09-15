<template>
<v-card>
      <v-card-title>
        Current Projects
        <v-spacer></v-spacer>

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
      </v-card-title>
      <v-card-text>
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
                <td>{{row.item.created_at}}</td>
              </tr>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
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
        { text: 'Create_at', value: 'created_at' }
      ],
      estimates:[]
    }),

mounted() {
  this.getProjects()
},

methods: {
  getProjects() {
    axios.get(api.path('leads'))
      .then(res => {
        this.leads  = res.data
        this.leads.map(lead => {
            let request = {}
            request['leadid'] = lead['id']
            request['projectstatus'] = 'current'
            axios.post(api.path('getByLeadIdProjectStatus'), request)
                .then(res => {
                  let data = res.data
                  if(!('error' in data)) {
                    data['person']['fullname'] = data['person']['firstname'] +' '+ data['person']['lastname']
                    data['area'] = 0
                    data['price'] = 0
                    data['projectdetails'].map( detail => {
                      data['area'] += detail['area']
                      data['price'] += detail['areaprice']
                    })
                    this.estimates.push(data)
                  }
                })
        })

      })
      .catch(err => {
        this.handleErrors(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  selectEstimate(estimate){
    this.$router.push({ name: 'project-edit', params:{leadid: estimate['leadid'], projectid: estimate['projectid']} })
  },
},
created() {
    this.status = this.$route.params.status
}
}
</script>