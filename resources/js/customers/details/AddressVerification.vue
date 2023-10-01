<template>
<section>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Date of Visit</label>
                <div class="form-control" v-html="AddressConfirmationData.visit_date"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12" v-if="AddressConfirmationData.visit_date_2 != null">
            <div class="form-group">
                <label>Date of Visit 2 (if necessary)</label>
                <div class="form-control" v-html="AddressConfirmationData.visit_date_2"></div>
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
        <div class="col-md-8 col-sm-12" v-if="AddressConfirmationData.visit_update == 2">
            <div class="form-group">
                <label>New Address</label>
                <div class="border" v-html="AddressConfirmationData.alternate_address" ></div>
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
                <div class="form-control" v-html="AddressConfirmationData.met_with_name"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Relationship</label>
                <div class="form-control" v-html="AddressConfirmationData.met_with_relations"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Phone</label>
                <input class="form-control" v-html="AddressConfirmationData.met_with_phone">
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
            address:{},
            AddressConfirmationData: new Form({
                id: '',
                address_id: '',
                alternate_address: '',
                description: '',
                location_ease: '',
                met_with: '',
                met_with_name: '',
                met_with_relations: '',
                met_with_phone: '',
                remarks: '',
                visit_update: '',
                visit_date: '',
                visit_date_2: '',
            }),
        }
    },
    mounted() {
        Fire.$on('AddressDataFill', address =>{this.address = address;});     
        Fire.$on('AddressVerificationDataFill', requirement =>{if (requirement != null){this.AddressConfirmationData.fill(requirement);}});  
    },
    methods:{},
}
</script>
