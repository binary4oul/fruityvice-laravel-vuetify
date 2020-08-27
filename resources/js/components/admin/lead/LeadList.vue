<template>

<v-card>
      <v-card-title>
        Nutrition
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
        { text: 'id', value: 'id' },
        { text: 'personid', value: 'personid' },
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
      })
      .catch(err => {
        this.handleErrors(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },

  }
}
</script>