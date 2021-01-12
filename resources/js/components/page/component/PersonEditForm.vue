<template>
  <v-container fluid>
    <template v-if="!edit">
      <v-row>
        <p class="mx-12">
          <font style="font-size:samller; color:grey">Full Name<br /></font>
          <font style="font-size:large">&nbsp;&nbsp;{{ personValue.firstname }} {{ personValue.lastname }}</font>
        </p>
      </v-row>
      <v-row>
        <p class="mx-12">
          <font style="font-size:samller; color:grey">Company<br /></font>
          <font style="font-size:large">&nbsp;&nbsp;{{ personValue.company }}</font>
        </p>
        <v-spacer></v-spacer>
        <v-btn color="blue" dark @click="edit = true" small class="mx-8">
            <v-icon dark>edit</v-icon>
        </v-btn>
      </v-row>
    </template>
    <v-form v-model="valid" v-if="edit">
      <v-container>
        <v-row>
          <v-col cols="12" md="3">
            <v-text-field
              v-model="personValue.firstname"
              @input="change"
              :rules="nameRules"
              :counter="20"
              label="First name"
              required
              ></v-text-field>
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field
              v-model="personValue.lastname"
              @input="change"
              :rules="nameRules"
              :counter="20"
              label="Last name"
              required
              ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
                v-model="personValue.company"
                @input="change"
                label="Company"
                ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="project_id != 'new'">
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
  data: () => ({
  edit: false,
  valid: false,
  personValue: {},
  nameRules: [
    v => !!v || 'Name is required',
    v => v.length <= 20 || 'Name must be less than 20 characters',
  ],
  }),
  props: ['project_id', 'person'],

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
          this.$toast.error("lead data error!")
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
    if(this.project_id == 'new') this.edit = true
  }, 500)
},
}
</script>
<style scoped>

</style>