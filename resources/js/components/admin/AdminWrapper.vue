<template>
  <div class="fill-height">

    <tab></tab>

    <v-content>
      <v-container fluid>
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-container>
    </v-content>

    <app-footer></app-footer>
  </div>
</template>

<script>
import AppNav from './shared/AppNav'
import TopMenu from './shared/TopMenu'
import AppFooter from './shared/AppFooter'
import Tab from './shared/Tab'

export default {
  data: () => ({
    mini: false
  }),

  components: {
    AppNav,
    TopMenu,
    AppFooter,
    Tab,
  },

  methods: {
    navToggle() {
      this.mini = !this.mini
    }
  }
}
</script>
