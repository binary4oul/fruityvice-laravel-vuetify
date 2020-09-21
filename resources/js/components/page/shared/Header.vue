<template gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)">
    <v-container fluid>
        <v-spacer></v-spacer>
            <img :src="'/assets/image/logo.png'"  class="logoPng" align-center center height="100%">
        <v-spacer></v-spacer>
        test header
    </v-container>
</template>
<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'
export default {
    data: () => ({
        tab: null,
        tabs: [
          {name:'Leads', path:'/lead/list'},
          {name:'Estimates', path:'/project/estimates'},
          {name:'Current Projects', path:'/project/current'},
          {name:'Complete Projects', path:'/project/complete'},
          ],
        more: [
          {name:'My Teams', path:'/lead/list'},
          {name:'My Memberships', path:'/lead/list'},
          {name:'Systems', path:'/more/system/list'},
          {name:'Ingredients', path:'/more/ingredient/list'},
          {name:'Colors', path:'/more/color/list'},
          {name:'Patterns', path:'/more/pattern/list'},
          ],
        profile: {name:'My Profile', path:'/profile'},

    }),
computed: mapGetters({
  auth: 'auth/user'
}),

methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'login' })
    },
},
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