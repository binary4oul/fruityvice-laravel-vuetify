<template>
<v-card>
      <v-card-title>
        Leads
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="leads"
        :search="search"
        @click:row="selectLead"
      ></v-data-table>
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
    this.$store.dispatch('person/setPerson', lead)
    this.$router.push({ name: 'lead-edit' })
    }
}
}
</script>