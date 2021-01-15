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
      :items="contems"
      :search="search"
      @click:row="selectConTem"
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
      { text: 'Created_at', value: 'created_at' }
    ],
    contems:[]
  }),

mounted() {
  this.getConTems()
  let data = {'title': 'Contract Templates'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getConTems() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('contracttemplates'))
      .then(res => {
        this.contems  = res.data
        this.contems.map((item, index)=> item['no'] = index + 1 )
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
  selectConTem(contem){
    this.$router.push({ name: 'contract_template-edit', params:{id: contem['id']} })
  },
  addNew(){
    this.$router.push({ name: 'contract_template-edit', params:{id: 'new'} })
  }
}
}
</script>