<template>
  <v-container fluid>
    <v-text-field label="Name" v-model="system.name"></v-text-field>
    <v-row>
      <v-col cols="6" sm="3">
        <v-checkbox v-model="system['active']" label="Active" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-0 my-0">Acive</v-checkbox>
      </v-col>
      <v-col cols="6" sm="3">
        <v-checkbox v-model="system['share']" label="Share" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-0 my-0">Share</v-checkbox>
      </v-col>
      <v-col cols="12" sm="6">
        System Price / sq ft :
        <vue-numeric-input v-model="system.saleprice" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
      </v-col>
    </v-row>
    <template f fluid>
      <v-btn block @click="open_ingredients=!open_ingredients" v-bind:color="open_ingredients == true ? 'rgb(236,151,31)' : 'primary'" dark class="my-4">
        Ingredients({{system_details.length}})
      </v-btn>
    </template>
    <template v-if="open_ingredients">
      <v-row>
        <v-col cols="12" sm="4">
          Name
        </v-col>
        <v-col cols="12" sm="2">
          Purchase Price
        </v-col>
        <v-col cols="12" sm="2">
          Units
        </v-col>
        <v-col cols="12" sm="4">
          Extra Info
        </v-col>
      </v-row>
      <v-row v-for="item in system_details" :key="item.id">
        <v-col cols="12" sm="4">
          <v-checkbox
            v-model="item.ingredientselect"
            :label=item.name
            v-bind:false-value=false
            v-bind:true-value=true
            hide-details
            class="mx-0 my-0">
          </v-checkbox>
        </v-col>
        <v-col cols="12" sm="2">
          {{ item.purchaseprice }}
        </v-col>
        <v-col cols="12" sm="2">
          <vue-numeric-input v-model="item.factor" :value="1" :min="1" controls-type="updown" size="100px"></vue-numeric-input>
        </v-col>
        <v-col cols="12" sm="4">
          <v-text-field v-model="item.extra" single-line class="mx-0 my-0 py-0"></v-text-field>
        </v-col>
      </v-row>
    </template>
    <v-row>
      <v-spacer></v-spacer>
      <v-btn color="green" dark class="mx-2 my-2" @click="saveSystem">Save</v-btn>
      <v-btn color="error" dark class="mx-2 my-2" v-if="systemid != 'new'" @click="deleteSystem">Delete</v-btn>
      <v-btn class="mx-2 my-2" @click="$router.push({name:'systems'})">Cancel</v-btn>
      <v-spacer></v-spacer>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import VueNumericInput from 'vue-numeric-input'

export default {

components: {
    VueNumericInput,
},

data: () => ({
  system: {},
  ingredients: [],
  system_details: [],
  open_ingredients: false
}),

created() {
  let data = {'title': 'Edit System'}
  this.$store.dispatch('title/setTitle', data)

  this.getIngredients()
  this.systemid = this.$route.params.systemid
  if(this.systemid != 'new') this.getSystem(this.systemid)
  else this.system.system_details = []
},

methods: {
  getIngredients(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('ingredients'))
        .then(res => {
          this.ingredients = res.data
          if(this.systemid == 'new') this.setSystemDetailsList()
        })
        .catch(err => {
          this.$toast.error("Ingredient data error!")
        })
        .then(res => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
  },

  getSystem(systemid) {
    axios.get(api.path('system') +"/"+ systemid)
        .then(res => {
            this.system = res.data
            this.setSystemDetailsList()
        })
        .catch(err => {
            this.$toast.error("System data error!")
        })
  },

  setSystemDetailsList(){
    this.ingredients.map( ingredient => {
      let ind = this.system.system_details.findIndex( item => item['ingredient_id'] == ingredient['id'])
      let system_details_item = {}
      system_details_item['ingredient_id'] = ingredient['id']
      system_details_item['name'] = ingredient['name']
      system_details_item['purchaseprice'] = ingredient['purchaseprice']
      if(ind != -1){
          system_details_item['ingredientselect'] = true
          system_details_item['factor'] = this.system.system_details[ind]['factor']
          system_details_item['extra'] = this.system.system_details[ind]['extra']
      }
      else {
          system_details_item['ingredientselect'] = false
      }
      this.system_details.push(system_details_item)
    })
  },

  saveSystem(){
    let system_details = []
    this.system_details.map(detail => {
        if(detail['ingredientselect'] == true){
            let system_details_item = {}
            system_details_item['ingredient_id'] = detail['ingredient_id']
            system_details_item['factor'] = detail['factor']
            system_details_item['price'] = detail['purchaseprice'] * detail['factor']
            system_details_item['extra'] = detail['extra']
            system_details.push(system_details_item)
        }
    })
    this.system.system_details = system_details

    let valid = this.checkData(this.system)
    if(valid['status'] == 'error') {
      this.$toast.error(valid['message'])
      return
    }
    if(this.systemid == 'new')
    {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.post(api.path('system'), this.system)
          .then(res => {
            if(res.data['status'] === 'error') this.$toast.error(res.data.message)
            else {
              this.$toast.success('Saved successfully!')
              this.$router.push({ name: 'systems'})
            }
          })
          .catch(err => {
            this.$toast.error("System data error!")
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
    else
    {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.put(api.path('system') +'/'+ this.system['id'], this.system)
          .then(res => {
            if(res.data['status'] === 'error') this.$toast.error(res.data.message)
            else {
              this.$toast.success('Saved successfully!')
              this.$router.push({ name: 'systems'})
            }
          })
          .catch(err => {
            this.$toast.error("System data error!")
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
  },
  deleteSystem(){
    axios.delete(api.path('system') +'/'+ this.system['id'], this.system)
        .then(res => {
          this.$toast.success('Deleted successfully!')
          this.$router.push({name:'systems'})
        })
        .catch(err => {
          this.$toast.error("System data error!")
    })
  },
  checkData(data_system){
    let res = { status: 'success', message: ''}
    if(!data_system['name'] || data_system['name'] === ''){
        res['status'] = 'error'
        res['message'] = 'Input Name'
        return res
    }
    if(!data_system['saleprice']){
        res['status'] = 'error'
        res['message'] = 'Input Price'
        return res
    }
    if(data_system['system_details'].length === 0){
        res['status'] = 'error'
        res['message'] = 'Select Ingredients'
        return res
    }
    return res
  }
}
}
</script>
