<template>
<div>
    <person-edit-form :person="project['person']" :leadid="leadid"></person-edit-form>

    <v-container fluid>
        <template f fluid v-if="!edit_project">
            <v-row class="mx-4">
                <font style="font-size:samller; color:grey">Status : </font>
                <font style="font-size:large">&nbsp;&nbsp; {{ project['projectstatus'] }}</font>
                <v-spacer></v-spacer>
                <font style="font-size:samller; color:grey">Price : </font>
                <font style="font-size:large">&nbsp;&nbsp; {{ price }}</font>
                <v-spacer></v-spacer>
                <v-btn color="blue" dark small @click="editProject">
                    <v-icon dark>edit</v-icon>
                </v-btn>
            </v-row>
        </template>
        <template v-if="edit_project">
            <v-row>
                <v-col cols="12" sm="4" class="py-0">
                    <v-select :items="status_type" label="Status" v-model="project_edit.projectstatus"></v-select>
                </v-col>
                <v-col cols="12" sm="4" class="py-0">
                    <v-menu
                        v-model="calen_install"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="project_edit.install"
                            label="Installed"
                            persistent-hint
                            prepend-icon="event"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="project_edit.install" no-title @input="calen_install = false"></v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="12" sm="4" class="py-0">
                    <v-menu
                        v-model="calen_completed"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="project_edit.completed"
                            label="Completed"
                            persistent-hint
                            prepend-icon="event"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="project_edit.completed" no-title @input="calen_completed = false"></v-date-picker>
                    </v-menu>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="4">
                    <v-checkbox v-model="project_edit.active" label="Active" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-2 my-0">Acive</v-checkbox>
                </v-col>
                <v-col cols="12" sm="4">
                    <v-checkbox v-model="project_edit.share" label="Share" v-bind:false-value=0 v-bind:true-value=1 hide-details class="mx-2 my-0">Share</v-checkbox>
                </v-col>
            </v-row>
            <v-row>
                <v-spacer></v-spacer>
                <v-btn color="green" dark class="mx-2 my-2" @click="saveProject">Save</v-btn>
                <v-btn class="mx-2 my-2" @click="edit_project=false">Cancel</v-btn>
                <v-spacer></v-spacer>
            </v-row>
        </template>
    </v-container>

    <system-edit-form :leadid="leadid"></system-edit-form>

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
                class="d-flex child-flex"
                cols="12" sm="4">
                <v-card flat tile class="d-flex">
                  <v-img
                    :src="item.image"
                    aspect-ratio="1"
                    contain
                    class="grey lighten-2">
                  </v-img>
                </v-card>
              </v-col>
            </v-row>

        </template>
     </v-container>
    <v-row>
        <v-btn class="mx-8 my-4" color="green" dark @click="sendEstimate">Share with Client</v-btn>
        <v-spacer></v-spacer>
        <v-btn class="mx-8 my-4" @click="$router.go(-1)">Cancel</v-btn>
    </v-row>
</div>
</template>
<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import { api } from '~/config'
import PersonEditForm from '../component/PersonEditForm'
import SystemEditForm from '../component/SystemEditForm'

export default {

components: {
    PersonEditForm,
    SystemEditForm,
},

data: () => ({
    project: {},
    project_edit: {},
    note: [],
    image: [],
    image_edit:null,
    note_edit: '',
    edit_image: false,
    new_image: false,
    price: 0,
    edit_project: false,
    edit_note: false,
    status_type:['estimate', 'current', 'complete'],
    image_size: [
      value => !value || value.size < 2000000 || 'Image size should be less than 2 MB!',
    ],
    calen_completed: false,
    calen_install: false,
}),

methods: {
    saveProject(){
        let project_data = {}
        project_data = this.project_edit
        axios.put(api.path('project') +'/'+ this.project['id'], project_data)
            .then(res => {
                    this.edit_project = false
                    this.project = res.data
                })
            .catch(err => {
                this.handleErrors("Data Error!")
        })
    },
    editProject(){
        this.edit_project = true
        this.project_edit['projectstatus'] = this.project['projectstatus']
        this.project_edit['install'] = this.project['install']
        this.project_edit['completed'] = this.project['completed']
        this.project_edit['active'] = this.project['active']
        this.project_edit['share'] = this.project['share']
    },
    saveNote(){
        let project_note = {}
        project_note['note'] = this.note_edit
        project_note['projectid'] = this.project['id']
        axios.post(api.path('projectnote') , project_note)
            .then(res => {
                    this.note.push(res.data)
                })
            .catch(err => {
                this.handleErrors("Data Error!")
        })

    },
    onImageChange(e){

        this.image_edit = e.target.files[0];
    },
    saveImage(){
        if(!this.image_edit) return
        const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
        let formData = new FormData();
        formData.append('image', this.image_edit);
        formData.append('projectid', this.project['id']);

        axios.post(api.path('projectimage'), formData, config)
            .then(res =>{
                this.image.push(res.data)
            })
            .catch(err => {

            })

    },
    sendEstimate(){

    }
},

created() {
    let data = {'title': 'Project'}
    this.$store.dispatch('title/setTitle', data)
    this.leadid = this.$route.params.leadid
  //  this.projectid = this.$route.params.projectid
    axios.get(api.path('getProjectByLeadId') +'/'+ this.leadid)
        .then(res => {
            if(res.data){
                this.project = res.data
                this.price = this.project['projectdetails'].reduce( (total, item) => { return total+item['areaprice'] }, 0)
                this.$store.dispatch('project/setProject', res.data)
                axios.get(api.path('projectnotelist') +'/'+ this.project['id'])
                    .then(res => {
                        this.note = res.data
                    })
                axios.get(api.path('projectimagelist')+'/'+this.project['id'])
                    .then(res => {
                        this.image = res.data
                    })
            }
            })
        .catch(err => {
            this.handleErrors("Data Error!")
        })

},
}
</script>
