<template>
<v-card>
    <v-card-title>
        Edit Lead
        <v-spacer></v-spacer>
        </v-card-title>
    <person-edit-form></person-edit-form>

</v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import PersonEditForm from './PersonEditForm'

export default {
components: {
    PersonEditForm
},

methods: {
    success(data) {

    }
},

computed: mapGetters({


}),

mounted() {

},

data: () => ({

})
}
</script>