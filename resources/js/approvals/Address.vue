<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-4"><ApproveDetailsAddress /></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" v-show="!editMode && address.verification != null">
                    <CustomerDetailAddressVerification :address="address" :address_verification="address_verification"/>
                    <input type="button" name="button" class="button btn btn-success" value="Update" @click="editAddressVerification()"/>
                </div>
                <div class="card-body" v-show="editMode || address.verification == null"><ApproveFormAddress /></div>
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
            address: {},
            address_verification: {},
        }
    },
    methods:{
        editAddressVerification(){
            this.editMode = true;
        },
        getInitials(){
            axios.get('/api/ums/addresses/'+this.$route.params.id).then(response =>{
                this.address = response.data.address;
                this.address_verification = response.data.address_verification;
                
                Fire.$emit('AddressVerificationDataFill', this.address_verification);
                Fire.$emit('AddressDataFill', this.address); 

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