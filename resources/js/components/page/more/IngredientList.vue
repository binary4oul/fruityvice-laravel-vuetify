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
          :items="ingredients"
          :search="search"
          @click:row="selectIngredient"
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
        { text: 'Coverage Area sq/ft', value: 'coverage' },
        { text: 'Phurchage Price', value: 'purchaseprice' }
      ],
      ingredients:[]
    }),

mounted() {
  this.getIngredients()
  let data = {'title': 'Ingredients'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getIngredients() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('ingredients'))
      .then(res => {
        this.ingredients  = res.data
        this.ingredients.map((item, index)=> item['no'] = index + 1 )
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
  selectIngredient(ingredient){
    this.$router.push({ name: 'ingredient-edit', params:{ingredientid: ingredient['id']} })
  },
  addNew(){
    this.$router.push({ name: 'ingredient-edit', params:{ingredientid: 'new'} })
  }
}
}
</script>