<template >
	<v-container fluid>
    <template f fluid>
        <v-btn block @click="edit_note=!edit_note" v-bind:color="edit_note == true ? 'rgb(236,151,31)' : 'primary'" dark>NOTES</v-btn>
    </template>

    <template v-if="edit_note">
      <v-textarea
        label="Note"
        v-model="note_edit"
        auto-grow
        outlined
        rows="2"
        row-height="15"
        class="mt-8"
      ></v-textarea>
      <v-row>
        <v-spacer></v-spacer>
            <v-btn color="green" dark class="mx-2 my-2" @click="saveNote">Save</v-btn>
        <v-spacer></v-spacer>
      </v-row>
      <v-simple-table dense v-if="note.length>0">
        <template v-slot:default>
          <tbody>
          <tr v-for="(item, index) in note" :key="index">
            <td>{{ item.note }}</td>
          </tr>
          </tbody>
        </template>
      </v-simple-table>

    </template>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'

export default {
  data: () => ({
    note: [],
    note_edit: '',
    edit_note: false,
  }),
  methods: {
    saveNote(){
			let project_note = {}
			project_note['note'] = this.note_edit
			project_note['projectid'] = this.projectid
			axios.post(api.path('projectnote') , project_note)
					.then(res => {
						this.note.push(res.data)
						this.note_edit = ''
						})
					.catch(err => {
						this.$toast.error("Data Error!")
			})

		},

  },
  props: ['projectid'],
  mounted() {
    axios.get(api.path('projectnotelist') +'/'+ this.projectid)
        .then(res => {
            this.note = res.data
        })
  }
}
</script>