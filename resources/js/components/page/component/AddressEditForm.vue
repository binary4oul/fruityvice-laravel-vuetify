<template>
    <v-container fluid>
        <template f fluid>
            <v-btn block @click="changeOpenState" color="rgb(236,151,31)" dark>Address</v-btn>
        </template>
        <v-spacer></v-spacer>

        <template v-if="open">
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field label="Address 1" v-model="address.address1" @input="change"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Address 2" v-model="address.address2" @input="change"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                     <v-select :items="items" label="Type" v-model="address.type" @input="change"></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field label="City" v-model="address.city" @input="change"></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-select :items="items" label="State" v-model="address.state" @input="change"></v-select>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field label="Zip" v-model="address.zip" @input="change"></v-text-field>
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
    items: ['Home', 'Office', 'Billing', 'Main'],

}),
props: ['address'],

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    change(){
        let data = {'address': this.address}
        this.$store.dispatch('person/setAddress', data)
    }
},

mounted() {
    console.log('mounted')
    setTimeout(() => {
        if(this.address == null){
            this.address = {}
            this.address['address1'] =''
            this.address['address2'] =''
            this.address['city'] =''
            this.address['state'] =''
            this.address['zip'] =''
            this.address['type'] =''
        }
        this.change()
    }, 2000)
},
}
</script>