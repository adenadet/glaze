<template>
<section>
    <form>
    <alert-error :form="EmploymentData"></alert-error> 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Employer's Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="EmploymentData.first_name" :class="{'is-invalid' : EmploymentData.errors.has('first_name') }">
                <has-error :form="EmploymentData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="EmploymentData.middle_name" :class="{'is-invalid' : EmploymentData.errors.has('middle_name') }"/>
                <has-error :form="EmploymentData" field="middle_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="EmploymentData.last_name" :class="{'is-invalid' : EmploymentData.errors.has('last_name') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="EmploymentData.phone" :class="{'is-invalid' : EmploymentData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="EmploymentData.email" :class="{'is-invalid' : EmploymentData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>BVN</label>
            <div class="form-group">
                <input name="bvn" id="bvn" type="number" class="form-control" placeholder="Bank Verification Number" v-model="EmploymentData.bvn" :class="{'is-invalid' : EmploymentData.errors.has('bvn') }" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="EmploymentData.sex" :class="{'is-invalid' : EmploymentData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="EmploymentData.dob" :class="{'is-invalid' : EmploymentData.errors.has('dob') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Profile Picture</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>&nbsp;</label>
            <div class="form-group">
                <div type="file" class="form-control">{{ EmploymentData.image }}</div>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="EmploymentData.id">
    </div>
    <button @click.prevent="updateEmploymentData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            EmploymentData: new Form({
                alt_phone:'', 
                bvn: '',
                dob:'', 
                email:'',
                first_name: '', 
                id:'', 
                image:'', 
                last_name:'', 
                middle_name:'', 
                phone:'', 
                sex:'', 
            }),
        }
    },
    mounted() {
        Fire.$on('BasicDataFill', user =>{
            this.EmploymentData.fill(user);
            console.log("Get Here");
        });
    },
    methods:{
        updateEmploymentData(){
            this.$Progress.start();
            this.EmploymentData.post('/api/ums/employees')
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