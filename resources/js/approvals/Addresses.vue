<template>
<section class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Unconfirmed Addresses</h3>
        </div>
        <div class="card-body table-responsive p-0" style="height: 500px;" v-if="addresses.data != null && addresses.data.length != 0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="address in addresses.data" :key="address.id">
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
        </div>
        <div class="card-body" v-else>
            <img class="card-img-top" src="/dist/img/photo2.png" alt="Dist Photo 2">
            <div class="card-img-overlay d-flex flex-column justify-content-center">
                <h5 class="card-title text-white mt-5 pt-2">No Customer Address Yet</h5>
                <p class="card-text pb-2 pt-1 text-white">Add a new customers <br></p>
                <button class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            address: {},
            addresses: {},
            customers: {},
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/ums/address_verifications')
            .then(response =>{
                this.addresses = response.data.unverified;
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
    }
}
</script>