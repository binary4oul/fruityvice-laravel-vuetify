<template>
<v-card>
      <v-card-title>
        Leads
        <v-spacer></v-spacer>

        <v-row class="d-flex flex-row-reverse">
          <v-col sm="3" style="align:center">
            <v-btn color="green" dark>
              <v-icon dark>add</v-icon>Add New
            </v-btn>
          </v-col>
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
          :items="leads"
          :search="search"
          @click:row="selectLead"
        ></v-data-table>
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
        { text: 'Person', value: 'name' },
        { text: 'Company', value: 'person.company' },
        { text: 'Created_at', value: 'created_at' }
      ],
      leads:[]
    }),

mounted() {
  this.getLeads()
},

methods: {
  getLeads() {
    axios.get(api.path('leads'))
      .then(res => {
        this.leads  = res.data
        this.leads.map(item=> item['name'] = item['person']['firstname'] +" "+ item['person']['lastname'])
      })
      .catch(err => {
        this.handleErrors(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  selectLead(lead){
    this.$router.push({ name: 'lead-edit', params:{leadid: lead['id']} })
  },
  addNew(){
    this.$router.push({ name: 'lead-edit', params:{leadid: 'new'} })
  }
}
}
</script>