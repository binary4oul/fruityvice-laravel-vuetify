<template>
  <v-container fluid>
    <template f fluid>
        <v-btn block @click="edit_image=!edit_image" v-bind:color="edit_image == true ? 'rgb(236,151,31)' : 'primary'" dark>IMAGES</v-btn>
    </template>
    <template v-if="edit_image">
      <v-btn color="green" dark @click="new_image=!new_image" class="mx-4 my-4">
        <v-icon dark>add</v-icon>New Image
      </v-btn>

      <v-row v-if="new_image">
        <v-spacer></v-spacer>
        <v-file-input
            :rules="image_size"
            accept="image/png, image/jpeg, image/bmp"
            placeholder="Upload an image"
            prepend-icon="mdi-camera"
            label="Image"
            v-model="image_edit"
            ></v-file-input>
        <v-btn color="green" dark class="mx-4 my-2" @click="saveImage">Save</v-btn>
        <v-spacer></v-spacer>
      </v-row>

      <v-row>
        <v-col
          v-for="(item,idx) in image"
          :key="idx"

          cols="12" sm="4">
         <project-image :imageid="item.id" :imageurl="item.image"> </project-image>
        </v-col>
      </v-row>
    </template>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'
import ProjectImage from './ProjectImage'

export default {
  components: {
    ProjectImage
  },
  data: () => ({
    edit_image: false,
    new_image: false,
    image_edit: null,
    image: [],
    image_size: [
      value => !value || value.size < 2000000 || 'Image size should be less than 2 MB!',
    ],
  }),
  props: ['projectid'],
  methods: {
    saveImage(){
      if(!this.image_edit) return
      const config = {
          headers: { 'content-type': 'multipart/form-data' }
      }
      let formData = new FormData();
      formData.append('image', this.image_edit);
      formData.append('projectid', this.projectid);

      axios.post(api.path('projectimage'), formData, config)
          .then(res =>{
              this.image.push(res.data)
              this.image_edit = null
          })
          .catch(err => {

          })
		},

  },
  mounted() {
    axios.get(api.path('projectimagelist') +'/'+ this.projectid)
        .then(res => {
            this.image = res.data
        })
  }
}
</script>
