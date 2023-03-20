<template>
  <div>
    <v-row class="mt-12">
      <v-spacer></v-spacer>
      <v-col cols="5" sm="3">
        <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('all-fruits')" color="primary" style="cursor: pointer;" dark>
            <v-row class="pt-4">
                <v-spacer></v-spacer>
                <span class="material-icons" style="font-size: 100px;">apple</span>
                <v-spacer></v-spacer>
            </v-row>
            <v-row class="pb-8">
                <v-spacer></v-spacer>
                <h2 style="text-align:center">All Fruits</h2>
                <v-spacer></v-spacer>
            </v-row>
        </v-card>
      </v-col>
      <v-col cols="5" sm="3">
        <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('favourites')" color="rgb(236,151,31)" style="cursor: pointer;" dark>
          <v-row class="pt-4">
              <v-spacer></v-spacer>
              <span class="material-icons" style="font-size: 100px;">favorite</span>
              <v-spacer></v-spacer>
          </v-row>
          <v-row class="pb-8">
            <v-spacer></v-spacer>
            <h2 style="text-align:center">Favourite Fruits</h2>
            <v-spacer></v-spacer>
          </v-row>
        </v-card>
      </v-col>
        <v-spacer></v-spacer>
    </v-row>
</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'


export default {

data: () => ({

}),

mounted() {
  let data = {'title': 'Home'}
  this.$store.dispatch('title/setTitle', data)
  this.$store.dispatch('loader/setLoader', { loader: false })
},

methods:{
    selcetActiveItem(item){
        if(item=='all-fruits') this.$router.push({ name: 'all-fruits' })
        if(item=='favourites') this.$router.push({ name: 'favourites' })
    }
}
}
</script>