<template>
<table class="table table-hover text-nowrap" v-if="unverified_addresses.data != null && unverified_addresses.data.length != 0">
        <thead class="bg-dark">
            <tr>
                <th>Customer</th>
                <th>Type</th>
                <th>Address</th>
                <th>City</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="address in unverified_addresses.data" :key="address.id">
                <td>{{ address.customer | FullName  }}</td>
                <td>{{ address.type | firstUp }}</td>
                <td>{{ address.street }}</td>
                <td>{{ address.city | firstUp }} {{ address.area ? address.area.name+', ': '' }} {{ address.state ? address.state.name+', ': '' }}</td>
                <td>Unapproved</td>
                <td>
                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu">
                        <router-link class="btn btn-block dropdown-item" :to="'/staff/confirm/address/'+address.id"><i class="fa fa-check mr-1 text-primary"></i> Confirm </router-link>
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
            address: {},
            unverified_addresses: {},
        }
    },
    methods:{
        getAllInitials(page = 1){
            axios.get('/api/ums/bvn_verifications?page='+page+'&point=customer&specific='+this.specific)
            .then(response =>{
                this.unverified_addresses = response.data.unverified_addresses;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Addresses not loaded successfully',});
            });
        },
        scrollHanle(evt) {
            console.log(evt)
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