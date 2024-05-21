<template>
<table class="table table-hover text-nowrap" v-if="unverified_nins.data != null && unverified_nins.data.length != 0">
        <thead class="bg-dark">
            <tr>
                <th>Customer</th>
                <th>NIN</th>
                <th>Updated</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="nin in unverified_nins.data" :key="nin.id">
                <td>{{ nin.user | FullName  }}</td>
                <td>{{ nin.user != null ? nin.user.nin : ''}}</td>
                <td><span v-if="nin.user != null">{{ nin.user.updated_at | excelDate }}</span><span v-else>Undefined</span></td>
                <td>{{ specific | firstUp }}</td>
                <td>
                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <router-link v-if="nin.user != null" class="btn btn-block dropdown-item" :to="'/staff/confirm/nin/'+nin.user.id"><i class="fa fa-check mr-1 text-primary"></i> Confirm </router-link>
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
            nin: {},
            unverified_nins: {},
        }
    },
    methods:{
        getAllInitials(page = 1){
            axios.get('/api/ums/nin_verifications?page='+page+'&point=customer&specific='+this.specific)
            .then(response =>{
                this.unverified_nins = response.data.unverified_nins;
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