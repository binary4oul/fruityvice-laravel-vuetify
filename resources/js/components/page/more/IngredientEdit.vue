<template>
<v-container fluid>
        <v-text-field label="Name" v-model="ingredient.name"></v-text-field>
        <v-row>
            <v-col cols="12" sm="6">
                <p style="text-align:center">Coverage Area (sq/ft) :
                    <vue-numeric-input v-model="ingredient.coverage" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                </p>
            </v-col>
            <v-col cols="12" sm="6">
                <p style="text-align:center">Purchase Price :
                    <vue-numeric-input v-model="ingredient.purchaseprice" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                </p>
            </v-col>
        </v-row>
        <v-select
            v-model="ingredient.color"
            :items="colorNames"
            label="Color"
            multiple
            chips
            persistent-hint
          ></v-select>
        <v-select
            v-model="ingredient.pattern"
            :items="patternNames"
            label="Pattern"
            multiple
            chips
            persistent-hint
        ></v-select>
        <v-row style="align:center">
                <v-spacer></v-spacer>
                <v-btn color="green" dark class="mx-2 my-2" @click="saveIngredient">Save</v-btn>
                <v-btn color="error" dark class="mx-2 my-2" v-if="ingredientid != 'new'" @click="deleteIngredient">Delete</v-btn>
                <v-btn class="mx-2 my-2" @click="$router.push({name:'ingredients'})">Cancel</v-btn>
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
    this.ingredientid = this.$route.params.ingredientid
    this.getColors()
    let data = {'title': 'Edit Ingredient'}
    this.$store.dispatch('title/setTitle', data)
},

data: () => ({
    ingredient: {},
    colors: [],
    colorNames: [],
    patterns: [],
    patternNames: []
}),

methods: {
    getColors(){
        axios.get(api.path('colors'))
            .then(res => {
                this.colors = res.data
                this.colors.map( item => this.colorNames.push(item['name']) )
                this.getPatterns()
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
    },
    getPatterns(){
        axios.get(api.path('patterns'))
            .then(res => {
                this.patterns = res.data
                this.patterns.map( item => this.patternNames.push(item['name']) )

                if(this.ingredientid != 'new') this.getIngredient(this.ingredientid)
                else {
                    this.ingredient.color = []
                    this.ingredient.pattern = []
                }

            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })

    },
    getIngredient(ingredientid) {
        axios.get(api.path('ingredient') +"/"+ ingredientid)
            .then(res => {
                this.ingredient  = res.data
                this.ingredient.color.map((item_color, ind, arr) => {
                    let index = this.colors.findIndex(item => item['id'] == item_color['colorid'])
                    arr[ind] = this.colors[index]['name']
                })
                this.ingredient.pattern.map((item_pattern, ind, arr) => {
                    let index = this.patterns.findIndex(item => item['id'] == item_pattern['patternid'])
                    arr[ind] = this.patterns[index]['name']
                })
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
            .then(() => {
                this.loading = false
        })
    },
    saveIngredient(){
        this.ingredient.color.map((item_color, ind, arr) => {
            let index = this.colors.findIndex(item => item['name'] == item_color)
            arr[ind] = this.colors[index]['id']
        })
        this.ingredient.pattern.map((item_pattern, ind, arr) => {
            let index = this.patterns.findIndex(item => item['name'] == item_pattern)
            arr[ind] = this.patterns[index]['id']
        })

        if(!this.ingredient['name']) return
        if(!this.ingredient['coverage']) return
        if(!this.ingredient['purchaseprice']) return

        if(this.ingredientid == 'new')
        {
            axios.post(api.path('ingredient'), this.ingredient)
                .then(res => {
                    this.$toast.success('Saved successfully!')
                    this.$router.push({name:'ingredients'})
                })
                .catch(err => {
                    this.handleErrors("Ingredient data error!")
                })
        }
        else
        {
            this.$router.push({name:'ingredients'})
            axios.put(api.path('ingredient') +'/'+ this.ingredient['id'], this.ingredient)
                .then(res => {
                    this.$toast.success('Updated successfully!')

                })
                .catch(err => {
                    this.handleErrors("Ingredient data error!")
                })
        }

    },
    deleteIngredient(){
        axios.delete(api.path('ingredient') +'/'+ this.ingredient['id'], this.ingredient)
            .then(res => {
                    this.$toast.success('Deleted successfully!')
                    this.$router.push({name:'ingredients'})
            })
            .catch(err => {
                this.handleErrors("Ingredient data error!")
        })

    },
}

}
</script>