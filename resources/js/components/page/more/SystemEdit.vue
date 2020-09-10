<template>
<v-card>
    <v-card-title>
        Edit System
    </v-card-title>
    <v-card-text>
        <v-text-field label="Name" v-model="system.name"></v-text-field>
        <v-row>
            <v-col cols="12" sm="3">
                <v-checkbox v-model="this.system['active']" label="Active">Acive</v-checkbox>
            </v-col>
            <v-col cols="12" sm="3">
                <v-checkbox v-model="this.system['share']" label="Share">Share</v-checkbox>
            </v-col>
            <v-col cols="12" sm="6">
                System Price / sq ft :
                <vue-numeric-input v-model="system.saleprice" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
            </v-col>
        </v-row>
        <v-row>

        </v-row>
        <v-row>
            <v-spacer></v-spacer>
            <v-btn color="green" dark class="mx-2 my-2" @click="saveSystem">Save</v-btn>
            <v-btn color="error" dark class="mx-2 my-2" v-if="systemid != 'new'" @click="deleteSystem">Delete</v-btn>
            <v-btn class="mx-2 my-2" @click="$router.push({name:'systems'})">Cancel</v-btn>
            <v-spacer></v-spacer>
        </v-row>
    </v-card-text>
</v-card>
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
    this.getIngredients()
    if(this.systemid != 'new') this.getSystem(this.systemid)
    else this.system.ingredients = []
    this.setIngredientList()
},

data: () => ({
    system: {},
    ingredients: [],
    ingredientList: [],

}),

methods: {
    getIngredients(){
        axios.get(api.path('colors'))
            .then(res => {
                this.ingredients = res.data

            })
            .catch(err => {
                 this.handleErrors("Ingredient data error!")
            })
    },

    getSystem(systemid) {
        axios.get(api.path('system') +"/"+ systemid)
            .then(res => {
                this.system  = res.data

            })
            .catch(err => {
                this.handleErrors("System data error!")
            })
            .then(() => {
                this.loading = false
        })
    },

    setIngredientList(){
        this.ingredients.map( ingredient => {
            let ind = this.system.ingredients.findIndex( item => item['ingredientid'] == ingredient['id'])
            let ingredientList_item = {}
            ingredientList_item['ingredientid'] = ingredient['id']
            ingredientList_item['name'] = ingredient['name']
            ingredientList_item['purchageprice'] = ingredient['purchageprice']
            if(ind != -1){
                ingredientList_item['ingredientselect'] = true
                ingredientList_item['unit'] = this.system.ingredientspp[ind]['factor']
                ingredientList_item['extra'] = this.system.ingredients[ind]['extra']
            }
            else {
                ingredientList_item['ingredientselect'] = false
            }
            this.ingredientList.push(ingredientList_item)
        })

    },

    saveSystem(){
        this.system.color.map((item_color, ind, arr) => {
            let index = this.colors.findIndex(item => item['name'] == item_color)
            arr[ind] = this.colors[index]['id']
        })
        this.system.pattern.map((item_pattern, ind, arr) => {
            let index = this.patterns.findIndex(item => item['name'] == item_pattern)
            arr[ind] = this.patterns[index]['id']
        })

        if(this.systemid == 'new')
        {
            axios.post(api.path('system'), this.system)
                .then(res => {
                     this.$toast.success('Saved successfully!')
                })
                .catch(err => {
                    this.handleErrors("System data error!")
                })
        }
        else
        {
            axios.put(api.path('system') +'/'+ this.system['id'], this.system)
                .then(res => {
                    this.$toast.success('Updated successfully!')
                })
                .catch(err => {
                    this.handleErrors("System data error!")
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
                this.handleErrors("System data error!")
        })

    },
}

}
</script>