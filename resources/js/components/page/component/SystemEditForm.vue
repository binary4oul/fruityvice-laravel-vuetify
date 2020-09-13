<template>
    <v-container fluid>
        <template f fluid>
            <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>SYSTEMS</v-btn>
        </template>
        <v-spacer></v-spacer>

        <template v-if="open">
            <v-textarea
                label="Note"
                v-model="note"
                auto-grow
                outlined
                rows="2"
                row-height="15"
                class="mt-8"
            ></v-textarea>
            <v-text-field label="Area Name" v-model="areaname"></v-text-field>
            <v-row>
                <v-col cols="12" sm="6">
                    <p style="text-align:center">Length (ft.) :
                    <vue-numeric-input v-model="length" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                    </p>
                </v-col>
                <v-col cols="12" sm="6">
                    <p style="text-align:center">Width (ft.) :
                    <vue-numeric-input v-model="width" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                    </p>
                </v-col>
            </v-row>

            <v-select :items="systems" label="System" v-model="system_des" item-text="description"/>

            <v-row v-if="getSystemIdx != -1">
                <v-col cols="12" sm="2">
                    <v-icon @click="changeShowIngredients" medium>{{ icon_ingredientList }}</v-icon>
                    Coverage: {{ getArea }} sqft
                </v-col>
                <v-col cols="12" sm="2">
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
                <v-col cols="12" sm="2">
                    SystemPrice: ${{ getAreaPrice }}
                </v-col>
            </v-row>

            <v-simple-table dense v-if="show_ingredients">
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Amount</th>
                        <th class="text-left">Ingredient</th>
                        <th class="text-left">Extra</th>
                        <th class="text-left">Units</th>
                        <th class="text-left">Color</th>
                        <th class="text-left">Pattern</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(ingredient, index) in ingredients" :key="index">
                        <td>{{ ingredient.price }}</td>
                        <td>{{ ingredient.name }}</td>
                        <td>{{ ingredient.extra }}</td>
                        <td>{{ ingredient.factor }}</td>
                        <td>
                            <v-select :items="ingredients[`${index}`].color" item-text="name" solo autowidth hide-details class="py-2"></v-select>
                        </td>
                        <td>
                            <v-select :items="ingredients[`${index}`].pattern" item-text="name" solo autowidth hide-details class="py-2"></v-select>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>

            <v-row>
                <v-spacer></v-spacer>
                <v-btn color="green" @click="changeOpenState" dark class="mt-4">Add System</v-btn>
                <v-spacer></v-spacer>
            </v-row>

        </template>
</v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import VueNumericInput from 'vue-numeric-input'
import axios from 'axios'
import { api } from '~/config'

export default {

components: {
    VueNumericInput,
},

data: () => ({
    open: false,
    show_ingredients: false,
    show_edit_salePrice: false,
    areaname: '',
    note: '',
    icon_ingredientList: 'add_circle',
    ingredients: [],
    systems: [],
    system_des: "",
    width: 0,
    length: 0,
    saleprice: 0,
    ingredient_list:[],
    color_list:[],
    pattern_list:[],
}),
props: ['leadid'],

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    changeShowIngredients(){
        this.show_ingredients = !this.show_ingredients
        if(this.show_ingredients) this.icon_ingredientList = 'remove_circle'
        else this.icon_ingredientList = 'add_circle'
    },
    getData(){
        axios.get(api.path('colors'))
            .then(res => {
                this.color_list = res.data
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
        axios.get(api.path('patterns'))
            .then(res => {
                this.pattern_list  = res.data
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
        axios.get(api.path('ingredients'))
            .then(res => {
                this.ingredient_list  = res.data
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
    },
    getSystems(){
        axios.get(api.path('systems'))
            .then(res => {
                this.systems  = res.data
                this.systems.map((item, ind, arr) => {
                    let des = item['name'] + "  $" + item['saleprice'] + "/sqft"
                    arr[ind]['description'] = des
                })
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
    },
    getIngredients(systemId){
        axios.get(api.path('system') +'/'+ systemId)
            .then(res => {
                this.ingredients = res.data['ingredients']
                this.ingredients.map(ingredient => {
                    let idx = this.ingredient_list.findIndex(item => item['id'] == ingredient['ingredientid'])
                    ingredient['name'] = this.ingredient_list[idx]['name']
                    ingredient['color'] = this.ingredient_list[idx]['color']
                    ingredient['pattern'] = this.ingredient_list[idx]['pattern']
                })
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
    },
    eidtSalePrice(){
        if(this.show_edit_salePrice) this.show_edit_salePrice = false
        else this.show_edit_salePrice = true
    }
},

created() {
    this.getSystems()
    this.getData()
},

computed:{
    getSystemIdx: function(){
        let idx = this.systems.findIndex(item => item['description'] == this.system_des)
        if(idx != -1 ) {
            this.saleprice = this.systems[idx]['saleprice']
            this.getIngredients(this.systems[idx]['id'])
        }
        return idx
    },
    getArea: function(){
        return this.length * this.width
    },
    getAreaPrice: function(){
        return this.getArea * this.saleprice
    },

},

}
</script>
<style>
    #style1.vue-numeric-input.updown .btn {
      background: green !important;
    }
    .v-text-field.v-text-field--solo .v-input__control{
        min-height: 10px;
    }

</style>