<template >
  <div v-if="show">
    <v-card flat tile class="d-flex">
      <v-img
        :src="imageurl"
        @mouseover="hover_img = true"
        @mouseleave="hover_img = false"
        aspect-ratio="1"
        contain
        class="grey lighten-2">
        <v-fade-transition>
          <v-overlay
            v-if="hover_img"
            absolute
            color="#036358"
          >
            <v-btn color="error" dark class="mx-2 my-2" @click="deleteImage">Delete</v-btn>
          </v-overlay>
        </v-fade-transition>
      </v-img>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'

export default {
  data: () => ({
    hover_img: false,
    show: true,
  }),
  methods: {
    deleteImage(){
      axios.delete(api.path('projectimage') +'/'+ this.imageid)
        .then(res => {
          if(res.data['status'] === 'success') {
            this.$toast.success('Successfully Deleted!')
            this.show = false
          }
        })
        .catch(res => {

        })
    },
  },
  props: ['imageid', 'imageurl'],
  mounted() {
  }
}
</script>