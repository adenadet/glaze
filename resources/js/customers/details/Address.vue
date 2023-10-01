<template>
<section>
    <div class="row">
        <label for="divEmail3" class="col-sm-2 col-form-label">Address Type</label>
        <div class="col-sm-10"><div class="form-control">{{ AddressData.type | firstUp }}</div></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <div class="form-control" v-html="AddressData.street"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <div class="form-control" v-html="AddressData.street_2"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <div class="form-control" v-html="AddressData.city"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <div class="form-control">
                    <span v-if="AddressData.state_id == null">No LGA selected</span>
                    <span v-else-if="AddressData.state != null">{{AddressData.state.name}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>LGA</label>
                <div class="form-control">
                    <span v-if="AddressData.area_id == null">No LGA selected</span>
                    <span v-else-if="AddressData.area != null">{{AddressData.area.name}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Status</label>
                <div class="form-control">
                    <span v-if="AddressData.status == 1">Verified</span>
                    <span v-else-if="AddressData.status == 2"> Rejected</span>
                    <span v-else>Unverified</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Verified By:</label>
                <div class="form-control">
                    <span v-if="AddressData.confirmed_by == null">Unverified </span> 
                    <span v-else>{{ AddressData.verifier | FullName}}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Verified At:</label>
                <div class="form-control">{{ AddressData.confirmed_at | excelDate }}</div>
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
                verifier: {},  
                city:'', 
                id:'', 
                state: {},
                state_id:'',
                status: '', 
                street:'', 
                street_2:'',
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
    methods:{},
    props:{},
}
</script>
