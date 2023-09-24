<template>
<section>
    <form>
        <alert-error :form="KycData"></alert-error> 
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="KycData.first_name" :class="{'is-invalid' : KycData.errors.has('first_name') }">
                    <has-error :form="KycData" field="first_name"></has-error> 
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="KycData.middle_name" :class="{'is-invalid' : KycData.errors.has('middle_name') }"/>
                    <has-error :form="KycData" field="middle_name"></has-error> 
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Last Name*</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="KycData.last_name" :class="{'is-invalid' : KycData.errors.has('last_name') }" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="KycData.phone" :class="{'is-invalid' : KycData.errors.has('phone') }">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="KycData.email" :class="{'is-invalid' : KycData.errors.has('email') }">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Sex</label>
                    <select class="form-control" id="sex" name="sex" required v-model="KycData.sex" :class="{'is-invalid' : KycData.errors.has('sex') }">
                        <option value="">---Select Sex---</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <label>Date of Birth</label>
                <div class="form-group">
                    <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="KycData.dob" :class="{'is-invalid' : KycData.errors.has('dob') }">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <label>Profile Picture</label>
                <div class="form-group">
                    <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
                </div>
            </div>
            <input type="hidden" name="id" id="id" v-model="KycData.id">
        </div>
        <button @click.prevent="editMode ? updateKycData() : createKycData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            KycData: new Form({
                id:'',
                id_type_id:'', 
                id_file:'', 
                utility_type_id:'', 
                utility_file:'', 
                user_id: '',
            }),
        }
    },
    mounted() {
        Fire.$on('KycDataFill', kyc =>{
            this.KycData.fill(kyc);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.KycData.fill(data)));
        });
    },
    methods:{
        updateKycData(){
            this.$Progress.start();
            this.KycData.post('/api/ums/bios')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
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
            let photo = (this.KycData.image.length >= 150) ? this.KycData.image : "./"+this.KycData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {this.KycData.image = reader.result}
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
    }
}
</script>
