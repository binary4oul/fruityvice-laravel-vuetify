<template>
  <v-container>
    <v-row>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label=" Search Fruit Name Or Family."
        single-line
        hide-details
        class="mx-4 my-4"
        @input="getFruits()"
      ></v-text-field>
      <v-btn color="green" dark @click="addNew" class="mx-4 my-4">
        <v-icon dark>add</v-icon>Add New
      </v-btn>
      <v-spacer></v-spacer>
    </v-row>
    <v-data-table
      :headers="headers"
      :items="fruits"
      :items-per-page="-1"
      :hide-default-footer="true"
    >
      <template v-slot:item.is_fav={item}>
        <v-checkbox 
          v-model="item.is_fav" 
          @change="setFavourite(item.id, item.is_fav)"
          :disabled="(!item.is_fav && exceedMaximumFavourites)">
        </v-checkbox>
      </template>
    </v-data-table>
    <v-row class="justify-end align-center">
      <v-col cols="2">
        <v-select
          v-model="per_page"
          label="Rows per page:"
          :items="[5, 10 ,15, 20]"
          @change="getFruits()"
        ></v-select>
      </v-col>
      <v-col cols="4">
        <v-pagination
          v-model="current_page"
          :length="last_page"
          total-visible="7"
          color="purple"
          @input="getFruits()"
        ></v-pagination>
      </v-col>

    </v-row>
    <template>
      <v-dialog v-model="modalOpen" max-width="500px">
        <v-card>
          <v-card-title class="headline gray lighten-2">
            Add New Fruit
          </v-card-title>
          
          <!--Dialog Content-->
          <fruit-add @click-cancel="modalOpen = false"/>
        </v-card>
      </v-dialog>
    </template>
  </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import { VDialog } from 'vuetify/lib'
import FruitAdd from './FruitAdd.vue'

export default {
components: {
  FruitAdd
},
data: () => ({
    search: '',
    headers: [
      { text: '', value: 'id'},
      { text: 'Genius', value: 'genus' },
      { text: 'Name', value: 'name' },
      { text: 'Family', value: 'family' },
      { text: 'Order', value: 'order' },
      { text: 'Favourite', value: 'is_fav' },
    ],
    fruits:[],
    current_page: 1,
    last_page: 10,
    per_page: 10,
    timeout: null,
    modalOpen: false,
    exceedMaximumFavourites: false
  }),

mounted() {
  let data = {'title': 'All fruits'}
  this.$store.dispatch('title/setTitle', data)
  this.getFruits()
},

methods: {
  getFruits(delay) {
    const { current_page, per_page, search } = this

    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
      if(search == this.search){
        this.$store.dispatch('loader/setLoader', { loader: true })
        axios.get(api.path('fruits'), { params: { page: current_page, per_page, search }  })
          .then(res => {
            console.log('res', res)
            const { data, current_page, last_page, exceedMaximumFavourites } = res.data
            if(current_page > last_page) {
              this.current_page = 1
              this.getFruits()
            }
            this.fruits  = data
            this.current_page = current_page
            this.last_page = last_page
            this.exceedMaximumFavourites = exceedMaximumFavourites
            if(exceedMaximumFavourites)
              this.$toast.error("The count of your favourite fruits has reached the maximum value.")
          })
          .catch(err => {
            this.$toast.error('Server Error')
          })
          .then(() => {
            this.$store.dispatch('loader/setLoader', { loader: false })
          })
      }
    }, delay);
  },

  addNew() {
    this.modalOpen = !this.modalOpen
  },

  setFavourite(fruit_id, is_fav) {
    axios.post(api.path('favourite'), { fruit_id, is_fav } )
      .then(res => {
        console.log('res', res)
        const {exceedMaximumFavourites} = res.data

        this.exceedMaximumFavourites = exceedMaximumFavourites

        if(exceedMaximumFavourites) {
          this.$toast.error("The count of your favourite fruits has reached the maximum value.")
        }
      })
      .catch(err => {
        this.$toast.error('Server Error')
      })
      .then(() => {
        this.$store.dispatch('loader/setLoader', { loader: false })
      })
  }
}
}
</script>