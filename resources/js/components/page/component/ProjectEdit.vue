<template>
  <v-container fluid>
    <template f fluid>
      <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>{{title}}</v-btn>
    </template>

    <template v-if="open">
      <v-btn v-if="project_id!='new'" color="green" dark @click="editNewProjectDetail" class="mx-4 my-4">
        <v-icon dark>add</v-icon>New System
      </v-btn>
      <template v-if="edit_new">
        <v-textarea
            v-if="project_id=='new'"
            label="Note"
            v-model="note"
            auto-grow
            outlined
            rows="2"
            row-height="15"
            class="mt-8"
        ></v-textarea>
        <v-text-field label="Area Name" v-model="name" @change="onDetailChange"></v-text-field>
        <v-row>
          <v-col cols="12" sm="6">
            <p style="text-align:center" >Length (ft.) :
            <vue-numeric-input v-model="arealength" :value="0" :min="0" controls-type="updown" @change="onDetailChange"></vue-numeric-input>
            </p>
          </v-col>
          <v-col cols="12" sm="6">
            <p style="text-align:center">Width (ft.) :
            <vue-numeric-input v-model="areawidth" :value="0" :min="0" controls-type="updown" @change="onDetailChange"></vue-numeric-input>
            </p>
          </v-col>
        </v-row>

        <v-select :items="systems" label="System" v-model="selected_system" item-text="name" @change="onDetailChange"/>
        <v-row v-if="selected_system">
          <v-col cols="12" sm="4">
            <v-icon @click="changeShowIngredients" medium>{{ icon_ingredientList }}</v-icon>
            Coverage: {{ getArea }} sqft
          </v-col>
          <v-col cols="12" sm="3">
            <template v-if="!show_edit_salePrice">
              <v-btn text small exact color="primary" @click="eidtSalePrice" class="text-lowercase">${{ saleprice }} /sqft</v-btn>
            </template>
            <template v-if="show_edit_salePrice">
              <v-row>
                <v-spacer></v-spacer>
                <vue-numeric-input v-model="saleprice" :value="0" @change="onDetailChange" :min="0" controls-type="updown" size="120px"></vue-numeric-input>
                <v-spacer></v-spacer>
                <v-btn color="green" @click="eidtSalePrice" dark small>ok</v-btn>
                <v-spacer></v-spacer>
              </v-row>
            </template>
          </v-col>
          <v-col cols="12" sm="3">
            SystemPrice: ${{ getAreaPrice }}
          </v-col>
        </v-row>
        <project-detail v-if="show_ingredients" :project_detail_styles="project_detail_styles" />

        <v-row v-if="project_id!='new'">
          <v-spacer></v-spacer>
          <v-btn color="green" @click="addProjectDetail" dark class="my-4">Add System</v-btn>
          <v-spacer></v-spacer>
        </v-row>
      </template>
      <v-simple-table v-if="project_details.length > 0" dense>
        <template v-slot:default>
          <tbody>
          <tr v-for="(detail, index) in project_details" :key="index" @click="editProjectDetail(detail)">
            <td>Area Name: {{ detail.name }}</td>
            <td>System: {{ getSystemName(detail.system_id) }}</td>
            <td>Area: {{ detail.area }} sqft</td>
            <td>Price: ${{ detail.areaprice }} </td>
          </tr>
          </tbody>
        </template>
      </v-simple-table>
    </template>
  </v-container>
</template>


<script>
import {Vue, Component} from 'vue-property-decorator'
import { mapGetters } from 'vuex'
import store from '~/store'
import VueNumericInput from 'vue-numeric-input'
import axios from 'axios'
import { api } from '~/config'
import ProjectDetail from './ProjectDetail.vue'

export default {
components: {
  VueNumericInput,
  ProjectDetail,
},

data: () => ({
  title: 'ESTIMATES',
  open: false,
  edit_new: true,
  project_details: [],
  project_detail_styles: [],
  note: '',
  detail_id: 'new',
  name: '',
  areawidth: 0,
  arealength: 0,
  saleprice: 0,
  selected_system: {},
  show_edit_salePrice: false,
  icon_ingredientList: 'add_circle',
  show_ingredients: false,
  systems: []
}),
props: ['project_id'],
mounted() {
  this.getSystems()
  if(this.project_id != 'new') this.getProject()
  else {
    this.title = "SYSTEMS"
    this.editNewProjectDetail()
  }
},
computed: {
  getArea: function() {
    return this.arealength * this.areawidth
  },
  getAreaPrice: function() {
      return this.getArea * this.saleprice
  },
},
methods: {
  changeOpenState() {
    this.open = !this.open
    this.edit_new = this.project_id === 'new' ? true: false
  },
  initEidt() {
    let data = {'project_detail': {} }
    this.$store.dispatch('project/setProjectDetail', data)
    data = {'project_detail_styles': {} }
    this.$store.dispatch('project/setProjectDetailStyles', data)

    this.edit_new = true
    this.show_edit_salePrice = false
    this.icon_ingredientList = 'add_circle'
    this.show_ingredients = false
  },
  editNewProjectDetail() {
    this.initEidt()
    this.detail_id = 'new'
    this.name = ''
    this.areawidth = 0
    this.arealength = 0
    this.saleprice = 0
    this.selected_system = null
    this.project_detail_styles = []
  },
  getSystems(){
    axios.get(api.path('systems'))
        .then(res => {
          this.systems  = res.data
        })
        .catch(err => {
            this.$toast.error("System Data Error!")
        })
  },
  onDetailChange() {
    const system = this.systems.find((item) => ( this.selected_system === item['name'] ))
    if(!system) return
    if(this.saleprice === 0) this.saleprice = system['saleprice']
    const project_detail = {
      system_id: system['id'],
      name: this.name,
      arealength: this.arealength,
      areawidth: this.areawidth,
      area: this.getArea,
      saleprice: this.saleprice,
      areaprice: this.getAreaPrice,
    }
    let data = {'project_detail': project_detail}
    this.$store.dispatch('project/setProjectDetail', data)
  },
  getSystemName(system_id) {
    const system = this.systems.find((item) => ( system_id === item['id'] ))
    if(!system) return ''
    return system['name']
  },
  eidtSalePrice(){
    if(this.show_edit_salePrice) this.show_edit_salePrice = false
    else this.show_edit_salePrice = true
  },
  changeShowIngredients(){

    this.show_ingredients = !this.show_ingredients
    if(this.show_ingredients) this.icon_ingredientList = 'remove_circle'
    else this.icon_ingredientList = 'add_circle'
  },
  getProject(){
    this.$store.dispatch('loader/setLoader', { loader: true })
    axios.get(api.path('project') +'/'+ this.project_id)
        .then(res => {
          this.project_details = res.data['project_details']
        })
        .catch(err => {
          this.$toast.error("Lead Data Error!")
        })
        .then( res => {
          this.$store.dispatch('loader/setLoader', { loader: false })
        })
  },
  addProjectDetail() {
    let project_detail = store.getters['project/projectDetail']
    project_detail['project_id'] = this.project_id
    project_detail['project_detail_styles'] = store.getters['project/projectDetailStyles']
    delete project_detail['no']
    delete project_detail['project']
    if( this.detail_id === 'new') {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.post(api.path('projectdetail'), project_detail)
          .then(res => {
            if(res.data['status']){
              if(res.data.status === 'error') this.$toast.error(res.data.message)
            }
            else {
              this.$toast.success('Saved successfully!')
              this.editNewProjectDetail()
              this.edit_new = false
              this.project_details.push(res.data)
            }
          })
          .catch(err => {
              this.$toast.error("System data error!")
          })
          .then(()=>{
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
    else {
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.put(api.path('projectdetail') +'/'+ this.detail_id, project_detail)
          .then(res => {
            if(res.data['status']){
              if(res.data.status === 'error') this.$toast.error(res.data.message)
            }
            else {
              this.$toast.success('Saved successfully!')
              let detail = res.data
              let index = this.project_details.findIndex(item => item['id'] === detail['id'])
              this.project_details.splice(index, 1, detail);
              this.project_details.map((item, index)=> item['no'] = index + 1 )
              this.editNewProjectDetail()
              this.edit_new = false
            }
          })
          .catch(err => {
              this.$toast.error("System data error!")
          })
          .then(()=>{
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    }
  },
  editProjectDetail(detail) {
    this.initEidt()
    this.detail_id = detail['id']
    this.name = detail['name']
    this.areawidth = detail['areawidth']
    this.arealength = detail['arealength']
    this.saleprice = detail['saleprice']
    this.selected_system = this.getSystemName(detail['system_id'])
    let data = {'project_detail': detail }
    this.$store.dispatch('project/setProjectDetail', data)
    axios.get(api.path('projectdetail') +'/'+ this.detail_id)
        .then(res => {
          this.project_detail_styles = res.data['project_detail_styles']
        })
        .catch(err => {
          this.$toast.error("System data error!")
        })
  }
}
}
</script>
<style>
  #style1.vue-numeric-input.updown .btn {
    background: green !important;
  }
  .v-text-field.v-text-field--solo .v-input__control{
      min-height: 10px;
  }
  .underline_thead {
    border-radius:50px;
  }
</style>