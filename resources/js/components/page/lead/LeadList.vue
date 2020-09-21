<template>
<div>
         <v-row>
           <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
              class="mx-4 my-4"
            ></v-text-field>
             <v-btn color="green" dark @click="addNew" class="mx-4 my-4">
              <v-icon dark>add</v-icon>Add New
            </v-btn>
            <v-spacer></v-spacer>

        </v-row>
        <v-data-table
          :headers="headers"
          :items="leads"
          :search="search"
          @click:row="selectLead"
        ></v-data-table>
</div>
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
  let data = {'title': 'Leads'}
  this.$store.dispatch('title/setTitle', data)
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