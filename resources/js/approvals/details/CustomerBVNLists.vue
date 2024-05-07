<template>
<table class="table table-hover text-nowrap" v-if="unverified_bvns.data != null && unverified_bvns.data.length != 0">
        <thead class="bg-dark">
            <tr>
                <th>Customer</th>
                <th>BVN</th>
                <th>Updated</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="bvn in unverified_bvns.data" :key="bvn.id">
                <td>{{ bvn.user | FullName  }}</td>
                <td>{{ bvn.user != null ? bvn.user.bvn : ''}}</td>
                <td><span v-if="bvn.user != null">{{ bvn.user.updated_at | excelDate }}</span><span v-else>Undefined</span></td>
                <td>{{ specific | firstUp }}</td>
                <td>
                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <router-link v-if="bvn.user != null" class="btn btn-block dropdown-item" :to="'/staff/confirm/bvn/'+bvn.user.id"><i class="fa fa-check mr-1 text-primary"></i> Confirm </router-link>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="card" v-else>
        <div class="card-body">
            <img class="card-img-top" src="/dist/img/photo2.png" alt="Dist Photo 2">
            <div class="card-img-overlay d-flex flex-column justify-content-center">
                <h5 class="card-title text-white mt-5 pt-2">No Customer Address Yet</h5>
                <p class="card-text pb-2 pt-1 text-white">Add a new customers <br></p>
                <button class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            bvn: {},
            unverified_bvns: {},
        }
    },
    methods:{
        getAllInitials(page = 1){
            axios.get('/api/ums/bvn_verifications?page='+page+'&point=customer&specific='+this.specific)
            .then(response =>{
                this.unverified_bvns = response.data.unverified_bvns;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Banks Verification Numbers not loaded successfully',});
            });
        },
    },
    mounted() {
        this.getAllInitials();
    },
    props:{
        specific: String,
    },
}
</script>