<template>
<section class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Unconfirmed Bank Verification Numbers</h3>
        </div>
        <div class="card-body table-responsive p-0" style="max-height: 500px;" v-if="users.data != null && users.data.length != 0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>Customer</th>
                    <th>BVN</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Loan Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user | FullName  }}</td>
                        <td>{{ user.bvn }}<br /> {{ user.customer.bvn_status == 0 ? 'Unconfirmed' : 'Rejected' }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.loans != null && user.loans.length != 0 ? 'Active Loan Request' : 'No Active Loan Request'}}</td>
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <router-link class="btn btn-block dropdown-item" :to="'/staff/confirm/bvns/'+user.id"><i class="fa fa-check mr-1 text-primary"></i> Confirm </router-link>
                                <button class="btn btn-block dropdown-item" @click="sendBVNMail(user.id)"><i class="fa fa-envelope mr-1"></i> Customer BVN error mail</button>
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
            users:{},
            address: {},
            addresses: {},
            customers: {},
            form: new Form({}),
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/ums/bvn_verifications')
            .then(response =>{
                this.users = response.data.users;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Unverified BVNs not loaded successfully',});
            });
        },
        sendBVNMail(user){
            Swal.fire({
                title: 'Are you sure?',
                text: "The customer will get a mail with asking him to update his Bank Verification Number",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send mail!'
                })
            .then((result) => {
                if(result.value){
                    this.form.get('/api/ums/bvn_verifications/send_mail/'+user)
                    .then(response=>{
                        //if (response.data.status == 'error')
                        Swal.fire(response.data.status, response.data.message, response.data.status);
                        //this.refreshAppointments(response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        }
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>