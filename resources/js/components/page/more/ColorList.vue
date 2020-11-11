<template>
<div>
  <v-container fluid>

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
                  v-model="color_select.name"
                  label="Name"
                  ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-btn color="green" dark class="mx-2" @click="saveColor">Save</v-btn>
              <v-btn color="error" dark class="mx-2" @click="deleteColor" v-if="color_select['id'] != 'new'">Delete</v-btn>
              <v-btn class="mx-2" @click="edit=false">Cancel</v-btn>
            </v-col>
          <v-spacer></v-spacer>
        </v-row>

        <v-data-table
          :headers="headers"
          :items="colors"
          :search="search"
          @click:row="selectColor"
        ></v-data-table>
  </v-container>
</div>
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
        { text: 'Created_at', value: 'created_at' },

      ],
      colors:[],
      color_select: {}
    }),

mounted() {
  let data = {'title': 'Colors'}
  this.$store.dispatch('title/setTitle', data)
  this.getColors()
},

methods: {
  getColors() {
    axios.get(api.path('colors'))
      .then(res => {
        this.colors  = res.data
        this.colors.map((item, index)=> item['no'] = index + 1 )
      })
      .catch(err => {
        this.$toast.error(err.response.data.errors)
      })
      .then(() => {
        this.loading = false
      })
    },
  saveColor(){
    delete this.color_select['no'];
      if(!this.color_select['name']) return
        if(this.color_select['id'] == 'new'){
            delete this.color_select['id'];
            axios.post(api.path('color'), this.color_select)
              .then(res => {
                if(res.data.status == "success"){
                  let color_new  = res.data
                  color_new['no'] = this.colors.length + 1
                  this.colors.push(color_new)
                  this.edit = false
                  this.$toast.success('Saved successfuly!')
                }
                else{
                  this.$toast.error(res.data['message'])
                }

              })
              .catch(err => {
                  this.$toast.error("color data error!")
              })
        }
        else if(this.color_select.hasOwnProperty('id')){
            axios.put(api.path('color') +'/'+ this.color_select['id'], this.color_select)
            .then(res => {
               if(res.data.status == "success"){
                let color_new  = res.data
                let index = this.colors.findIndex(item => item['id'] == color_new['id'])
                color_new['no'] = index + 1
                this.colors.splice(index, 1, color_new);
                this.colors.map((item, index)=> item['no'] = index + 1 )
                this.edit = false
               }
               else{
                 this.$toast.error(res.data['message'])
               }
            })
            .catch(err => {
                this.$toast.error("color data error!")
            })
        }
  },

  deleteColor(){
      axios.delete(api.path('color') +'/'+ this.color_select['id'], this.color_select)
            .then(res => {
               if(res.data.status == "success"){

                let index = this.colors.findIndex(item => item['id'] == this.color_select['id'])
                this.colors.splice(index, 1);
                this.edit = false
               }
               else{
                 this.$toast.error(res.data['message'])
               }
            })
            .catch(err => {
                this.$toast.error("color data error!")
      })
  },

  selectColor(color){
    this.edit = true
    this.color_select = {...color}
  },

  addNew(){
    this.edit = true
    this.color_select['id'] = 'new'
    this.color_select['name'] = ''
  }
}
}
</script>