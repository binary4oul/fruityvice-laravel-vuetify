<template>
  <v-container fluid>
    <template f fluid>
        <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>Address</v-btn>
    </template>
    <v-spacer></v-spacer>

    <template v-if="open">
      <template v-if="project_id=='new' || edit==true">
        <v-row>
          <v-col cols="12" md="4">
              <v-text-field label="Address 1" v-model="selectedAddress.address1" @input="change"></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
              <v-text-field label="Address 2" v-model="selectedAddress.address2" @input="change"></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-select :items="address_types" label="Type" v-model="selectedAddress.type" @input="change"></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field label="City" v-model="selectedAddress.city" @input="change"></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-select :items="states" label="State" v-model="selectedAddress.state" @input="change"></v-select>
          </v-col>
          <v-col cols="12" md="2">
            <v-text-field label="Zip" v-model="selectedAddress.zip" @input="change"></v-text-field>
          </v-col>
          <v-col cols="12" md="2">
            <v-checkbox
              v-if="edit==true"
              v-model="selectedAddress.primary"
              label="primary"
              color="primary"
              value="true"
              hide-details
            ></v-checkbox>
          </v-col>
        </v-row>
        <v-row v-if="edit==true">
          <v-spacer></v-spacer>
          <v-btn color="green" dark class="mx-2" @click="saveAddress">Save</v-btn>
          <v-btn class="mx-2" @click="edit=false">Cancel</v-btn>
          <v-spacer></v-spacer>
        </v-row>
      </template>
      <template v-if="project_id!='new'">
          <v-btn color="blue" dark @click="addNew" class="mt-4">
              <v-icon dark>add</v-icon>Add New
          </v-btn>
          <v-data-table
              v-if="address.length > 0"
              :headers="headers"
              :items="getAddress"
              @click:row="selectAddress"
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
  address_types: ['Home', 'Office', 'Billing', 'Main'],
  headers: [
    { text: 'Address1', value: 'address1', sortable: false },
    { text: 'Address2', value: 'address2', sortable: false },
    { text: 'Type', value: 'type', sortable: false },
    { text: 'City', value: 'city', sortable: false },
    { text: 'State', value: 'state', sortable: false },
    { text: 'Zip', value: 'zip', sortable: false },
    { text: 'Primary', value: 'primary', sortable: false }
  ],
  edit: false,
  selectedAddress:{},
  states: []
}),
props: ['address', 'project_id'],

computed: {
  getAddress: function () {
    let addresses = this.address
    addresses.map(item=>item['primary'] = item['primary'] == true ? 'true': 'false')
    return addresses
  }
},
mounted() {
  this.getStates()
  this.change()
},

methods: {
  changeOpenState(){
    this.open = !this.open
  },
  change(){
    let data = {'address': this.selectedAddress}
    this.$store.dispatch('person/setAddress', data)
  },
  getStates(){
    axios.get(api.path('states'))
        .then(res => {
            let data = res.data;
            data.map(item => { if(item['countryid'] == 'US') this.states.push(item['state']) })
        })
        .catch(err => {
            this.$toast.error("address data error!")
        })

  },
  selectAddress(address){
    this.edit = true
    this.selectedAddress['id'] = address['id']
    this.selectedAddress['address1'] = address['address1']
    this.selectedAddress['address2'] = address['address2']
    this.selectedAddress['city'] = address['city']
    this.selectedAddress['state'] = address['state']
    this.selectedAddress['zip'] = address['zip']
    this.selectedAddress['type'] = address['type']
    this.selectedAddress['project_id'] = this.project_id
    if(address['primary'] == true) this.selectedAddress['primary'] = 'true'
  },
  addNew(){
    this.edit = true
    this.selectedAddress = this.newAddress()
  },
  newAddress(){
    let new_address = {}
    new_address['project_id'] = this.project_id
    new_address['id'] ='new'
    new_address['address1'] =''
    new_address['address2'] =''
    new_address['city'] =''
    new_address['state'] =''
    new_address['zip'] =''
    new_address['type'] =''
    new_address['primary'] = true
    return new_address
  },
  saveAddress(){
    if(this.selectedAddress['primary'] == 'true') this.selectedAddress['primary'] = 1
    else this.selectedAddress['primary'] = 0
    if(this.selectedAddress['id'] == 'new'){
      delete this.selectedAddress['id'];
      axios.post(api.path('address'), this.selectedAddress)
          .then(res => {
              this.address.push(res.data)
              this.edit = false
          })
          .catch(err => {
              this.$toast.error("address data error!")
          })
    }
    else{
      axios.put(api.path('address') +'/'+ this.selectedAddress['id'], this.selectedAddress)
          .then(res => {
              let index = this.address.findIndex(item => item['id'] == res.data['id'])
              this.address.splice(index, 1, res.data);
              this.edit = false
          })
          .catch(err => {
              this.$toast.error("address data error!")
          })
    }
  }
},

}
</script>