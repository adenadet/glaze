<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"> 
                        <h4 class="card-title">Guarantor {{ $route.params.type | firstUp }} Address</h4>
                    </div>
                    <div class="card-body">
                        {{$route.params.type == 'residential' ? guarantor.residential_address : guarantor.employer_address}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> 
                        <h4 class="card-title">Confirm {{ $route.params.type | firstUp }}</h4>
                    </div>
                    <div class="card-body">
                        <ApproveFormAddress type="guarantor"/>
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
            editMode: false,
            guarantor: {},
        }
    },
    methods:{
        editAddressVerification(){
            this.editMode = true;
        },
        getInitials(){
            axios.get('/api/loans/guarantors/'+this.$route.params.id).then(response =>{
                this.guarantor = response.data.guarantor;
                //this.address_verification = response.data.address_verification;
                
                //Fire.$emit('AddressVerificationDataFill', this.address_verification);
                //Fire.$emit('AddressDataFill', this.address); 

            })
            .catch(()=>{
                toast.fire({
                    icon: 'error',
                    title: 'Address Initialization failed',
                })
            });
        }, 
    },
    mounted() {
        this.getInitials();   
    },
}
</script>
