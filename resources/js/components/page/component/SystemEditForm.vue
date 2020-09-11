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
                    <v-icon @click="showIngredientLsit" medium>{{ icon_ingredientList }}</v-icon>
                    Coverage: {{ getArea }} sqft
                </v-col>
                <v-col cols="12" sm="1">
                    <a href="">${{ systems[this.getSystemIdx]['saleprice'] }} /sqft</a>
                </v-col>
                <v-col cols="12" sm="2">
                    SystemPrice: ${{ getAreaPrice }}
                </v-col>
            </v-row>

            <v-row>
                <v-spacer></v-spacer>
                <v-btn color="green" @click="changeOpenState" dark>Add System</v-btn>
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
    show_edit_salePrice: false,
    areaname: '',
    note: '',
    icon_ingredientList: 'add_circle',
    systems: [],
    project: {},
    system_des: "",
    width: 0,
    length: 0,
    saleprice: 0

}),
props: ['leadid'],

methods: {
    changeOpenState(){
        this.open = !this.open
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
    showIngredientLsit()
    {
    },
    eidtSalePrice(){



    }
},

created() {
    this.getSystems()
},

computed:{
    getSystemIdx: function(){
        return this.systems.findIndex(item => item['description'] == this.system_des)
    },
    getArea: function(){
        return this.length * this.width
    },
    getAreaPrice: function(){
        return this.getArea * this.systems[this.getSystemIdx]['saleprice']
    },
    getSalePrice: function(){
        return this.systems[this.getSystemIdx]['saleprice']
    }

},

}
</script>