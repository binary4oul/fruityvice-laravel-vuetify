<template>
  <v-container fluid grid-list-xl>
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
  </v-container>
</template>

<script>
export default {
  components: {

  },
}
</script>
