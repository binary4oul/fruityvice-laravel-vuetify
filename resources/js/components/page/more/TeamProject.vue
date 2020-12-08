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
          :items="projects"
          :search="search">
          <template v-slot:item="row">
              <tr @click="selectEstimate(row.item)">
                <td>{{row.item.person.firstname}} {{row.item.person.lastname}}</td>
                <td>{{row.item.person.company}}</td>
                <td>{{row.item.projectstatus}}</td>
                <td>{{row.item.created_at}}</td>
              </tr>
          </template>
        </v-data-table>

      <v-row>
        <v-spacer></v-spacer>
        <v-btn class="mx-2 my-2" @click="$router.go(-1)">Cancel</v-btn>
      </v-row>
    </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
  search: '',
  headers: [
    { text: 'Customer', value: 'person.firstname' },
    { text: 'Company', value: 'person.company' },
    { text: 'Status', value: 'projectstatus'},
    { text: 'Create_at', value: 'created_at' },
  ],
  projects:[]
}),

mounted() {
  let data = {'title': 'Team Projects'}
  this.$store.dispatch('title/setTitle', data)
    this.teamid = this.$route.params.teamid
    this.getProjects()
},

methods: {
  getProjects() {
    axios.get(api.path('getTeamProject') +'/'+ this.teamid)
      .then(res => {
        this.projects  = res.data
      })
    },
  selectEstimate(estimate){
    this.$router.push({ name: 'project-edit',  params:{ projectid: estimate['id']}  })
  },
},
created() {
    this.status = this.$route.params.status
    this.active = this.$route.params.active
}
}
</script>