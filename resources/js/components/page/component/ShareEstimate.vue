<template>
  <v-container fluid>
    <v-row class="px-12">
      <v-select :items="contem_names" label="Select Contract Template" v-model="select_contem"></v-select>
      <v-spacer></v-spacer>
      <v-btn class="mx-8 my-4" color="green" dark @click="sendEstimate">Share with Client</v-btn>
		</v-row>
  </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
  contems: [],
  contem_names: [],
  select_contem: ''
}),
props: ['project_id'],
mounted() {
  this.getConTems()
},

methods: {
  getConTems() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('contracttemplates'))
      .then(res => {
        this.contems  = res.data
        this.contem_names = this.contems.map( item => item.name )
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
  },
  sendEstimate() {
    const contract_id = this.contems.findIndex( item => item.name === this.select_contem )
    if(contract_id === -1) {
      this.$toast.error('Select Contract Template!')
      return
    }
    const data = {
      'project_id': this.project_id,
      'contract_id': this.contems[contract_id]['id']
    }
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.post(api.path('sendEstimate'), data)
        .then(res => {
          const response_data = res.data;
          if(response_data['status'] === 'success') this.$toast.success('Sent successfully!')
          else this.$toast.error(response_data['message'])
        })
        .catch(err => {
          this.$toast.error('Server Error!')
        })
        .then(() => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
	}

}
}
</script>