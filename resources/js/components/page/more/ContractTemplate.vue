<template>
<div>
  <v-container fluid>
    <v-text-field label="Name" v-model="name" class="mt-4"></v-text-field>
    <template f fluid >
      <v-btn block @click="open_logo=!open_logo" v-bind:color="open_logo == true ? 'rgb(236,151,31)' : 'primary'" dark>Logo</v-btn>
      <v-row v-if="open_logo">
        <v-col cols="12" sm="6">
           <v-file-input
              :rules="rules"
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Pick a Logo"
              prepend-icon="mdi-camera"
              label="Logo"
              v-if="open_logo"
              v-model="logo"
              class="mx-4 my-10"
            ></v-file-input>
        </v-col>
        <v-col cols="12" sm="6">
          <v-img
            v-if="logo_url"
            :src="logo_url"
            aspect-ratio="1"
            contain
            class="mx-4 my-2 grey lighten-2" />
        </v-col>
      </v-row>
    </template>
    <template f fluid>
      <v-btn block @click="open_note_customer=!open_note_customer" class="my-4"
        v-bind:color="open_note_customer == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Note to Customer</v-btn>
      <v-textarea
        label="Note to Cutomer"
        v-model="note_customer"
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
        v-model="scope"
        v-if="open_scope"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>

    <template f fluid class="my-2">
      <v-btn block @click="open_condition=!open_condition" class="my-4"
        v-bind:color="open_condition == true ? 'rgb(236,151,31)' : 'primary'" dark>
        Some common conditions to be aware of</v-btn>
      <v-textarea
        label="Some common conditions to be aware of"
        v-model="condition"
        v-if="open_condition"
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
        v-model="payment"
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
        v-model="note"
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
        v-model="cnoclusion"
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
        v-model="footer"
        v-if="open_footer"
        auto-grow
        outlined
        rows="4"
        row-height="15"
      ></v-textarea>
    </template>
    <v-row>
      <v-spacer></v-spacer>
      <v-btn color="green" dark class="mx-2 my-2" @click="saveConTem">Save</v-btn>
      <v-btn color="error" dark class="mx-2 my-2" v-if="id != 'new'" @click="deleteConTem">Delete</v-btn>
      <v-btn class="mx-2 my-2" @click="$router.go(-1)">Cancel</v-btn>
      <v-spacer></v-spacer>
    </v-row>

  </v-container>
</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
  id: 'new',
  name: '',
  logo: null,
  logo_url: '',
  open_logo: false,
  note_customer: '',
  open_note_customer: false,
  scope: '',
  open_scope: false,
  condition: '',
  open_condition: false,
  payment: '',
  open_payment: false,
  note: '',
  open_note: false,
  cnoclusion: '',
  open_conclusion: false,
  footer: '',
  open_footer: false,
  rules: [
    value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
  ],

  }),

mounted() {
  let data = {'title': 'Contract Templates'}
  this.$store.dispatch('title/setTitle', data)
  this.id = this.$route.params.id
  if(this.id != 'new') this.getConTem()
},
methods: {
  saveConTem(){
    const config = {
        headers: { 'content-type': 'multipart/form-data' },
    }
    let formData = new FormData();
    formData.append('name', this.name);
    if(this.logo) formData.append('logo', this.logo);
    formData.append('notetocustomer', this.note_customer);
    formData.append('scopeofwork', this.scope);
    formData.append('commoncondition', this.condition);
    formData.append('downpaymentterms', this.payment);
    formData.append('note', this.note);
    formData.append('conclusion', this.conclusion);
    formData.append('footer', this.footer);

    if(this.id === 'new'){
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.post(api.path('contracttemplate'), formData, config)
          .then(res =>{
            this.logo_url = res.data['logo']
            this.id = res.data['id']
            this.$toast.success('Saved Successfully!')
            this.$router.push({name:'contract_templates'})
          })
          .catch(err => {
            this.$toast.error("User Information Error!")
          })
          .then(res => {
              this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
    else {
      formData.append('_method', 'PUT');
      // formData.append('id', this.id)
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.post(api.path('contracttemplate') +'/'+ this.id, formData, config)
          .then(res =>{
            this.logo_url = res.data['logo']
            this.$toast.success('Updated Successfully!')
            this.$router.push({name:'contract_templates'})
          })
          .catch(err => {
            this.$toast.error("User Information Error!")
          })
          .then(res => {
              this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }

  },
  getConTem(){
     this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('contracttemplate') +'/'+ this.id)
        .then(res =>{
          if(res.data['status'] === 'error') return
          this.id = res.data['id']
          this.name = res.data['name']
          this.logo_url = res.data['logo']
          this.note_customer = res.data['notetocustomer']
          this.scope = res.data['scopeofwork']
          this.condition = res.data['commoncondition']
          this.payment = res.data['downpaymentterms']
          this.note = res.data['note']
          this.conclusion = res.data['conclusion']
          this.footer = res.data['footer']
        })
        .catch(err => {
          this.$toast.error("User Information Error!")
        })
        .then(res => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
  },
  deleteConTem() {
    axios.delete(api.path('contracttemplate') +'/'+ this.id)
        .then(res => {
          this.$toast.success('Deleted successfully!')
          this.$router.push({name:'contract_templates'})
        })
        .catch(err => {
            this.$toast.error("Contract Template data error!")
        })
  },
}
}
</script>