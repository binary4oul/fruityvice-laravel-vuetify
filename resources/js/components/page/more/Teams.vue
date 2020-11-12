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
    axios.get(api.path('getTeams'))
      .then(res => {
        this.teams  = res.data

      })
      .catch(err => {

      })
    },
  selectTeam(team){
    this.$router.push({ name: 'teamProject', params:{ teamid: team['id']} })
  },
},

}
</script>