<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="fruits"
      :hide-default-footer="true"
    >
    </v-data-table>
  </div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
  headers: [
      { text: 'Genius', value: 'genus' },
      { text: 'Name', value: 'name' },
      { text: 'Family', value: 'family' },
      { text: 'Order', value: 'order' },
      { text: 'Carbohydrates', value: 'carbohydrates' },
      { text: 'Protein', value: 'protein' },
      { text: 'Fat', value: 'fat' },
      { text: 'Calories', value: 'calories' },
      { text: 'Sugar', value: 'sugar' },
      { text: 'Sum', value: 'sum' },

    ],
  fruits: []
  }),

mounted() {
  let data = {'title': 'Favourite fruits'}
  this.$store.dispatch('title/setTitle', data)
  this.getFruits()
},
methods: {
  getFruits() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('fruits'), { params: { is_fav : 1 }  })
      .then(res => {
        console.log('res', res)
        const { data, } = res.data
        this.fruits  = data
      })
      .catch(err => {
        this.$toast.error('Server Error')
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
},
created() {
    this.status = this.$route.params.status
    this.active = this.$route.params.active
}
}
</script>