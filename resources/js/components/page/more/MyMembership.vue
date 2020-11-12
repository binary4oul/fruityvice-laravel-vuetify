<template>
<v-container fluid>
  <v-row>
    <v-col cols="12" sm="6">
      <v-card class="mx-5 my-5">
        <v-card-title class="headline card_headline">
          $10 per month
        </v-card-title>

        <v-card-subtitle style="display: flex; justify-content:center">
          - Edit Systems for your Estimates.
          <br/>
          - Upload images for your Estimates.
        </v-card-subtitle>

        <v-card-actions style="display: flex; justify-content:center">
          <v-btn color="orange" text>
            Accept
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>

    <v-col cols="12" sm="6">
      <v-card class="mx-5 my-5">
        <v-card-title class="headline card_headline">
          $20 per month
        </v-card-title>

        <v-card-subtitle style="display: flex; justify-content:center">
          - Create your team and add members.
          <br/>
          - Edit Ingredients for your Systems.
        </v-card-subtitle>

        <v-card-actions style="display: flex; justify-content:center">
          <v-btn color="orange" text>
            Accept
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>

  </v-row>


</v-container>
</template>


<script>
import axios from 'axios'
import { api } from '~/config'
import { mapGetters } from 'vuex'

export default {
data: () => ({
    search: '',
    teamexist: true,
    edit: false,
    edit_team_name: false,
    team: {},
    members: [],
    member_select: {},

    }),

mounted() {
  let data = {'title': 'My Membership'}
  this.$store.dispatch('title/setTitle', data)
},

computed: mapGetters({
    auth: 'auth/user'
}),

methods: {

  saveTeamName(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.put(api.path('team') +'/'+ this.team['id'], this.team)
        .then(res => {
            this.edit_team_name = false
        })
        .then(() => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
  }
},

}
</script>

<style scoped>
  .card_headline {
    color: green;
    text-align: center;
    display: flex;
    justify-content: center;
  }

</style>