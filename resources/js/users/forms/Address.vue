<template>
<div>
<form>
    <alert-error :form="AddressData"></alert-error> 
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status" name="status" placeholder="First Name *" v-model="AddressData.status" :class="{'is-invalid' : AddressData.errors.has('status') }">
                    <option value="">--Verified Status--</option>
                    <option value="1"> BVN Verified</option>
                    <option value="0"> BVN Unverified</option>
                </select>
                <has-error :form="AddressData" field="status"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Verified By:</label>
                <select class="form-control" id="verified_by" name="verified_by" placeholder="middle Name" v-model="AddressData.verified_by" :class="{'is-invalid' : AddressData.errors.has('verified_by') }">
                    <option value="">--Select Staff Name</option>
                    <option v-for="staff in staffs" :key="staff.id" :value="staff.id">{{staff | FullName}}</option>
                </select>
                <has-error :form="AddressData" field="verified_by"></has-error> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Verified At:</label>
                <input type="text" class="form-control" id="verified_at" name="verified_at" placeholder="middle Name" v-model="AddressData.verified_at" :class="{'is-invalid' : AddressData.errors.has('verified_at') }"/>
                <has-error :form="AddressData" field="verified_at"></has-error> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="AddressData.street" :class="{'is-invalid' : AddressData.errors.has('street') }" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="AddressData.street2" :class="{'is-invalid' : AddressData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="AddressData.city" :class="{'is-invalid' : AddressData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="AddressData.state_id" :class="{'is-invalid' : AddressData.errors.has('state_id') }" @change="updateLGA">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" :key="state.StateCode" :value="state.StateCode" >{{state.StateName}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="AddressData.area_id" :class="{'is-invalid' : AddressData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in areas" v-bind:key="area.LGANo" :value="area.LGANo" >{{area.LGAName}}</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="AddressData.id">
    </div>
    <button @click.prevent="editMode ? updateAddressData() : createAddressData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            AddressData: new Form({
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
            lgas: [],
        }
    },
    mounted() {
        Fire.$on('AddressDataFill', user =>{
            this.AddressData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.AddressData.fill(data)));
        });
    },
    methods:{
        createAddressData(){
            this.$Progress.start();
            alert("Not supposed to be here");
            this.AddressData.post('/api/ums/users')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User '+ response.data.user.first_name+' '+  response.data.user.last_name+' has been created',
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
        updateAddressData(){
            alert("Working");
            this.$Progress.start();
            this.AddressData.put('/api/ums/users/'+ this.AddressData.id)
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
        updateLGAs(){
            this.$Progress.start();
            axios.get('/api/ums/profile/states/'+ this.AddressData.state_id)
            .then(response =>{
                this.$Progress.finish();
                this.lgas = response.data.areas;
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
    },
    props:{
        areas: Array,
        branches: Array, 
        departments: Array,
        staffs: Array, 
        states: Array,
        user: Object,
        editMode: Boolean,
    }
}
</script>
