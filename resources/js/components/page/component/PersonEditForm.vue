<template>
    <v-container fluid>
        <v-row v-if="!edit">
            <v-col cols="12" sm="4">
                {{ personValue.firstname }} {{ personValue.lastname }}
            </v-col>
            <v-col cols="12" sm="4">
                {{ personValue.company }}
            </v-col>
            <v-col cols="12" sm="4">
                <v-spacer></v-spacer>
                <v-btn color="blue" dark @click="edit = true">
                    <v-icon dark>edit</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-form v-model="valid" v-if="edit">
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="personValue.firstname"
                            @input="change"
                            :rules="nameRules"
                            :counter="20"
                            label="First name"
                            required
                            ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                        v-model="personValue.lastname"
                        @input="change"
                        :rules="nameRules"
                        :counter="20"
                        label="Last name"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="personValue.company"
                            @input="change"
                            label="Company"
                            ></v-text-field>
                    </v-col>
                </v-row>
                <v-row v-if="leadid != 'new'">
                    <v-spacer></v-spacer>
                    <v-btn color="blue" dark @click="updatePerson">
                        OK
                    </v-btn>
                </v-row>
            </v-container>
        </v-form>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'

export default {

methods: {
    success(data) {

    },
    change(){
        let data = {'person': this.personValue}
        this.$store.dispatch('person/setPerson', data)
    },
    updatePerson(){
         axios.put(api.path('person') +'/'+ this.personValue['id'], this.personValue)
            .then(res => {
                this.edit = false
            })
            .catch(err => {
                this.handleErrors("lead data error!")
            })
    },
},
computed: mapGetters({

}),

created() {
    setTimeout(() => {
        if(this.person == null){
            this.personValue['firstname'] = ''
            this.personValue['lastname'] = ''
            this.personValue['company'] = ''
        }
        else this.personValue = {...this.person}
        if(this.leadid == 'new') this.edit = true
    }, 1000)
},

data: () => ({
    edit: false,
    valid: false,
    personValue: {},
    nameRules: [
      v => !!v || 'Name is required',
      v => v.length <= 20 || 'Name must be less than 20 characters',
    ],
  }),
props: ['leadid', 'person'],

}
</script>