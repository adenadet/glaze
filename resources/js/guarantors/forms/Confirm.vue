<template>
<section>
    <form class="form" action="#" @submit.prevent="customerRegister">
        <div class="row" v-for="(guarantor, index) in confirmationData.guarantors" :key="index">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" required class="form-control" id="title" name="title" placeholder="First Name *" v-model="confirmationData.customer.title" >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="confirmationData.customer.first_name" >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Last Name*</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="confirmationData.customer.last_name"/>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="confirmationData.customer.middle_name"/>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="confirmationData.customer.middle_name"/>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="btn-group">
                    <button class="btn btn-danger" title="Delete" v-on:click="deleteGuarantor(guarantor)"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            loan: {},
            confirmationData: new Form({
                id: '',
                loan_id:'', 
                first_name:'', 
                middle_name:'', 
                last_name:'', 
                bvn:'', 
                marital_status: '',
                dob: '',
                nationality_id: '',
                address: '',
                phone: '',
                email: '',
                official_address:'',
                official_email: '',
                position: '',
                official_phone: '',
                net_monthly_income: '',
                declaration: '',
                signaturePad: '',
            }),
        }
    },
    mounted() {
        Fire.$on('AddressDataFill', base =>{
            this.address = base;
            base != null ? this.AddressData.fill(base) : this.AddressData.clear();
        });
    },
    methods:{
        createAddressData(){
            this.AddressData.user_id = this.user.id;
            this.$Progress.start();
            this.AddressData.post('/api/ums/addresses')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Address details has been created',
                    showConfirmButton: false,
                    timer: 1500
                    });
                })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
                });  
                    
        },
        updateAddressData(){
            this.AddressData.user_id = this.user.id;
            this.$Progress.start();
            this.AddressData.post('/api/ums/addresses/'+this.AddressData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Address details has been updated',
                    showConfirmButton: false,
                    timer: 1500
                    });
                })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
                });  
                    
        },
        getProfilePic(){
            let photo = (this.AddressData.image.length >= 150) ? this.AddressData.image : "./"+this.AddressData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {this.AddressData.image = reader.result}
                reader.readAsDataURL(file)
                //alert(reader.result)
            }
            else{
                Swal.fire({type: 'error', title: 'File is too large'});
            }
        },
    },
    props:{
        areas: Array,
        states: Array,
        nations: Array,
        user: Object,
        editMode: Boolean,
        source: String,
    },
}
</script>
