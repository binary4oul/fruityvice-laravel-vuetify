<template>
<div>
    <v-row class="mt-4">
        <v-spacer></v-spacer>
        <v-col cols="5" sm="3">
            <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('leads')" color="primary" dark>
                <v-row class="pt-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 100px;">recent_actors</span>
                    <v-spacer></v-spacer>
                </v-row>
                <v-row class="pb-8">
                    <v-spacer></v-spacer>
                    <h2 style="text-align:center">Leads</h2>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-col cols="5" sm="3">
            <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('estimates')" color="rgb(236,151,31)" dark>
                <v-row class="pt-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 100px;">business</span>
                    <v-spacer></v-spacer>
                </v-row>
                <v-row class="pb-8">
                    <v-spacer></v-spacer>
                    <h2 style="text-align:center">Estimates</h2>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
    <v-row class="mb-2">
        <v-spacer></v-spacer>
        <v-col cols="5" sm="3">
            <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('current')" color="green" dark>
                <v-row class="pt-2">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 100px;">home_repair_service</span>
                    <v-spacer></v-spacer>
                </v-row>
                <v-row class="pb-2">
                    <v-spacer></v-spacer>
                    <h2 style="text-align:center">Current<br />Projects</h2>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-col cols="5" sm="3">
            <v-card calss="mx-auto clickable" @click.native="selcetActiveItem('complete')" color="red" dark>
                <v-row class="pt-2">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 100px;">check</span>
                    <v-spacer></v-spacer>
                </v-row>
                <v-row class="pb-2">
                    <v-spacer></v-spacer>
                    <h2 style="text-align:center">Complete<br />Projects</h2>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>

    <v-row>
        <v-spacer></v-spacer>
        <h2 style="text-align:center">Inactive</h2>
        <v-spacer></v-spacer>
    </v-row>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="8" sm="4"><hr></v-col>
        <v-spacer></v-spacer>
    </v-row>

    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="4" sm="2">
            <v-card calss="mx-auto clickable" @click.native="selcetInctiveItem('leads')" color="grey" dark>
                <v-row class="pt-4 pb-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 80px; color:black">recent_actors</span>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-col cols="4" sm="2">
            <v-card calss="mx-auto clickable" @click.native="selcetInctiveItem('estimates')" color="grey" dark>
                <v-row class="pt-4 pb-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 80px; color:black" >business</span>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
    <v-row class="mb-2">
        <v-spacer></v-spacer>
        <v-col cols="4" sm="2">
            <v-card calss="mx-auto clickable" @click.native="selcetInctiveItem('current')" color="grey" dark>
                <v-row class="pt-4 pb-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 80px; color:black">home_repair_service</span>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-col cols="4" sm="2">
            <v-card calss="mx-auto clickable" @click.native="selcetInctiveItem('complete')" color="grey" dark>
                <v-row class="pt-4 pb-4">
                    <v-spacer></v-spacer>
                    <span class="material-icons" style="font-size: 80px; color:black" >check</span>
                    <v-spacer></v-spacer>
                </v-row>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>

</div>
</template>

<script>
import axios from 'axios'
import { api } from '~/config'


export default {

data: () => ({

}),

mounted() {
  let data = {'title': 'Home'}
  this.$store.dispatch('title/setTitle', data)
},

methods:{
    selcetActiveItem(item){
        if(item=='leads') this.$router.push({ name: 'leads', params:{active: true} })
        if(item=='estimates') this.$router.push({ name: 'estimates', params:{active: true} })
        if(item=='current') this.$router.push({ name: 'current', params:{active: true} })
        if(item=='complete') this.$router.push({ name: 'complete', params:{active: true} })
    },
    selcetInctiveItem(item){
        if(item=='leads') this.$router.push({ name: 'leads', params:{active: false} })
        if(item=='estimates') this.$router.push({ name: 'estimates', params:{active: false} })
        if(item=='current') this.$router.push({ name: 'current', params:{active: false} })
        if(item=='complete') this.$router.push({ name: 'complete', params:{active: false} })
    }
}
}
</script>