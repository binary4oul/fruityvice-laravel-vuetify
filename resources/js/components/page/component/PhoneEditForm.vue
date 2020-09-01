<template>
    <v-container fluid>
        <template f fluid>
            <v-btn block @click="changeOpenState" color="rgb(236,151,31)" dark>PHONES</v-btn>
        </template>
        <v-spacer></v-spacer>

        <template v-if="open">
            <v-row>
                <v-col cols="12" md="8">
                    <v-text-field label="Phone Number" v-model="phone.number" @input="change"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-select :items="items" label="Phone Type" v-model="phone.type" @input="change"></v-select>
                </v-col>
            </v-row>
        </template>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

data: () => ({
    open: false,
    items: ['Home', 'Office', 'Mobile'],

}),
props: ['phone'],

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    change(){
        let data = {'phone': this.phone}
        this.$store.dispatch('person/setPhone', data)
    }
},

mounted() {
    console.log('mounted')
    setTimeout(() => {
        if(this.phone == null){
            this.phone = {}
            this.phone['number'] =''
            this.phone['type'] =''
        }
        this.change()
    }, 2000)
},
}
</script>