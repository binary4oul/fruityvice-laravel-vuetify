<template>

  <div class="fill-height">
    <v-card class="mx-auto my-1" max-width="1000px" min-height="99%">

      <!-- <div class="primary">
        <img :src="'/assets/image/logo.png'"  class="logoPng" center height="100px">
      </div> -->


      <v-toolbar color="second" dark>
        <v-btn icon @click="$router.push({name:'setting'})">
          <v-icon>mdi-settings</v-icon>
        </v-btn>
        <v-spacer></v-spacer>

        <v-toolbar-title>{{title}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="$router.push({name:'index'})">
          <v-icon>mdi-home</v-icon>
        </v-btn>
        <v-btn icon @click="logout()">
          <v-icon>mdi-logout</v-icon>
        </v-btn>
      </v-toolbar>

      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>

    </v-card>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import store from '~/store'
import axios from 'axios'
import Axios from 'axios'

export default {
  data: () => ({
    mini: false
  }),
  computed: mapGetters({
    title: 'title/title',
  }),

  components: {

  },

  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')

      this.$toast.info('You are logged out.')
      this.$router.push({ name: 'login' })
    },
  }
}
</script>

<style>
  img {
    max-width: 100%;
    max-height: 100%;
    display: block;
    margin: 0 auto
  }
</style>
