<template>
<section class="overlay-wrapper">

    <form>
    <alert-error :form="EmploymentData"></alert-error> 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Employer's Name *</label>
                <input type="text" required class="form-control" id="name" name="name" placeholder="Employer's Name *" v-model="EmploymentData.name" :class="{'is-invalid' : EmploymentData.errors.has('name') }">
                <has-error :form="EmploymentData" field="name"></has-error> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Status</label>
                <input type="text" class="form-control" id="employment_status" name="employment_status" v-model="EmploymentData.employment_status" :class="{'is-invalid' : EmploymentData.errors.has('status') }"/>
                <has-error :form="EmploymentData" field="employment_status"></has-error> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Last Name *" required v-model="EmploymentData.start_date" :class="{'is-invalid' : EmploymentData.errors.has('start_date') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label>Address</label>
                <input type="text" required class="form-control" id="employer_address" name="employer_address" placeholder="Employer's Address" v-model="EmploymentData.employer_address" :class="{'is-invalid' : EmploymentData.errors.has('address') }">
                <has-error :form="EmploymentData" field="employer_address"></has-error> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="employer_state_id" name="employer_state_id" required v-model="EmploymentData.employer_state_id" :class="{'is-invalid' : EmploymentData.errors.has('employer_state_id') }" @change="updateLGAs">
                    <option value="">--Select Local Government</option>
                    <option v-for="state in states" :value="state.StateCode" :key="state.StateCode">{{ state.StateName }}</option> 
                </select>
                <has-error :form="EmploymentData" field="employment_state_id"></has-error> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Local Government Area</label>
                <select class="form-control" id="employer_lga_id" name="employer_lga_id" required v-model="EmploymentData.employer_lga_id" :class="{'is-invalid' : EmploymentData.errors.has('employer_lga_id') }">
                    <option value="">--Select Local Government</option>
                    <option v-for="area in lgas" :value="area.LGANo" :key="area.LGANo">{{ area.LGAName }}</option> 
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>City</label>
                <input type="text" class="form-control" id="city" name="city" v-model="EmploymentData.city" :class="{'is-invalid' : EmploymentData.errors.has('city') }"/>
                <has-error :form="EmploymentData" field="city"></has-error> 
            </div>
        </div>  
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="employer_phone" name="employer_phone" placeholder="Enter employer_Phone Number *" required v-model="EmploymentData.employer_phone" :class="{'is-invalid' : EmploymentData.errors.has('employer_phone') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="employer_email" name="employer_email" placeholder="Enter Email Address *" required v-model="EmploymentData.employer_email" :class="{'is-invalid' : EmploymentData.errors.has('employer_email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Sector</label>
            <div class="form-group">
                <select name="employer_sector_code" id="employer_sector_code" class="form-control" v-model="EmploymentData.employer_sector_code" :class="{'is-invalid' : EmploymentData.errors.has('employer_sector_code') }">
                    <option value="">--Select Employer Sector--</option>
                    <option v-for="sector in sectors" :value="sector.SectorCode" :key="sector.SectorCode">{{ sector.SectorName }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tax No</label>
                <input type="text" class="form-control" id="tax_no" name="tax_no" required v-model="EmploymentData.tax_no" :class="{'is-invalid' : EmploymentData.errors.has('tax_no') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Pension Number</label>
                <input type="text" name="pension_number" id="pension_number" class="form-control" placeholder="Birth Date" v-model="EmploymentData.pension_number" :class="{'is-invalid' : EmploymentData.errors.has('pension_number') }">
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
                customer_id:'',
                user_id:'',
                name:'',
                employment_date:'',
                educational_level:'',
                employment_status:'',
                employer_lga_id:'',
                employer_state_id: '',
                landmark:'',
                monthly_income:'',
                pay_day:'',
                pension_number:'',
                tax_no:'',
                employer_telephone_no:'',
                employer_sector_code:'',
                staff_id:'',
                employer_address:'',
                employer_city:'',
                employer_email:'',
                status:'',
                end_date:'',
            }),
            lgas: {},
        }
    },
    mounted() {
        Fire.$on('BasicDataFill', user =>{
            this.EmploymentData.fill(user);
            console.log("Get Here");
        });
    },
    methods:{
        getProfilePic(){
            let photo = (this.EmploymentData.image.length >= 150) ? this.EmploymentData.image : "./"+this.EmploymentData.image;
            return photo;
            },
        updateEmploymentData(){
            this.$Progress.start();
            this.loading = true;
            this.EmploymentData.post('/api/ums/profile/employee')
            .then(response =>{
                this.$Progress.finish();
                this.loading = false;
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
                    showConfirmButton: false,
                    timer: 1500
                    });
                })
            .catch(()=>{
                this.loading = false;
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });          
        },
        updateLGAs(){
            this.$Progress.start();
            axios.get('/api/ums/profile/states/'+this.EmploymentData.employer_state_id)
            .then(response =>{
                this.$Progress.finish();
                this.lgas = response.data.lgas;
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });
        },
    },
    props:{
        areas: Array,
        editMode: Boolean,
        nations: Array,
        sectors: Array,
        states: Array,
        user: Object,
        
    }
}
</script>