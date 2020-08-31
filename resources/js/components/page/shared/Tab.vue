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

        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>

        <template v-slot:extension>
            <v-tabs align-with-title  mb4 >
                <v-tab v-for="item in items" :key="item.tab" :to="item.path">
                    {{ item.name }}
                </v-tab>

                  <v-menu v-if="more.length" >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            text
                            class="align-self-center mr-4"
                            v-bind="attrs"
                            v-on="on"
                            >
                                more
                        <v-icon right>mdi-menu-down</v-icon>
                        </v-btn>
                    </template>

                    <v-list class="grey lighten-3">
                        <v-list-item v-for="item in more" :key="item" @click="addItem(item)">
                            {{ item }}
                        </v-list-item>
                    </v-list>
                  </v-menu>

            </v-tabs>
        </template>
      </v-app-bar>
</template>
<script>
export default {
    data: () => ({
        tab: null,
        items: [
          {name:'Leads', path:'/lead/list'},
          {name:'Estimates', path:'/profile'}
          ],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        more: ['News', 'Maps', 'Books', 'Flights', 'Apps',],
    }),
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