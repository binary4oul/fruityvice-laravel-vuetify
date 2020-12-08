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
					<font style="font-size:large">&nbsp;&nbsp; {{ getProjectPrice }}</font>
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
					<v-row v-if="team_role == 'manager'">
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

		<system-edit-form v-if="leadid" :leadid="leadid"></system-edit-form>

		<project-note v-if="projectid" :projectid="projectid"></project-note>
		<project-image-list v-if="projectid" :projectid="projectid"></project-image-list>

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
import ProjectImageList from '../component/ProjectImageList'
import ProjectNote from '../component/ProjectNote'
import store from '~/store/index'

export default {
components: {
	PersonEditForm,
	SystemEditForm,
	ProjectImageList,
	ProjectNote,
},

data: () => ({
	project: {},
	project_edit: {},
	edit_project: false,
	status_type:['estimate', 'current', 'complete'],
	calen_completed: false,
	calen_install: false,
	leadid: null,
	team_role: 'manager',
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
					this.$toast.error("Data Error!")
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
	sendEstimate() {
		this.$store.dispatch('loader/setLoader', { loader: true })
		axios.get(api.path('sendEstimate') +'/'+ this.leadid, )
				.then(res => {
					const response_data = res.data;
					if(response_data['status'] === 'success') this.$toast.success('Sent successfully!')
					else this.$toast.error(response_data['message'])
				})
				.catch(err => {
					this.$toast.error('Server Error!')
				})
				.then(() => {
					this.$store.dispatch('loader/setLoader', { loader: false })
				})
	}
},

computed: {
 	getProjectPrice: function(){
		const project = store.getters['project/project']
		if(!project) return;
		return project['projectdetails'].reduce( (prev, item) => (prev += item['areaprice']), 0)
    },
},

created() {
	let data = {'title': 'Project'}
	this.team_role = store.getters['auth/team_role']
	console.log(this.team_role)
	this.$store.dispatch('title/setTitle', data)
	this.projectid = this.$route.params.projectid
	this.$store.dispatch('loader/setLoader', { loader: true })
	axios.get(api.path('project') +'/'+ this.projectid)
			.then(res => {
				if(res.data){
					this.project = res.data
					this.leadid = this.project['leadid']
					this.$store.dispatch('project/setProject', res.data)
				}
			})
			.catch(err => {
				this.$toast.error('Project Data Error!')
			})
			.then(() => {
				this.$store.dispatch('loader/setLoader', { loader: false })
			})

	},
}
</script>
