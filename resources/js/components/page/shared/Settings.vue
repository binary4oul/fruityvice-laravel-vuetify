<template>
    <v-container fluid>
        <v-btn block color="grey" class="my-2" @click="$router.push({name:'profile'})">My Profile</v-btn>
        <v-btn block color="grey" class="my-2" @click="logout">Log Out</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'mymembership'})" dark>My Membership</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'myteam'})" dark>My Team</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'systems'})" dark>Systems</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'ingredients'})" dark>Ingredients</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'colors'})" dark>Colors</v-btn>
        <v-btn block color="primary" class="my-2" @click="$router.push({name:'patterns'})" dark>Patterns</v-btn>
    </v-container>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'
import { mapGetters } from 'vuex'

export default {

methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'login' })
    },

},

}
</script>