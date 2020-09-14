<template>
<v-card>
      <v-card-title>
        Estimates
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
          :search="search"
          @click:row="selectEstimate"
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
        { text: 'Customer', value: 'name' },
        { text: 'Create_at', value: 'person.company' },
        { text: 'Price', value: 'created_at' }
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
        this.leads.map(lead => {
            axios.get(api.path)
        })
      })
      .catch(err => {
        this.handleErrors(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  selectEstimate(lead){
    this.$router.push({ name: 'lead-edit', params:{leadid: lead['id']} })
  },
  addNew(){
    this.$router.push({ name: 'lead-edit', params:{leadid: 'new'} })
  }
}
}
</script>