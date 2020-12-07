<template>
<v-container fluid>

  <v-row v-if="!edit_team_name" class="my-16 mx-4">
    <h2>{{team['name']}}</h2>
    <v-spacer></v-spacer>
    <v-btn color="blue" dark @click="edit_team_name = true" small>
      <v-icon dark>edit</v-icon>
    </v-btn>
  </v-row>

  <v-row v-if="edit_team_name" class="my-16 mx-4">
    <v-spacer></v-spacer>
    <v-text-field
        v-model="team['name']"
        label="Team Name"
      ></v-text-field>
    <v-btn color="green" dark class="mx-2" @click="saveTeamName">OK</v-btn>
    <v-spacer></v-spacer>
  </v-row>

  <v-row class="d-flex flex-row-reverse">
    <v-col sm="3" style="align:center">
      <v-btn color="green" dark @click="addNew">
        <v-icon dark>add</v-icon>Add New
      </v-btn>
    </v-col>
    <v-col sm="4">
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-col>
  </v-row>

  <v-row v-if="edit" justify="center">
    <v-col cols="12" sm="4">
      <v-text-field
        v-model="member_select.email"
        label="Email"
      ></v-text-field>
    </v-col>
    <v-col cols="12" md="3">
      <v-select :items="roles" label="Role" v-model="member_select.role" @input="change"></v-select>
    </v-col>
    <v-col cols="12" sm="4" justify="center">
      <v-btn color="green" dark class="mx-1" @click="saveMember">Save</v-btn>
      <v-btn color="error" dark class="mx-1" @click="deleteMember" v-if="member_select['id'] != 'new'">Delete</v-btn>
      <v-btn class="mx-1" @click="edit=false">Cancel</v-btn>
    </v-col>

  </v-row>

  <v-data-table
    :headers="headers"
    :items="members"
    :search="search">
    <template v-slot:item="row">
        <tr @click="selectMember(row.item)">
          <td>{{row.item.name}}</td>
          <td>{{row.item.email}}</td>
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
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Email', value: 'email' },
      { text: 'Role', value: 'role' },
      { text: 'Created', value: 'create_at' },
    ],
    roles: [
      'manager',
      'member'
    ]
    }),

mounted() {
  let data = {'title': 'My Team'}
  this.$store.dispatch('title/setTitle', data)
  this.getMembers()
  this.getTeam()
},

computed: mapGetters({
    auth: 'auth/user'
}),

methods: {
  getMembers() {
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('getMembers'))
      .then(res => {
          if(res.data['status'] == 'success') this.members = res.data['member']
          else this.teamexist = false
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
    },
  selectMember(member){
    this.edit = true
    this.member_select = {...member}
  },
  addNew(){
    this.edit = true
    this.member_select['id'] = 'new'
    this.member_select['email'] = ''
    this.member_select['role'] = 'member'
  },
  saveMember(){
    if(this.member_select['id'] == 'new'){
      delete this.member_select['id'];
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.post(api.path('teamMember'), this.member_select)
          .then(res => {
            if(res.data.status == "success"){
              let member_new  = res.data['member']
              this.members.push(member_new)
              this.edit = false
              this.$toast.success('Saved successfuly!')
            }
            else{
              this.$toast.error("Email does not exist")
            }
          })
          .catch( err => {
            this.$toast.error(err);
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
    else {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.put(api.path('teamMember') +'/'+ this.member_select['id'], this.member_select)
          .then(res => {
            if(res.data.status == "success"){
              let member_new  = res.data['member']
              let index = this.members.findIndex(item => item['id'] == member_new['id'])
              this.members.splice(index, 1, member_new);
              this.edit = false
              this.$toast.success('Saved successfuly!')
            }
            else{
              this.$toast.error(res.data.message)
            }
          })
          .catch( err => {
            this.$toast.error(err);
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }

  },
  deleteMember(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.delete(api.path('teamMember') +'/'+ this.member_select['id'])
        .then(res => {
          if(res.data.status == "success"){

          let index = this.members.findIndex(item => item['id'] == this.member_select['id'])
          this.members.splice(index, 1);
          this.edit = false
          }
          else{
            this.$toast.error(res.data['message'])
          }
        })
        .then(() => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
  },
  getTeam(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('team') )
      .then(res => {
        if(res.data.status == "success"){
          this.team = res.data.team
        }
        else{
          this.team['name'] = this.auth.firstname + ' Team'
          axios.post(api.path('team'), this.team)
            .then(res => {
              this.team = res.data
          })
        }
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
  },
  saveTeamName(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.put(api.path('team') +'/'+ this.team['id'], this.team)
      .then(res => {
          this.edit_team_name = false
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
  },
  change(){

  }
},

}
</script>