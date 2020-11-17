<template>
  <v-container fluid>
    <template f fluid>
      <v-btn block @click="changeOpenState" v-bind:color="open == true ? 'rgb(236,151,31)' : 'primary'" dark>{{title}}</v-btn>
    </template>
    <v-spacer></v-spacer>

    <template v-if="open">
      <v-btn color="green" dark @click="editNewProjectDetail" class="mx-4 my-4">
        <v-icon dark>add</v-icon>New System
      </v-btn>

      <template v-if="edit_new">
        <v-textarea
            v-if="leadid=='new'"
            label="Note"
            v-model="note"
            auto-grow
            outlined
            rows="2"
            row-height="15"
            class="mt-8"
        ></v-textarea>
        <v-text-field label="Area Name" v-model="areaname"></v-text-field>
        <v-row>
          <v-col cols="12" sm="6">
            <p style="text-align:center">Length (ft.) :
            <vue-numeric-input v-model="length" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
            </p>
          </v-col>
          <v-col cols="12" sm="6">
            <p style="text-align:center">Width (ft.) :
            <vue-numeric-input v-model="width" :value="0" :min="0" controls-type="updown"></vue-numeric-input>
            </p>
          </v-col>
        </v-row>

        <v-select :items="systems" label="System" v-model="system_des" item-text="description"/>

        <v-row v-if="getSystemIdx != -1">
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
                <vue-numeric-input v-model="saleprice" :value="0" :min="0" controls-type="updown" size="120px"></vue-numeric-input>
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

        <v-simple-table dense v-if="show_ingredients">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left clickable" @click="show_ingredientPrice=!show_ingredientPrice">Amount</th>
                <th class="text-left" v-if="show_ingredientPrice">Price</th>
                <th class="text-left">Ingredient</th>
                <th class="text-left">Extra</th>
                <th class="text-left">Units</th>
                <th class="text-left">Color</th>
                <th class="text-left">Pattern</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ingredient, index) in ingredients" :key="index">
                <td>{{ getAmount(index) }}</td>
                <td v-if="show_ingredientPrice">{{ getIngredientPrice(index) }}</td>
                <td>{{ ingredient.name }}</td>
                <td>{{ ingredient.extra }}</td>
                <td>{{ ingredient.factor }}</td>
                <td v-if="ingredients[`${index}`].color != null">
                  <v-select :items="ingredients[`${index}`].color" v-model="ingredients[`${index}`].colorid" item-text="name" solo single-line autowidth hide-details class="py-2"></v-select>
                </td>
                <td v-if="ingredients[`${index}`].color == null">No Colors</td>
                <td v-if="ingredients[`${index}`].pattern != null">
                  <v-select :items="ingredients[`${index}`].pattern" v-model="ingredients[`${index}`].patternid" item-text="name" solo single-line autowidth hide-details class="py-2"></v-select>
                </td>
                <td v-if="ingredients[`${index}`].pattern == null">No Patterns</td>
              </tr>
              <tr v-if="show_ingredientPrice">
                <td>Ingredient Cost</td>
                <td>{{ ingredients.reduce( (prev, item, ind)=>(prev+parseFloat(getIngredientPrice(ind))), 0) }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <v-row>
          <v-spacer></v-spacer>
          <v-btn color="green" @click="addProject" dark class="my-4">Add System</v-btn>
          <v-spacer></v-spacer>
        </v-row>

      </template>

      <v-simple-table dense>
        <template v-slot:default>
          <tbody>
          <tr v-for="(detail, index) in project.projectdetails" :key="index" @click="editProjectDetail(detail)">
            <td>Area Name: {{ detail.name }}</td>
            <td>System: {{ detail.system}}</td>
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
import VueNumericInput from 'vue-numeric-input'
import axios from 'axios'
import { api } from '~/config'

export default {
components: {
    VueNumericInput,

},

data: () => ({
    title: 'ESTIMATES',
    open: false,
    edit_new: true,
    show_ingredients: false,
    show_edit_salePrice: false,
    show_ingredientPrice: false,
    id: '',
    projectid: '',
    areaname: '',
    note: '',
    icon_ingredientList: 'add_circle',
    ingredients: [],
    systems: [],
    system_des: "",
    width: 0,
    length: 0,
    saleprice: 0,
    ingredient_list:[],
    color_list:[],
    pattern_list:[],
    project:{ projectdetails:[] }
}),
props: ['leadid'],

methods: {
    changeOpenState(){
        this.open = !this.open
        this.edit_new = false
    },
    changeShowIngredients(){
        this.show_ingredients = !this.show_ingredients
        if(this.show_ingredients) this.icon_ingredientList = 'remove_circle'
        else this.icon_ingredientList = 'add_circle'
    },
    getData(){
        axios.get(api.path('colors'))
            .then(res => {
                this.color_list = res.data
            })
            .catch(err => {
                this.$toast.error("Color Data Error!")
            })
        axios.get(api.path('patterns'))
            .then(res => {
                this.pattern_list  = res.data
            })
            .catch(err => {
                this.$toast.error("Pattern Data Error!")
            })
        axios.get(api.path('ingredients'))
            .then(res => {
                this.ingredient_list  = res.data
            })
            .catch(err => {
                this.$toast.error("Ingredients Data Error")
            })
    },
    getSystems(){
        axios.get(api.path('systems'))
            .then(res => {
                this.systems  = res.data
                this.systems.map((item, ind, arr) => {
                    let des = item['name']
                    arr[ind]['description'] = des
                })
            })
            .catch(err => {
                this.$toast.error("System Data Error!")
            })
    },
    getIngredients(systemId){
      axios.get(api.path('system') +'/'+ systemId)
          .then(res => {
            this.ingredients = res.data['ingredients']
            this.ingredients.map(ingredient => {
              let idx = this.ingredient_list.findIndex(item => item['id'] == ingredient['ingredientid'])
              ingredient['ingredientid'] = this.ingredient_list[idx]['id']
              ingredient['name'] = this.ingredient_list[idx]['name']
              ingredient['color'] = this.ingredient_list[idx]['color']
              ingredient['color'].map(color_ingredient => {
                  let color = this.color_list.find( item => item['id'] == color_ingredient['colorid'] )
                  color_ingredient['name'] = color['name']
              })
              ingredient['pattern'] = this.ingredient_list[idx]['pattern']
              ingredient['pattern'].map(pattern_ingredient => {
                  let pattern = this.pattern_list.find( item => item['id'] == pattern_ingredient['patternid'] )
                  pattern_ingredient['name'] = pattern['name']
              })
              ingredient['coverage'] = this.ingredient_list[idx]['coverage']
              ingredient['purchaseprice'] = this.ingredient_list[idx]['purchaseprice']
            })
          })
          .catch(err => {
              this.$toast.error("System Data Error")
          })
    },
    eidtSalePrice(){
        if(this.show_edit_salePrice) this.show_edit_salePrice = false
        else this.show_edit_salePrice = true
    },
    change(){
        let data = {'project': this.project}
        data['project']['projectdetails'].map(item => delete item['system'])
        this.$store.dispatch('project/setProject', data)
    },
    addProject(){
      if(!this.checkProjectDetail()) return
      this.project['note'] = this.note
      if(!this.project['projectdetails']) this.project['projectdetails'] = []
      let new_projectdetail = this.getNewProjectDetail()
      if(new_projectdetail['id'] == 'new') this.project['projectdetails'].push(new_projectdetail)
      else {
          let idx = this.project['projectdetails'].findIndex(item => item['id'] == new_projectdetail['id'])
          this.project['projectdetails'].splice(idx, 1, new_projectdetail)
      }

      delete new_projectdetail.system

      let data = {'project': this.project}
      data['project']['projectdetails'].map(item => delete item['system'])
      this.$store.dispatch('project/setProject', data)

      if(this.leadid != 'new'){

            // if(!data['name']) return
        console.log('insert ---------------------')

        if(!('id' in data['project'])){
          let new_project = { leadid: this.leadid }
          axios.post(api.path('project'), new_project)
              .then(res => {
                new_project = res.data
                new_projectdetail['projectid'] = new_project['id']
                axios.post(api.path('projectdetail'), new_projectdetail)
                    .then(res => {})
                    .catch(res => {})

                let projectnote = { note: data['project']['note'], projectid: new_project['id']}
                if(projectnote != ''){
                    axios.post(api.path('projectnote'), projectnote)
                    .then(res => {})
                    .catch(err => {})
                }
                })
              .catch(err => {
                      this.$toast.error("Project data error!")
              })
        }
        else{
          if(new_projectdetail['id'] == 'new'){
            delete new_projectdetail.id
            new_projectdetail['projectid'] = data['project']['id']
            axios.post(api.path('projectdetail'), new_projectdetail)
                .then(res => {})
                .catch(res => {})
          }
          else{
            axios.put(api.path('projectdetail') +'/'+ new_projectdetail['id'], new_projectdetail)
                .then(res => {})
                .catch(res => {})
          }
        }
      }
      this.edit_new = false
    },
    checkProjectDetail(){
        if(this.areaname == '') return false
        if(this.length == 0 || this.width == 0) return false
        if(this.getSystemIdx == -1) return false
        return true
    },
    getNewProjectDetail(){
      let detail = {}
      detail['id'] = this.id
      detail['projectid'] = this.projectid
      detail['name'] = this.areaname
      detail['areawidth'] = this.width
      detail['arealength'] = this.length
      detail['area'] = this.getArea
      detail['systemid'] = this.systems[this.getSystemIdx]['id']
      detail['system'] = this.systems[this.getSystemIdx]['name']
      detail['saleprice'] = this.saleprice
      detail['areaprice'] = this.getAreaPrice
      detail['systemprice'] = this.systems[this.getSystemIdx]['saleprice']

      let detailStyles = []
      this.ingredients.map(style => {
        let detailstyle = {}
        if(style['colorid']){
            let color = style['color'].find( item => item['name'] == style['colorid'] )
            detailstyle['colorid'] = color['colorid']
        }
        if(style['patternid']){
            let pattern = style['pattern'].find( item => item['name'] == style['patternid'] )
            detailstyle['patternid'] = pattern['patternid']
        }
        detailstyle['ingredientid'] = style['ingredientid']
        detailStyles.push(detailstyle)
      })
      detail['projectdetailstyles'] = detailStyles
      return detail
    },
    getProject(){
      this.$store.dispatch('loader/setLoader', { loader: true })
      axios.get(api.path('getProjectByLeadId') +'/'+ this.leadid)
          .then(res => {
            if( 'error' in res.data){
              this.project['id'] = 'new'
            }
            else {
              this.project = res.data
              let proeject_data = {}
              proeject_data['project'] = res.data
              console.log('res----------', proeject_data)
              proeject_data['project']['projectdetails'].map(detail => {
                detail['system'] = detail['systemname']
              })
              console.log('res2----------', proeject_data)
              this.$store.dispatch('project/setProject', proeject_data)
              this.edit_new = false
            }
          })
          .catch(err => {
            this.$toast.error("Lead Data Error!")
          })
          .then( res => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
    },
    editProjectDetail(detail) {
        this.edit_new = true
        this.id = detail['id']
        this.projectid = detail['projectid']
        this.areaname = detail['name']
        this.width = detail['areawidth']
        this.length = detail['arealength']
        let idx = this.systems.findIndex(item => item['id'] == detail['systemid'])
        this.system_des = this.systems[idx]['description']
        this.saleprice = detail['saleprice']
        this.ingredients = detail['projectdetailstyles']
    },
    editNewProjectDetail(){
        this.edit_new = true
        this.id = 'new'
        this.areaname = ''
        this.width = 0
        this.length = 0
        this.system_des = ''
        this.saleprice = 0
        this.ingredients = []
    }
},

created() {
    this.getSystems()
    this.getData()
    if(this.leadid != 'new') this.getProject()
    else {
        this.project['projectdetails'] = []
        this.title = "SYSTEMS"
    }
},

computed:{
    getSystemIdx: function(){
      let idx = this.systems.findIndex(item => item['description'] == this.system_des)
      if(idx != -1 ) {
          this.saleprice = this.systems[idx]['saleprice']
          this.getIngredients(this.systems[idx]['id'])
      }
      return idx
    },
    getArea: function(){
        return this.length * this.width
    },
    getAreaPrice: function(){
        return this.getArea * this.saleprice
    },
    getAmount: function(idx){
      // console.log(this.ingredients[idx])
      return idx => ((this.ingredients[idx]['factor'] * this.getArea / this.ingredients[idx]['coverage']).toFixed(2))
    },
    getIngredientPrice: function(idx){
      return idx => ((this.getAmount(idx) * this.ingredients[idx]['purchaseprice']).toFixed(2))
    }
},

}
</script>
<style>
    #style1.vue-numeric-input.updown .btn {
      background: green !important;
    }
    .v-text-field.v-text-field--solo .v-input__control{
        min-height: 10px;
    }

</style>