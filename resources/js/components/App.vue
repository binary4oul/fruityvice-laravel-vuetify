<template>
  <v-app id="app">
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>

    <v-overlay v-if="isLoad">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>

  </v-app>
</template>

<script>
import { mapGetters } from 'vuex'
export default {

  computed: mapGetters({
    isLoad: 'loader/loader',
  }),
}
</script>
