<template>
  <v-simple-table dense>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left clickable" @click="show_ingredientPrice=!show_ingredientPrice"><a>Amount</a></th>
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
          <td>{{ detail_styles[index].factor }}</td>
          <td v-if="ingredient.colors.length != 0">
            <v-select
              :items="ingredient.colors"
              v-model="detail_styles[`${index}`].color"
              @change="onChange"
              item-text="name"
              solo single-line
              autowidth hide-details
              class="py-2" />
          </td>
          <td v-else>No Colors</td>
          <td v-if="ingredient.patterns.length != 0">
            <v-select
              :items="ingredient.patterns"
              v-model="detail_styles[`${index}`].pattern"
              @change="onChange"
              item-text="name"
              solo single-line
              autowidth
              hide-details
              class="py-2" />
          </td>
          <td v-else>No Patterns</td>
        </tr>
        <tr v-if="show_ingredientPrice">
          <td>Ingredient Cost</td>
          <td>{{ ingredients.reduce( (prev, item, ind) => ( prev + parseFloat(getIngredientPrice(ind)) ), 0) }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
import {Vue, Component} from 'vue-property-decorator'
import { mapGetters } from 'vuex'
import VueNumericInput from 'vue-numeric-input'
import axios from 'axios'
import { api } from '~/config'
import store from '~/store/index'

export default {
  data: ()=> ({
    show_ingredientPrice: false,
    ingredients: [],
    detail_styles: [],
    project_detail: {}
  }),
  props: [ 'project_detail_styles' ],
  mounted() {
    this.getSystem()
  },
  computed: {
    getAmount: function(idx){
      return idx => ((this.detail_styles[idx]['factor'] * this.getProjectDetail['area'] / this.ingredients[idx]['coverage']).toFixed(2))
    },
    getIngredientPrice: function(idx){
      return idx => ((this.getAmount(idx) * this.ingredients[idx]['purchaseprice']).toFixed(2))
    },
    getProjectDetail: function(){
      return store.getters['project/projectDetail']
    }

  },
  methods: {
    getSystem() {
      const project_detail = this.getProjectDetail
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.get(api.path('system') +"/"+ project_detail['system_id'])
          .then(res => {
            const styles = res.data.system_details
            styles.forEach( item_style => {
              axios.get(api.path('ingredient') +"/"+ item_style['ingredient_id'])
                  .then(res => {
                    const ingredient = res.data
                    this.ingredients.push(ingredient)
                    const detail_style = {}
                    detail_style['factor'] = item_style['factor']
                    detail_style['ingredient_id'] = item_style['ingredient_id']
                    const style = this.project_detail_styles.find( item => item[ingredient_id] == ingredient.id )
                    if(style){
                      detail_style['extra'] = style['extra']
                      const color = ingredient.colors.find( item => item.name === style.color_id)
                      detail_style['color'] = color ? color.name: null
                      const pattern = ingredient.patterns.find( item => item.name === style.pattern_id)
                      detail_style['pattern'] = pattern ? pattern.name: null
                    }
                    else{
                      detail_style['extra'] = ''
                      detail_style['color'] = ''
                      detail_style['pattern'] = ''
                    }
                    this.detail_styles.push(detail_style)
                  })
                  .catch(err => {
                    this.$toast.error("System data error!")
                  })
              })
          })
          .catch(err => {
              this.$toast.error("System data error!")
          })
          .then(res => {
             this.$store.dispatch('loader/setLoader', { loader: false })
          })
    },
    onChange() {
      const temp_detail_styles = []
      this.detail_styles.forEach( item_detail_style => {
        let detail_style = {}
        const ingredient = this.ingredients.find( item => item.id === item_detail_style['ingredient_id'])
        const pattern = ingredient.patterns.find( item => item.name === item_detail_style.pattern)
        const color = ingredient.colors.find( item => item.name === item_detail_style.color)
        detail_style = {
          ingredient_id: item_detail_style['ingredient_id'],
          color_id: color ? color['id']: null,
          pattern_id: pattern ? pattern['id']: null
        }
        temp_detail_styles.push(detail_style)
      })
      let data = {'project_detail_styles': temp_detail_styles}
      this.$store.dispatch('project/setProjectDetailStyles', data)
    }
  }
}
</script>