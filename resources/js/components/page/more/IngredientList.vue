<template>
<v-card>
      <v-card-title>
        Ingredients
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
          :items="ingredients"
          :search="search"
          @click:row="selectIngredient"
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
        { text: 'Coverage Area sq/ft', value: 'coverage' },
        { text: 'Phurchage Price', value: 'purchaseprice' }
      ],
      ingredients:[]
    }),

mounted() {
  this.getIngredients()
},

methods: {
  getIngredients() {
    axios.get(api.path('ingredients'))
      .then(res => {
        this.ingredients  = res.data
        this.ingredients.map((item, index)=> item['no'] = index + 1 )
      })
      .catch(err => {
        this.handleErrors(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
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