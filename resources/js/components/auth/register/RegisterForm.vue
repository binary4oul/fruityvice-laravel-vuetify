<template>
  <v-form ref="form" @submit.prevent="submit" lazy-validation v-model="valid">
    <v-text-field
      :label="labels.firstname"
      v-model="form.firstname"
      :error-messages="errors.firstname"
      :rules="[rules.required('firstname')]"
      :disabled="loading"
      @input="clearErrors('firstname')"
    ></v-text-field>

    <v-text-field
      :label="labels.lastname"
      v-model="form.lastname"
      :error-messages="errors.lastname"
      :rules="[rules.required('lastname')]"
      :disabled="loading"
      @input="clearErrors('lastname')"
    ></v-text-field>

    <v-text-field
      :label="labels.email"
      v-model="form.email"
      type="email"
      :error-messages="errors.email"
      :rules="[rules.required('email')]"
      :disabled="loading"
      @input="clearErrors('email')"
    ></v-text-field>

    <v-text-field
      :label="labels.password"
      v-model="form.password"
      :append-icon="passwordHidden ? 'visibility_off' : 'visibility'"
      @click:append="() => (passwordHidden = !passwordHidden)"
      :type="passwordHidden ? 'password' : 'text'"
      :error-messages="errors.password"
      :disabled="loading"
      :rules="[rules.required('password')]"
      hint="At least 6 characters"
      @input="clearErrors('password')"
    ></v-text-field>

    <v-text-field
      :label="labels.password_confirmation"
      v-model="form.password_confirmation"
      :type="passwordHidden ? 'password' : 'text'"
      :error-messages="errors.password_confirmation"
      :disabled="loading"
      :rules="[rules.required('password_confirmation')]"
      @input="clearErrors('password')"
    ></v-text-field>

    <v-layout row class="mt-4 mx-0">
      <v-spacer></v-spacer>

      <v-btn
        text
        :disabled="loading"
        :to="{ name: 'login' }"
        color="grey darken-2"
        exact
      >
        Back to login
      </v-btn>

      <v-btn
        type="submit"
        :loading="loading"
        :disabled="loading || !valid"
        color="primary"
        class="ml-4"
      >
        Register
      </v-btn>
    </v-layout>
  </v-form>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import Form from '~/mixins/form'

export default {
  mixins: [Form],

  data: () => ({
    passwordHidden: true,

    form: {
      firstname: null,
      lastname:null,
      email: null,
      password: null,
      password_confirmation: null
    }
  }),

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        this.loading = true
        axios.post(api.path('register'), this.form)
          .then(res => {
            this.$toast.success('You have been successfully registered!')
            this.$emit('success', res.data)
          })
          .catch(err => {
            this.$toast.error("User Information Error!")
          })
          .then(() => {
            this.loading = false
          })
      }
    },
  }
}
</script>
