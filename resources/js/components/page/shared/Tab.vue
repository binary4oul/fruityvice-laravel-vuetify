<template>
      <v-app-bar
        color="#6A76AB"
        dark
        fixed app
        shrink-on-scroll
        prominent
        src="https://picsum.photos/1920/1080?random"
        fade-img-on-scroll
        scroll-target="#scrolling-techniques-3">

        <template v-slot:img="{ props }">
          <v-img
            v-bind="props"
            gradient="to top right, rgba(100,115,201,.7), rgba(25,32,72,.7)"
          ></v-img>
        </template>

        <v-spacer></v-spacer>
        <img :src="'/assets/image/logo.png'"  class="logoPng" align-center center height="100%">
        <v-spacer></v-spacer>

        <template v-slot:extension>
            <v-tabs align-with-title  mb4 >
                <v-tab v-for="item in tabs" :key="item.tab" :to="item.path">
                    {{ item.name }}
                </v-tab>
                <v-tab>
                  <v-menu v-if="more.length" >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            text
                            class="align-self-center mr-4"
                            v-bind="attrs"
                            v-on="on"
                            >
                        More
                        <v-icon right>mdi-menu-down</v-icon>
                        </v-btn>
                    </template>

                    <v-list class="grey lighten-3">
                        <v-list-item v-for="item in more" :key="item" :to="item.path">
                            {{ item.name }}
                        </v-list-item>
                    </v-list>
                  </v-menu>
                </v-tab>

                <v-spacer></v-spacer>

                  <v-menu v-if="more.length" >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            text
                            class="align-self-center mr-4"
                            v-bind="attrs"
                            v-on="on"
                            >
                        {{auth.firstname}}
                        <v-icon right>mdi-menu-down</v-icon>
                        </v-btn>
                    </template>

                    <v-list class="grey lighten-3">
                      <v-list-item :to="profile.path">{{ profile.name }}</v-list-item>
                      <v-list-item @click="logout">{{ logout.name }}</v-list-item>
                    </v-list>
                  </v-menu>

            </v-tabs>
        </template>
      </v-app-bar>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    data: () => ({
        tab: null,
        tabs: [
          {name:'Leads', path:'/lead/list'},
          {name:'Estimates', path:'/lead/list'},
          {name:'Current Projects', path:'/lead/list'},
          {name:'Complete Projects', path:'/lead/list'},
          ],
        more: [
          {name:'My Teams', path:'/lead/list'},
          {name:'My Memberships', path:'/profile'},
          {name:'Systems', path:'/more/system/list'},
          {name:'Ingredients', path:'/more/ingredient/list'},
          {name:'Colors', path:'/more/color/list'},
          {name:'Patterns', path:'/more/pattern/list'},
          ],
        profile: {name:'My Profile', path:'/profile'},
        logout: {name:'Log Out'},

    }),
computed: mapGetters({
  auth: 'auth/user'
}),

methods: {
  logout() {
      this.$store.dispatch('auth/logout')
      this.$toast.info('You are logged out.')
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