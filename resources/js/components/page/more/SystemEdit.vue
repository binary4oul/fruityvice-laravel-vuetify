<template>
<v-container fluid>
        <v-text-field label="Name" v-model="system.name"></v-text-field>
        <v-row>
            <v-col cols="12" sm="3">
                <v-checkbox v-model="system['active']" label="Active" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-0 my-0">Acive</v-checkbox>
            </v-col>
            <v-col cols="12" sm="3">
                <v-checkbox v-model="system['share']" label="Share" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-0 my-0">Share</v-checkbox>
            </v-col>
            <v-col cols="12" sm="6">
                System Price / sq ft :
                <vue-numeric-input v-model="system.saleprice" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
            </v-col>
        </v-row>
        <template f fluid>
            <v-btn block @click="open_ingredients=!open_ingredients" v-bind:color="open_ingredients == true ? 'rgb(236,151,31)' : 'primary'" dark class="my-4">
                Ingredients({{ingredients.length}})</v-btn>
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
        <v-row v-for="item in ingredientList" :key="item.id">
            <v-col cols="12" sm="4">
                <v-checkbox
                    v-model="item.ingredientselect" :label=item.name
                    v-bind:false-value=false v-bind:true-value=true hide-details class="mx-0 my-0"></v-checkbox>
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

created() {
    this.systemid = this.$route.params.systemid
    if(this.systemid != 'new') this.getSystem(this.systemid)
    else {
        this.system.ingredients = []
         this.getIngredients()
    }
    let data = {'title': 'Edit System'}
    this.$store.dispatch('title/setTitle', data)
},

data: () => ({
    system: {},
    ingredients: [],
    ingredientList: [],
    open_ingredients: false,

}),

methods: {
    getIngredients(){
        axios.get(api.path('ingredients'))
            .then(res => {
                this.ingredients = res.data
                this.setIngredientList()
            })
            .catch(err => {
                 this.handleErrors("Ingredient data error!")
            })
    },

    getSystem(systemid) {
        axios.get(api.path('system') +"/"+ systemid)
            .then(res => {
                this.system = res.data
                this.getIngredients()
            })
            .catch(err => {
                this.handleErrors("System data error!")
            })
    },

    setIngredientList(){
        this.ingredients.map( ingredient => {
            let ind = this.system.ingredients.findIndex( item => item['ingredientid'] == ingredient['id'])

            let ingredientList_item = {}
            ingredientList_item['ingredientid'] = ingredient['id']
            ingredientList_item['name'] = ingredient['name']
            ingredientList_item['purchaseprice'] = ingredient['purchaseprice']
            if(ind != -1){
                ingredientList_item['ingredientselect'] = true
                ingredientList_item['factor'] = this.system.ingredients[ind]['factor']
                ingredientList_item['extra'] = this.system.ingredients[ind]['extra']
            }
            else {
                ingredientList_item['ingredientselect'] = false
            }
            this.ingredientList.push(ingredientList_item)
        })
    },

    saveSystem(){
        let ingredient_system = []
        this.ingredientList.map(ingredient => {
            if(ingredient['ingredientselect'] == true){
                let ingredient_item = {}
                ingredient_item['ingredientid'] = ingredient['ingredientid']
                ingredient_item['factor'] = ingredient['factor']
                ingredient_item['price'] = ingredient['purchaseprice'] * ingredient['factor']
                ingredient_item['extra'] = ingredient['extra']
                ingredient_system.push(ingredient_item)
            }
        })
        this.system.ingredients = ingredient_system

        let valid = this.checkData(this.system)
        if(valid['status'] == 'error') {
            console.log(valid['message'])
            return
        }
        else {

            if(this.systemid == 'new')
            {
                axios.post(api.path('system'), this.system)
                    .then(res => {
                        this.$toast.success('Saved successfully!')
                        this.$router.push({ name: 'systems'})
                    })
                    .catch(err => {
                        this.handleErrors("System data error!")
                    })
            }
            else        {

                axios.put(api.path('system') +'/'+ this.system['id'], this.system)
                    .then(res => {
                        this.$toast.success('Updated successfully!')
                        this.$router.push({ name: 'systems'})
                    })
                    .catch(err => {
                        console.log('Error')

                    })
            }
        }

    },
    deleteSystem(){
        axios.delete(api.path('system') +'/'+ this.system['id'], this.system)
            .then(res => {
                    this.$toast.success('Deleted successfully!')
                    this.$router.push({name:'systems'})
            })
            .catch(err => {
                this.handleErrors("System data error!")
        })

    },
    checkData(data_system){
        let res = { status: 'success', message: ''}
        console.log(data_system['saleprice'])
        if(data_system['name'] == ''){
            res['status'] = 'error'
            res['message'] = 'Input Name'
            return res
        }
        if(!data_system['saleprice']){
            console.log(data_system['saleprice'])
            res['status'] = 'error'
            res['message'] = 'Input Price'
            return res
        }
        if(data_system['ingredients'].length == 0){
            res['status'] = 'error'
            res['message'] = 'Select Ingredients'
            return res
        }
        return res
    }
}

}
</script>
