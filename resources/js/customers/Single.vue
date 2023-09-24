<template>
<section class="content">
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-xl-3 col-sm-4 col-md-4 d-flex align-items-stretch flex-column">
                    <UserCard :user="customer" />
                </div>
                <div class="col-xl-9 col-sm-8 col-md-8 d-flex align-items-stretch flex-column">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab" data-toggle="pill" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="address-tab" data-toggle="pill" href="#address" role="tab" aria-controls="address" aria-selected="false">Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="next-of-kin-tab" data-toggle="pill" href="#next-of-kin" role="tab" aria-controls="next-of-kin" aria-selected="false">Next of Kin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kyc-tab" data-toggle="pill" href="#kyc" role="tab" aria-controls="kyc" aria-selected="false">Know Your Customer</a>
                            </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                                    <UserFormBasic :user="customer" :staffs="staffs" />
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <UserFormAddress :user="customer" :staffs="staffs" />
                                </div>
                                <div class="tab-pane fade" id="next-of-kin" role="tabpanel" aria-labelledby="next-of-kin-tab">
                                    <UserFormNOK :user="customer" />
                                </div>
                                <div class="tab-pane fade" id="kyc" role="tabpanel" aria-labelledby="kyc-tab">
                                    <UserFormKYC :user="customer" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <LoanAll mode="staff" :user="customer" />
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
            customer: {},
            staffs: [],
            
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/ums/customers/'+this.$route.params.id)
            .then(response =>{
                this.reloadPage(response);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Customers not loaded successfully',});
            });
        },
        reloadPage(response){
            this.customer      = response.data.customer;
            this.staffs = response.data.staffs;

            Fire.$emit('BioDataFill', this.customer);
            Fire.$emit('NextOfKinFill', this.customer.next_of_kin);
            Fire.$emit('AddressDataFill', this.customer.customer_address);
            
        }
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>