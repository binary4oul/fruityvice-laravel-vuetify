<template>
<div>
  <v-container fluid>
    <v-row v-if="getSystemIdx != -1">
      <v-col cols="12" sm="4">
          <v-icon @click="changeShowIngredients" medium>{{ icon_ingredientList }}</v-icon>
          Coverage: {{ getArea }} sqft
      </v-col>
      <v-col cols="12" sm="3">
        <template v-if="!show_edit_salePrice">
          <v-btn text small exact color="primary" @click="eidtSalePrice" class="text-lowercase">${{ saleprice }} /sqft</v-btn>
        </template>
        <template v-if="show_edit_salePrice">
          <v-row>
            <v-spacer></v-spacer>
            <vue-numeric-input v-model="saleprice" :value="0" :min="0" controls-type="updown" size="120px"></vue-numeric-input>
            <v-spacer></v-spacer>
            <v-btn color="green" @click="eidtSalePrice" dark small>ok</v-btn>
            <v-spacer></v-spacer>
          </v-row>
        </template>
      </v-col>
      <v-col cols="12" sm="3">
        SystemPrice: ${{ getAreaPrice }}
      </v-col>
    </v-row>

    <v-simple-table dense v-if="show_ingredients">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left clickable" @click="show_ingredientPrice=!show_ingredientPrice">Amount</th>
            <th class="text-left" v-if="show_ingredientPrice">Price</th>
            <th class="text-left">Ingredient</th>
            <th class="text-left">Extra</th>
            <th class="text-left">Units</th>
            <th class="text-left">Color</th>
            <th class="text-left">Pattern</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(ingredient, index) in ingredients" :key="index">
            <td>{{ getAmount(index) }}</td>
            <td v-if="show_ingredientPrice">{{ getIngredientPrice(index) }}</td>
            <td>{{ ingredient.name }}</td>
            <td>{{ ingredient.extra }}</td>
            <td>{{ ingredient.factor }}</td>
            <td v-if="ingredients[`${index}`].color != null">
              <v-select :items="ingredients[`${index}`].color" v-model="ingredients[`${index}`].colorid" item-text="name" solo single-line autowidth hide-details class="py-2"></v-select>
            </td>
            <td v-if="ingredients[`${index}`].color == null">No Colors</td>
            <td v-if="ingredients[`${index}`].pattern != null">
              <v-select :items="ingredients[`${index}`].pattern" v-model="ingredients[`${index}`].patternid" item-text="name" solo single-line autowidth hide-details class="py-2"></v-select>
            </td>
            <td v-if="ingredients[`${index}`].pattern == null">No Patterns</td>
          </tr>
          <tr v-if="show_ingredientPrice">
            <td>Ingredient Cost</td>
            <td>{{ ingredients.reduce( (prev, item, ind)=>(prev+parseFloat(getIngredientPrice(ind))), 0) }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>

  </v-container>
</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({


  }),

mounted() {

},

methods: {


}
}
</script>