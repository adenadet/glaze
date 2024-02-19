<template>
<div>
<form>
    <alert-error :form="StaffData"></alert-error> 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="StaffData.first_name" :class="{'is-invalid' : StaffData.errors.has('first_name') }">
                <has-error :form="StaffData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="StaffData.middle_name" :class="{'is-invalid' : StaffData.errors.has('middle_name') }"/>
                <has-error :form="StaffData" field="middle_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="StaffData.last_name" :class="{'is-invalid' : StaffData.errors.has('last_name') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="StaffData.street" :class="{'is-invalid' : StaffData.errors.has('street') }" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="StaffData.street2" :class="{'is-invalid' : StaffData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="StaffData.city" :class="{'is-invalid' : StaffData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="StaffData.state_id" :class="{'is-invalid' : StaffData.errors.has('state_id') }">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" v-bind:key="state.id" :value="state.id" >{{state.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="StaffData.area_id" :class="{'is-invalid' : StaffData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in areas" v-bind:key="area.id" :value="area.id" >{{area.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="StaffData.phone" :class="{'is-invalid' : StaffData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Alternate Phone</label>
                <input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="StaffData.alt_phone" :class="{'is-invalid' : StaffData.errors.has('alt_phone') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Branch</label>
                <select class="form-control" id="branch_id" name="branch_id" v-model="StaffData.branch_id" :class="{'is-invalid' : StaffData.errors.has('branch_id') }">
                    <option value="">---Select Branch---</option>
                    <option v-for="branch in branches" v-bind:key="branch.id" :value="branch.id" >{{branch.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department_id" name="department_id" v-model="StaffData.department_id" :class="{'is-invalid' : StaffData.errors.has('branch_id') }">
                    <option value="">---Select Department---</option>
                    <option v-for="department in departments" v-bind:key="department.id" :value="department.id" >{{department.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="StaffData.email" :class="{'is-invalid' : StaffData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Personal Email Address</label>
                <input type="email" class="form-control" id="personal_email" name="personal_email" placeholder="Enter Email Address *" required v-model="StaffData.personal_email" :class="{'is-invalid' : StaffData.errors.has('personal_email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="StaffData.sex" :class="{'is-invalid' : StaffData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="StaffData.dob" :class="{'is-invalid' : StaffData.errors.has('dob') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Join Date</label>
                <input type="date" class="form-control" id="joined_at" name="joined_at" placeholder="Enter Email Address *" required v-model="StaffData.joined_at" :class="{'is-invalid' : StaffData.errors.has('joined_at') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Staff ID</label>
                <input type="text" class="form-control" id="unique_id" name="unique_id" required v-model="StaffData.unique_id" :class="{'is-invalid' : StaffData.errors.has('unique_id') }">
            </div>
        </div>
        <div class="col-md-4" v-show="editMode">
            <label>Profile Pic</label><br />
            <div class="user-block"><img class="img-circle" :src="user.user | profilePicture" /></div>
        </div>
        <div class="col-md-4" v-show="editMode">
            <label>Change Profile Pic</label>
            <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
        </div>
        <div class="col-md-4 col-sm-12" v-show="!editMode">
            <label>Profile Pic</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="password" name="password" required v-model="StaffData.password" :class="{'is-invalid' : StaffData.errors.has('password') }">
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="StaffData.id">
    </div>
    <button @click.prevent="editMode ? updateStaffData() : createStaffData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            user: {},
            StaffData: new Form({
                alt_phone:'', 
                area_id:'', 
                branch_id:'', 
                city:'', 
                department_id:'', 
                dob:'', 
                email:'',
                first_name: '', 
                id:'', 
                image:'', 
                joined_at: '',
                unique_id: '',
                last_name:'', 
                middle_name:'', 
                password:'', 
                personal_email: '', 
                phone:'', 
                roles:'',
                sex:'', 
                state_id:'', 
                street:'', 
                street2:'',
                unique_id: '', 
            }),
        }
    },
    mounted() {
        Fire.$on('StaffDataFill', user =>{
            this.user = user;
            this.StaffData.alt_phone = user.alt_phone; 
            this.StaffData.area_id = user.area_id; 
            this.StaffData.branch_id = user.branch_id; 
            this.StaffData.city = user.city; 
            this.StaffData.department_id = user.department_id; 
            this.StaffData.dob = user.user.dob; 
            this.StaffData.email = user.user.email;
            this.StaffData.first_name = user.user.first_name; 
            this.StaffData.id = user.id; 
            this.StaffData.image = user.user.image; 
            this.StaffData.joined_at = user.joined_at;
            this.StaffData.last_name = user.user.last_name;; 
            this.StaffData.middle_name = user.user.middle_name; 
            this.StaffData.password = user.user.password; 
            this.StaffData.personal_email = user.personal_email; 
            this.StaffData.phone = user.user.phone; 
            this.StaffData.sex = user.user.sex;
            this.StaffData.state_id = user.state_id; 
            this.StaffData.street = user.street; 
            this.StaffData.street2 = user.street2;
            this.StaffData.unique_id = user.user.unique_id;
        });
    },
    methods:{
        createStaffData(){
            this.$Progress.start();
            this.StaffData.post('/api/ums/staffs')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Staff has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
        updateStaffData(){
            this.$Progress.start();
            this.StaffData.put('/api/ums/staffs/'+ this.StaffData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User'+ response.data.user.first_name+' '+  response.data.user.last_name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });            
        },
        getProfilePic(){
            let photo = (this.StaffData.image.length >= 150) ? this.StaffData.image : "./"+this.StaffData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.StaffData.image = reader.result;
                    console.log(reader.result);
                    }
                reader.readAsDataURL(file)
            }
            else{
                Swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        },
    },
    props:{
        areas: Array,
        branches: Array, 
        departments: Array, 
        states: Array,
        editMode: Boolean,
    }
}
</script>
