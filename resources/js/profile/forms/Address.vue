<template>
<div>
<form>
    <alert-error :form="AddressData"></alert-error> 
    <div class="row" v-if="source == 'staff'">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Customer Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="AddressData.first_name" :class="{'is-invalid' : AddressData.errors.has('first_name') }">
                <has-error :form="AddressData" field="first_name"></has-error> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="form-group">
                <label>Address Type</label>
                <select class="form-control" id="type" name="type" required v-model="AddressData.type" :class="{'is-invalid' : AddressData.errors.has('type') }">
                    <option value="">--Select Address Type--</option>
                    <option value="residential">Residential Address</option>
                    <option value="office">Office Address</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="AddressData.street" :class="{'is-invalid' : AddressData.errors.has('street') }" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street_2" name="street_2" placeholder="Enter Street Desc" v-model="AddressData.street_2" :class="{'is-invalid' : AddressData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="AddressData.city" :class="{'is-invalid' : AddressData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="AddressData.state_id" :class="{'is-invalid' : AddressData.errors.has('state_id') }" @change="updateLGAs">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" :key="state.StateCode" :value="state.StateCode" >{{state.StateName}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="AddressData.area_id" :class="{'is-invalid' : AddressData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in lgas" :key="area.LGANo" :value="area.LGANo" >{{area.LGAName}}</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="AddressData.id">
    </div>
    <button @click.prevent="(editMode && address != null) ? updateAddressData() : createAddressData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            address: {},
            AddressData: new Form({
                area_id:'', 
                city:'', 
                id:'', 
                state_id:'', 
                street:'', 
                street_2:'',
                type: '',
                user_id: '',
            }),
            lgas: [],
        }
    },
    mounted() {
        Fire.$on('AddressDataFill', base =>{
            if (base != null){
                this.AddressData.area_id = base.area.LGANo;
                this.AddressData.city = base.city;
                this.AddressData.id = base.id;
                this.AddressData.state_id = base.state.StateCode;
                this.AddressData.street = base.street;
                this.AddressData.street_2 = base.street_2;
                this.AddressData.type = base.type;
                this.AddressData.user_id = base.user_id;
                
                this.updateLGAs();
            } 
            else{ this.AddressData.clear();}
            
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
                Swal.fire({icon: 'success', title: 'The Address details has been created', showConfirmButton: false, timer: 1500});
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });          
        },
        getInitials(){

        },
        updateAddressData(){
            this.AddressData.user_id = this.user.id;
            this.$Progress.start();
            this.AddressData.put('/api/ums/addresses/'+this.AddressData.id)
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
        updateLGAs(){
            this.$Progress.start();
            axios.get('/api/ums/profile/states/'+this.AddressData.state_id)
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
        states: Array,
        user: Object,
        editMode: Boolean,
        source: String,
    },
}
</script>
