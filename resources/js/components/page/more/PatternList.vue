<template>
<v-container fluid>

      <v-spacer></v-spacer>
      <v-row class="d-flex flex-row-reverse">
        <v-col sm="3" style="align:center">
          <v-btn color="green" dark @click="addNew">
            <v-icon dark>add</v-icon>Add New
          </v-btn>
        </v-col>
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

        <v-row v-if="edit">
          <v-spacer></v-spacer>
            <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pattern_select.name"
                  label="Name"
                  ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-btn color="green" dark class="mx-2" @click="savePattern">Save</v-btn>
              <v-btn color="error" dark class="mx-2" @click="deletePattern" v-if="pattern_select['id'] != 'new'">Delete</v-btn>
              <v-btn class="mx-2" @click="edit=false">Cancel</v-btn>
            </v-col>
          <v-spacer></v-spacer>
        </v-row>

        <v-data-table
          :headers="headers"
          :items="patterns"
          :search="search"
          @click:row="selectPattern"
        ></v-data-table>
</v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'

export default {
data: () => ({
      search: '',
      edit: false,
      headers: [
        { text: 'No', value: 'no' },
        { text: 'Name', value: 'name' },
        { text: 'Created_at', value: 'created_at' }
      ],
      patterns:[],
      pattern_select: {}
    }),

mounted() {
  this.getPatterns()
  let data = {'title': 'Patterns'}
  this.$store.dispatch('title/setTitle', data)
},

methods: {
  getPatterns() {
    axios.get(api.path('patterns'))
      .then(res => {
        this.patterns  = res.data
        this.patterns.map((item, index)=> item['no'] = index + 1 )
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  savePattern(){
    delete this.pattern_select['no'];
    if(!this.pattern_select['name']) return
        if(this.pattern_select['id'] == 'new'){
              delete this.pattern_select['id'];
              axios.post(api.path('pattern'), this.pattern_select)
              .then(res => {
                if(res.data.status == "success"){
                  let pattern_new  = res.data
                  pattern_new['no'] = this.patterns.length + 1
                  this.patterns.push(pattern_new)
                  this.edit = false
                  this.$toast.success('Saved successfuly!')
                }
                else{
                  this.$toast.error(res.data['message'])
                }

              })
              .catch(err => {
                  this.$toast.error("pattern data error!")
              })
        }
        else if(this.pattern_select.hasOwnProperty('id')){
            axios.put(api.path('pattern') +'/'+ this.pattern_select['id'], this.pattern_select)
            .then(res => {
               if(res.data.status == "success"){
                let pattern_new  = res.data
                let index = this.patterns.findIndex(item => item['id'] == pattern_new['id'])
                pattern_new['no'] = index + 1
                this.patterns.splice(index, 1, pattern_new);
                this.patterns.map((item, index)=> item['no'] = index + 1 )
                this.edit = false
               }
               else{
                 this.$toast.error(res.data['message'])
               }
            })
            .catch(err => {
                this.$toast.error("pattern data error!")
            })
        }
  },

  deletePattern(){
      axios.delete(api.path('pattern') +'/'+ this.pattern_select['id'], this.pattern_select)
            .then(res => {
               if(res.data.status == "success"){

                let index = this.patterns.findIndex(item => item['id'] == this.pattern_select['id'])
                this.patterns.splice(index, 1);
                this.edit = false
               }
               else{
                 this.$toast.error(res.data['message'])
               }
            })
            .catch(err => {
                this.$toast.error("pattern data error!")
      })
  },

  selectPattern(pattern){
    this.edit = true
    this.pattern_select = {...pattern}
  },

  addNew(){
    this.edit = true
    this.pattern_select['id'] = 'new'
    this.pattern_select['name'] = ''
  }
}
}
</script>