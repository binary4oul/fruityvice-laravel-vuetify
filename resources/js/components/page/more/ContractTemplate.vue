<template>
<div>
  <v-container fluid>
    <v-text-field label="Name" v-model="name"  class="mt-4"></v-text-field>
    <template f fluid >
      <v-btn block @click="open_logo=!open_logo" v-bind:color="open_logo == true ? 'rgb(236,151,31)' : 'primary'" dark>Logo</v-btn>
      <v-file-input
        :rules="rules"
        accept="image/png, image/jpeg, image/bmp"
        placeholder="Pick a Logo"
        prepend-icon="mdi-camera"
        label="Logo"
        v-if="open_logo"
        class="mx-10 my-4"
      ></v-file-input>
    </template>
    <template f fluid>
      <v-btn block @click="open_note_customer=!open_note_customer" class="my-4"
        v-bind:color="open_note_customer == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Note to Customer</v-btn>
      <v-textarea
        label="Note to Cutomer"
        v-if="open_note_customer"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

    <template f fluid class="my-2">
      <v-btn block @click="open_scope=!open_scope" class="my-4"
        v-bind:color="open_scope == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Scope of work</v-btn>
      <v-textarea
        label="Scope of work"
        v-if="open_scope"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

    <template f fluid class="my-2">
      <v-btn block @click="open_payment=!open_payment" class="my-4"
        v-bind:color="open_payment == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Down payment terms</v-btn>
      <v-textarea
        label="Down payment terms"
        v-if="open_payment"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

    <template f fluid class="my-2">
      <v-btn block @click="open_note=!open_note" class="my-4"
        v-bind:color="open_note == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Note</v-btn>
      <v-textarea
        label="Note"
        v-if="open_note"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

    <template f fluid class="my-2">
      <v-btn block @click="open_conclusion=!open_conclusion" class="my-4"
        v-bind:color="open_conclusion == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Conclusion to customer</v-btn>
      <v-textarea
        label="Conclusion to customer"
        v-if="open_conclusion"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

     <template f fluid class="my-2">
      <v-btn block @click="open_footer=!open_footer" class="my-4"
        v-bind:color="open_footer == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Footer</v-btn>
      <v-textarea
        label="Footer"
        v-if="open_footer"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

  </v-container>
</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
  name: '',
  open_logo: false,
  open_note_customer: false,
  open_scope: false,
  open_condition: false,
  open_payment: false,
  open_note: false,
  open_conclusion: false,
  open_footer: false,
  rules: [
    value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
  ],

  }),

mounted() {
  let data = {'title': 'Contract Templates'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {


}
}
</script>