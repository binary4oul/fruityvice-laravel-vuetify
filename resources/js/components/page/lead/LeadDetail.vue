<template>
  <v-container fluid>
    <template f fluid>
      <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>LEAD DETAIL</v-btn>
    </template>
    <v-spacer></v-spacer>

    <template v-if="open && detail != null">
      <v-text-field label="Email" v-model="detail.email"  class="mt-4"></v-text-field>
      <v-textarea
          label="Best time to call"
          v-model="detail.besttimetocall"
          @input="change"
          auto-grow
          outlined
          rows="2"
          row-height="15"
      ></v-textarea>
      <v-textarea
          label="How did you hear about us"
          v-model="detail.hearaboutus"
          @input="change"
          auto-grow
          outlined
          rows="2"
          row-height="15"
      ></v-textarea>
      <v-textarea
          label="How can we help?"
          v-model="detail.howcanwehelp"
          @input="change"
          auto-grow
          outlined
          rows="2"
          row-height="15"
      ></v-textarea>
    </template>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

data: () => ({
    open: false,
    detail: {},
}),
props: ['leaddetail'],

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    change(){
        let data = {'leaddetail': this.detail}
        this.$store.dispatch('leaddetail/setLeaddetail', data)
    }
},

created() {
  setTimeout(() => {
    if(this.leaddetail == null){
        this.detail['email'] =''
        this.detail['besttimetocall'] =''
        this.detail['hearaboutus'] =''
        this.detail['howcanwehelp'] =''
    }
    else this.detail = {...this.leaddetail}
    this.change()
  }, 500)
},
}
</script>