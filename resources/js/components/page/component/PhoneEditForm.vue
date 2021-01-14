<template>
  <v-container fluid>
    <template f fluid>
      <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>PHONE</v-btn>
    </template>
    <v-spacer></v-spacer>
      <template v-if="open">
        <template v-if="project_id=='new' || edit==true">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field label="Phone Number" v-model="selectedPhone.number" @input="change"></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
              <v-select :items="items" label="Phone Type" v-model="selectedPhone.type" @input="change"></v-select>
            </v-col>
            <v-col cols="12" md="2">
              <v-checkbox
                  v-if="edit==true"
                  v-model="selectedPhone.primary"
                  label="primary"
                  color="primary"
                  value="true"
                  hide-details
              ></v-checkbox>
            </v-col>
          </v-row>
          <v-row v-if="edit==true">
            <v-spacer></v-spacer>
            <v-btn color="green" dark class="mx-2" @click="savePhone">Save</v-btn>
            <v-btn class="mx-2" @click="edit=false">Cancel</v-btn>
            <v-spacer></v-spacer>
          </v-row>
        </template>
          <template v-if="project_id!='new'">
            <v-btn color="blue" dark @click="addNew" class="mt-4">
              <v-icon dark>add</v-icon>Add New
            </v-btn>
            <v-data-table
              v-if="phone.length > 0"
              :headers="headers"
              :items="getPhone"
              @click:row="selectPhone"
              ></v-data-table>
          </template>
        </template>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'

export default {

data: () => ({
    open: false,
    headers: [
        { text: 'Number', value: 'number', sortable: false },
        { text: 'Type', value: 'type', sortable: false },
        { text: 'Primary', value: 'primary', sortable: false }
      ],
    items: ['Home', 'Office', 'Mobile'],
    edit: false,
    selectedPhone: {}

}),
props: ['phone', 'project_id'],

computed: {
  getPhone: function () {
    let phones = this.phone
    phones.map(item=>item['primary'] = item['primary'] == true ? 'true': 'false')
    return phones
  }
},

mounted(){
  this.change()
},

methods: {
    changeOpenState(){
        this.open = !this.open
    },
    change(){
        let data = {'phone': this.selectedPhone}
        this.$store.dispatch('person/setPhone', data)
    },
    selectPhone(phone){
      this.edit = true
      this.selectedPhone['id'] = phone['id']
      this.selectedPhone['number'] = phone['number']
      this.selectedPhone['type'] = phone['type']
      this.selectedPhone['project_id'] = phone['project_id']
      if(phone['primary'] == true) this.selectedPhone['primary'] = 'true'
    },
    addNew(){
      this.edit = true
      this.selectedPhone = this.newPhone()
    },
    newPhone(){
      let new_phone = {}
      new_phone['project_id'] = this.project_id
      new_phone['id'] ='new'
      new_phone['number'] =''
      new_phone['type'] =''
      new_phone['primary'] = true
      return new_phone
    },

    savePhone(){
      if(this.selectedPhone['primary'] == 'true') this.selectedPhone['primary'] = 1
      else this.selectedPhone['primary'] = 0
      if(this.selectedPhone['id'] == 'new'){
        delete this.selectedPhone['id'];
        axios.post(api.path('phone'), this.selectedPhone)
            .then(res => {
                this.phone.push(res.data)
                this.edit = false
            })
            .catch(err => {
                this.$toast.error("phone data error!")
            })
      }
      else{
        axios.put(api.path('phone') +'/'+ this.selectedPhone['id'], this.selectedPhone)
            .then(res => {
                let index = this.phone.findIndex(item => item['id'] == res.data['id'])
                this.phone.splice(index, 1, res.data);
                this.edit = false
            })
            .catch(err => {
                this.$toast.error("phone data error!")
            })
      }
    }
  },
}
</script>