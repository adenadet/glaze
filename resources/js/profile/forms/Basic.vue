<template>
<div>
<form>
    <alert-error :form="BioData"></alert-error> 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="BioData.first_name" :class="{'is-invalid' : BioData.errors.has('first_name') }">
                <has-error :form="BioData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="BioData.middle_name" :class="{'is-invalid' : BioData.errors.has('middle_name') }"/>
                <has-error :form="BioData" field="middle_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="BioData.last_name" :class="{'is-invalid' : BioData.errors.has('last_name') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="BioData.phone" :class="{'is-invalid' : BioData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="BioData.email" :class="{'is-invalid' : BioData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <label>BVN</label>
            <div class="form-group">
                <input name="bvn" id="bvn" type="number" class="form-control" placeholder="Bank Verification Number" v-model="BioData.bvn" :class="{'is-invalid' : BioData.errors.has('bvn') }" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <label>NIN</label>
            <div class="form-group">
                <input name="nin" id="nin" type="number" class="form-control" placeholder="National Identification Number" v-model="BioData.nin" :class="{'is-invalid' : BioData.errors.has('nin') }" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="BioData.sex" :class="{'is-invalid' : BioData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="BioData.dob" :class="{'is-invalid' : BioData.errors.has('dob') }">
            </div>
        </div>
        <div :class="editing ? 'col-sm-12' : 'col-sm-6'">
            <label>Profile Picture</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <div class="col-md-6 col-sm-12" v-if="!editing">
            <label>&nbsp;</label>
            <div class="form-group">
                <div type="file" class="form-control">{{ BioData.image }}</div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="BioData.id">
    </div>
    <button @click.prevent="updateBioData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            BioData: new Form({
                alt_phone:'', 
                bvn: '',
                dob:'', 
                email:'',
                first_name: '', 
                id:'', 
                image:'', 
                last_name:'', 
                middle_name:'', 
                nin: '',
                phone:'', 
                sex:'', 
            }),
            editing: false,
        }
    },
    mounted() {
        Fire.$on('BasicDataFill', user =>{
            this.BioData.fill(user);
        });
    },
    methods:{
        updateBioData(){
            this.$Progress.start();
            this.BioData.post('/api/ums/profile')
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
            let photo = (this.BioData.image.length >= 150) ? this.BioData.image : "./"+this.BioData.image;
            return photo;
            },
        updateProfilePic(e){
            this.editing = true;
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {this.BioData.image = reader.result}
                reader.readAsDataURL(file)
                //alert(reader.result)
            }
            else{
                Swal.fire({type: 'error', title: 'File is too large'});
                this.editing = false;
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
