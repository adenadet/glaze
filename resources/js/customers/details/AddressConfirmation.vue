<template>
<section>
    <div class="row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Address Type</label>
        <div class="col-sm-10"><div class="form-control" ></div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Date of Visit</label>
                <div type="date" class="form-control" id="visit_date" name="visit_date" placeholder="New text" v-html="AddressConfirmationData.visit_date"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Date of Visit 2 (if necessary)</label>
                <div type="date" class="form-control" id="visit_date" name="visit_date" placeholder="Re-enter New text" v-html="AddressConfirmationData.visit_date_2"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Visit Update</label>
                <div class="form-control">
                    <span v-if="AddressConfirmationData.visit_update == 1">Found Address Correct as Provided</span>
                    <span v-else-if="AddressConfirmationData.visit_update == 2">Wrong Address and needs to be changed to</span>
                    <span v-else-if="AddressConfirmationData.visit_update == 3">Address Does Not Exist</span>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="form-group">
                <label>New Address</label>
                <div id="alternate_address" name="alternate_address" placeholder="Enter the alternate address" v-html="AddressConfirmationData.alternate_address" ></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Met With</label>
                <div class="form-control">
                    <span v-if="AddressConfirmationData.met_with == 'customer'">Customer</span>
                    <span v-else-if="AddressConfirmationData.met_with == 'relative'">Relative</span>
                    <span v-else-if="AddressConfirmationData.met_with == 'neighbour'">Neighbour</span>
                    <span v-else-if="AddressConfirmationData.met_with == 'no one'">Meet with No One</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Name</label>
                <div class="form-control" id="met_with_name" name="met_with_name" placeholder="Name of Person met with" v-html="AddressConfirmationData.met_with_name"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Relationship</label>
                <div type="text" class="form-control" id="met_with_relations" name="met_with_relations" placeholder="Relationship" v-html="AddressConfirmationData.met_with_relations"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" id="met_with_phone" name="met_with_phone" placeholder="Phone" v-html="AddressConfirmationData.met_with_phone">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Ease of Location</label>
                <div class="form-control">
                    <span v-if="AddressConfirmationData.location_ease == 'easy'">Easy</span>
                    <span v-else-if="AddressConfirmationData.location_ease == 'intermediate'">Intermediate</span>
                    <span v-else-if="AddressConfirmationData.location_ease == 'difficult'">Difficult</span>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="form-group">
                <label>Description</label>
                <div class="border p-2" v-html="AddressConfirmationData.description"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Other Remarks</label>
                <div class="border p-2" v-html="AddressConfirmationData.remarks"></div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            address: {},
            AddressData: new Form({
                area: {},
                area_id:'',
                confirmed_at: '',
                confirmed_by: '',
                confirmer: {},  
                city:'', 
                id:'', 
                state: {},
                state_id:'',
                status: '', 
                street:'', 
                street2:'',
                user_id: '',
                type: '',
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
