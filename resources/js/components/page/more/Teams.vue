<template>
  <v-container fluid>
    <v-row class="d-flex flex-row-reverse">
      <v-col sm="6">
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>

    <v-data-table
      :headers="headers"
      :items="teams"
      :search="search">
      <template v-slot:item="row">
          <tr @click="selectTeam(row.item)">
            <td>{{row.item.name}}</td>
            <td>{{row.item.owner.firstname}} {{row.item.owner.lastname}}</td>
             <td>{{row.item.role}}</td>
            <td>{{row.item.created_at}}</td>
          </tr>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
    search: '',
    teams: [],
    headers: [
        { text: 'Name', value: 'name' },
        { text: 'Leader', value: 'owner' },
        { text: 'Role', value: 'role' },
        { text: 'Created', value: 'owner' },
      ],
    }),

mounted() {
  let data = {'title': 'Teams'}
  this.$store.dispatch('title/setTitle', data)
  this.getTeams()
},

methods: {
  getTeams() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('getTeams'))
      .then(res => {
        this.teams  = res.data

      })
      .catch(err => {

      })
      .then(res => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
  selectTeam(team){
    this.$store.dispatch('auth/setTeamRole', { team_role: team.role })
    this.$router.push({ name: 'teamProject', params:{ teamid: team['id']} })
  },
},

}
</script>