<template>
        <v-form v-model="valid">
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="person.firstname"
                            @input="change"
                            :rules="nameRules"
                            :counter="20"
                            label="First name"
                            required
                            ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                        v-model="person.lastname"
                        @input="change"
                        :rules="nameRules"
                        :counter="20"
                        label="Last name"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="person.company"
                            @input="change"
                            label="Company"
                            ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-form>

</template>

<script>

import { mapGetters } from 'vuex'

export default {

methods: {
    success(data) {

    },
    change(){
        let data = {'person': this.person}
        this.$store.dispatch('person/setPerson', data)
    }
},
computed: mapGetters({

}),

mounted() {
    setTimeout(() => {
        this.change()
    }, 2000)
},

data: () => ({
    valid: false,
    nameRules: [
      v => !!v || 'Name is required',
      v => v.length <= 20 || 'Name must be less than 20 characters',
    ],
  }),
props: ['person'],

}
</script>