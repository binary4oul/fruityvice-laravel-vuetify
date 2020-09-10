<template>
<v-card>
      <v-card-title>
        Systems
        <v-spacer></v-spacer>

        <v-row class="d-flex flex-row-reverse">
          <v-col sm="3" style="align:center">
            <v-btn color="green" dark @click="addNew">
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
          :items="systems"
          :search="search"
          @click:row="selectSystem"
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
        this.handleErrors(err.response.data.errors)
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