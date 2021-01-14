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
      :headers="getHeaders"
      :items="systems"
      :search="search"
      @click:row="selectSystem"
    ></v-data-table>
  </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import { mapGetters } from 'vuex'
import store from '~/store'

export default {
data: () => ({
  search: '',
  systems:[],
  user: {}
}),

mounted() {
  this.getSystems()
  let data = {'title': 'Systems'}
  this.$store.dispatch('title/setTitle', data)

},
created() {
  this.user = store.getters['auth/user']
},

computed: {
  getUser: function() {
    return store.getters['auth/user']
  },
  getHeaders: function() {
    return [
            { text: 'No', value: 'no' },
            { text: 'Name', value: 'name' },
            { text: 'Price', value: 'saleprice' },
            { text: 'Created_at', value: 'created_at' },
            {
              text: this.getUser['role'] > 4 ? 'Share': 'Active',
              value: this.getUser['role'] > 4 ? 'share': 'active'
            },
          ]
  }
},

methods: {
  getSystems() {
    this.$store.dispatch('loader/setLoader', { loader: true })
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
        this.$store.dispatch('loader/setLoader', { loader: false })
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