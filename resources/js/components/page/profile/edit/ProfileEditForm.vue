<template>
  <v-form ref="form" @submit.prevent="submit" lazy-validation v-model="valid">
    <v-card>
      <v-card-text>
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
      </v-card-text>
    </v-card>

    <h3 class="headline mb-4 mt-12">Password</h3>

    <v-card>
      <v-card-text>
        <v-text-field
          :label="labels.password"
          v-model="form.password"
          :append-icon="passwordHidden ? 'visibility_off' : 'visibility'"
          @click:append="() => (passwordHidden = !passwordHidden)"
          :type="passwordHidden ? 'password' : 'text'"
          :error-messages="errors.password"
          :disabled="loading"
          hint="At least 6 characters"
          autocomplete="new-password"
          @input="clearErrors('password')"
        ></v-text-field>

        <v-text-field
          :label="labels.password_confirmation"
          v-model="form.password_confirmation"
          :type="passwordHidden ? 'password' : 'text'"
          :error-messages="errors.password_confirmation"
          :disabled="loading"
          autocomplete="new-password"
          @input="clearErrors('password')"
        ></v-text-field>
      </v-card-text>
    </v-card>

    <v-layout my-8 mx-0>
      <v-spacer></v-spacer>

      <v-btn
        text
        :disabled="loading"
        :to="{ name: 'profile' }"
        color="grey darken-2"
        exact
      >
        Cancel
      </v-btn>

      <v-btn
        type="submit"
        :loading="loading"
        :disabled="loading"
        color="primary"
        class="ml-4"
      >
        Save
      </v-btn>
    </v-layout>
  </v-form>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import { api } from '~/config'
import Form from '~/mixins/form'

export default {
  mixins: [Form],

  data: () => ({
    passwordHidden: true,

    label: {
      password: 'New Password',
      password_confirmation: 'Confirm New Password',
    },

    form: {
      firstname: null,
      lastname: null,
      email: null,
      password: null,
      password_confirmation: null,
    }
  }),

  computed: mapGetters({
    auth: 'auth/user'
  }),

  mounted() {
    this.form = Object.assign(this.form, this.auth)
  },

  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        this.loading = true
        axios.put(api.path('profile'), this.form)
          .then(res => {
            this.$toast.success('Your profile successfully updated.')
            this.$emit('success', res.data)
          })
          .catch(err => {
            this.handleErrors("Data Error!")
          })
          .then(() => {
            this.loading = false
          })
      }
    }
  }
}
</script>
