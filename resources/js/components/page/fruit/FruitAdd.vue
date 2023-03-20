<template>
  <v-container fluid>
    <v-form @submit.prevent="submit" lazy-validation ref="form">
      <v-row class="align-center justify-center">
        <v-col cols="12" md="5">
          <v-text-field label="genus" v-model="form.genus" :rules="[rules.required]" ></v-text-field>
        </v-col>
        <v-col cols="12" md="5">
          <v-text-field label="Name" v-model="form.name" :rules="[rules.required]"></v-text-field>
        </v-col>
        <v-col cols="12" md="5">
          <v-text-field label="Family" v-model="form.family" :rules="[rules.required]"></v-text-field>
        </v-col>
        <v-col cols="12" md="5">
          <v-text-field label="Order" v-model="form.order" :rules="[rules.required]" ></v-text-field>
        </v-col>
        <v-container fluid>
          <v-row class="align-center justify-center">
            <v-col cols="10">
              <v-label>Nutritions</v-label>
            </v-col>
          </v-row>

          <v-row class="align-center justify-center">
            <v-col cols="12" md="2">
              <v-text-field type="number" v-model="form.nutritions.carbohydrates" label="Carbohydrates" :rules="[rules.numberRule, rules.required]" step="0.1" min="0"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field type="number" v-model="form.nutritions.protein" label="Protein" :rules="[rules.numberRule, rules.required]" step="0.1" min="0"></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field type="number" v-model="form.nutritions.fat" label="Fat" :rules="[rules.numberRule, rules.required]" step="0.1" min="0"></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field type="number" v-model="form.nutritions.calories" :rules="[rules.numberRule, rules.required]" step="0.1" min="0" label="Calories" 
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
              <v-text-field type="number" v-model="form.nutritions.sugar" :rules="[rules.numberRule, rules.required]" step="0.1" min="0" label="Sugar"
                ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-row>
      <v-row>
        <v-spacer></v-spacer>
        <v-btn color="green" dark class="mx-2 my-4" type="submit">Save</v-btn>
        <v-btn class="mx-2 my-4" @click="cancel">Cancel</v-btn>
        <v-spacer></v-spacer>
      </v-row>
    </v-form>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import store from '~/store'
import axios from 'axios'
import { api } from '~/config'

export default {

  computed: mapGetters({
    person: 'person/person',
    address: 'person/address',
    phone: 'person/phone',
    leaddetail: 'leaddetail/leaddetail'
  }),

  data: () => ({
    form: {
      genus: '',
      family: '',
      name: '',
      order: '',
      nutritions: {
        carbohydrates: '0.0',
        protein: '0.0',
        fat: '0.0',
        calories: '0.0',
        sugar: '0.0'
      }
    },
    rules: {
      numberRule: val => {
        if (val < 0) return 'Please enter a positive number'
        return true
      },
      required : value => !!value || 'Required.',
    }
    
  }),

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        axios.post(api.path('fruits'), this.form)
          .then(res => {
            this.$toast.success('Added!')
            this.$emit('success', res.data)
          })
          .catch(err => {
            this.$toast.error("Fruit Information Error!")
          })
          .then(() => {
            this.loading = false
          })
      }
      
    },
    cancel() {
      this.$emit('click-cancel')
    }

  },

}
</script>