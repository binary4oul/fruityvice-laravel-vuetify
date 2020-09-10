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
                    <vue-numeric-input :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                    </p>
                </v-col>
                <v-col cols="12" sm="6">
                    <p style="text-align:center">Width (ft.) :
                    <vue-numeric-input :value="0" :min="0" controls-type="updown"></vue-numeric-input>
                    </p>
                </v-col>
            </v-row>
            <v-select :items="systems" label="System" v-model="category" item-text="name"/>
            <v-row align="center justify-center">
                <v-btn color="green" @click="changeOpenState" dark>Add System</v-btn>
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
    areaname: '',
    note: '',
    systems: [],
}),

methods: {
    success(data) {

    },
    changeOpenState(){
        this.open = !this.open
    },
    getSystems(){
        axios.get(api.path('systems'))
            .then(res => {
                this.systems  = res.data
            })
            .catch(err => {
                this.handleErrors(err.response.data.errors)
            })
    }
},
created() {
    this.getSystems()
},
}
</script>