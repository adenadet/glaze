<template>
<section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Unconfirmed Addresses</h3>

            <!--div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
            </div-->
        </div>
        <div class="card-body table-responsive p-0" style="height: 500px;" v-if="address.data.length == 0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="address in address.data" :key="address.id">
                        <td>{{ address.user | FullName  }}</td>
                        <td>{{ address.type }}</td>
                        <td>{{ address.street }}</td>
                        <td>Unapproved</td>
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <router-link class="btn btn-block dropdown-item" :to="'/loans/1'"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                <button v-if="account.status > 13" class="btn btn-block dropdown-item" @click="closeLoan()"><i class="fa fa-times mr-1 text-danger"></i> Close Loan</button>
                                <button v-else class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <img class="card-img-top" src="/dist/img/photo2.png" alt="Dist Photo 2">
            <div class="card-img-overlay d-flex flex-column justify-content-center">
                <h5 class="card-title text-white mt-5 pt-2">No Customer Added Yet</h5>
                <p class="card-text pb-2 pt-1 text-white">
                Add a new customers <br>
                
                </p>
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
            customers: {},
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/ums/address_verifications')
            .then(response =>{
                this.addresses = response.data.addresses;
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