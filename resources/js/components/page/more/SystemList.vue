<template>
<v-container fluid>
        <v-row class="mt-4">
          <v-spacer></v-spacer>
          <v-col sm="6">
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-col>
          <v-col sm="3" style="align:center">
            <v-btn color="green" dark @click="addNew">
              <v-icon dark>add</v-icon>Add New
            </v-btn>
          </v-col>
          <v-spacer></v-spacer>
        </v-row>
        <v-data-table
          :headers="headers"
          :items="systems"
          :search="search"
          @click:row="selectSystem"
        ></v-data-table>
</v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
      search: '',
      headers: [
        { text: 'No', value: 'no' },
        { text: 'Name', value: 'name' },
        { text: 'Price', value: 'saleprice' },
        { text: 'Created_at', value: 'created_at' },
        { text: 'Active', value: 'active' },
      ],
      systems:[]
    }),

mounted() {
  this.getSystems()
  let data = {'title': 'Systems'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getSystems() {
    axios.get(api.path('systems'))
      .then(res => {
        this.systems  = res.data
        this.systems.map((item, index)=> {
          item['no'] = index + 1
        })
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  selectSystem(system){
    this.$router.push({ name: 'system-edit', params:{systemid: system['id']} })
  },
  addNew(){
    this.$router.push({ name: 'system-edit', params:{systemid: 'new'} })
  }
}
}
</script>