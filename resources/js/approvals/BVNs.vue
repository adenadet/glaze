<template>
<section class="container-fluid">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3"><h3 class="card-title">Unconfirmed Bank Verification Numbers</h3></li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Guarantors</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                    <ApproveDetailCustomerBVNUnconfirmed />
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                    <ApproveDetailGuarantorBVNUnconfirmed />
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">

                </div>
                <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                    
                </div>
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