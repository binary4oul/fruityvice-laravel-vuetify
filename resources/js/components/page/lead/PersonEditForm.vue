<template>
        <v-form v-model="valid">
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="form.firstname"
                            @input="change"
                            :rules="nameRules"
                            :counter="20"
                            label="First name"
                            required
                            ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                        v-model="form.lastname"
                        @input="change"
                        :rules="nameRules"
                        :counter="20"
                        label="Last name"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="form.company"
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
components: {

    },

methods: {
    success(data) {

    },
    change(){
        let data = {'person': this.form}
        console.log(data)
        this.$store.dispatch('person/setPerson', data)
    }
},
computed: mapGetters({
    person: 'person/person',
}),

mounted() {
    this.form = Object.assign(this.form, this.person)
},

data: () => ({
    valid: false,
    form: {
        firstname: '',
        lastname: '',
        company:'',
    },
    nameRules: [
      v => !!v || 'Name is required',
      v => v.length <= 20 || 'Name must be less than 20 characters',
    ],
  }),

}
</script>