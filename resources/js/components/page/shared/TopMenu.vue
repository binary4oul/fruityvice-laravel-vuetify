<template>
	<v-app-bar dark :clipped-left="$vuetify.breakpoint.mdAndUp" fixed app color="primary">
    <v-app-bar-nav-icon @click.stop="navToggle"></v-app-bar-nav-icon>

    <img :src="'/assets/image/logo.png'" />

  </v-app-bar>
</template>

<script>
import { settings } from '~/config'

export default {
	data: () => ({
		siteName: settings.siteName
	}),

	methods: {
    navToggle() {
      this.$emit('nav-toggle')
    }
	}
}
</script>
<style>
  img {
    max-width: 100%;
    max-height: 100%;
  }
</style>
