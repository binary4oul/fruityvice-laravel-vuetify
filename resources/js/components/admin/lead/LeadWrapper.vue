<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-flex mb4 sm8 xs12>
        <transition name="fade" mode="out-in">
          <router-view></router-view>
        </transition>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>


export default {
  components: {

  },

  data: () => ({
    items: []
  }),

  mounted() {
    this.navigation()
  },

  methods: {
    navigation() {
      this.items = [
        { title: 'View', icon: 'visibility', to: { name: 'profile' } },
        { title: 'Edit', icon: 'edit', to: { name: 'profile-edit' } },
      ]
    }
  }
}
</script>
