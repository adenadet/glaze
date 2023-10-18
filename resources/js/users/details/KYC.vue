<template>
<section>
    <!--{{ kyc_items}} 
    -->
    <div v-for="(item, index) in kyc_items" :key="item.id">
        <div class="row">
            <div class="col-12"><label>{{index | addOne}} {{ item.name }}</label></div>
            <table class="table table-sm" v-if="item.name == 'Address'">
                <tr>
                    <td>
                        <div class="form-control">
                            <span v-if="item.kyc_type == ''">Not Done</span>
                            <span v-else-if="item.kyc_type == 'power'">Power</span>
                            <span v-else-if="item.kyc_type == 'sanitation'">Sanitation</span>
                            <span v-else-if="item.kyc_type == 'water'">Water</span>
                            <span v-else>Not Done</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-control">
                            <a v-show="item.kyc_file != null" :href="'/uploads/kyc/'+item.kyc_file" target="_blank"><i class="fa fa-file mr-1"></i>View Attachment</a>
                            <span v-show="item.kyc_file == null">No Attachment</span>
                        </div>
                    </td>
                </tr>
            </table> 
            <table class="table table-sm" v-else-if="item.name == 'Identity Card'">
                <tr>
                    <td>
                        <label>Type</label>
                        <div class="form-control">
                            <span v-if="item.kyc_type =='national_id'">National ID</span>
                            <span v-else-if="item.kyc_type =='passport'">International Passport</span>
                            <span v-else-if="item.kyc_type =='drivers_license'">Driver's License</span>
                            <span v-else>Not Done</span>
                        </div>
                    </td>
                    <td>
                        <label>Number/ID</label>
                        <div class="form-control" :placeholder="'ID/Number of '+item.name" v-html="item.kyc_identification"></div>
                    </td>
                    <td>
                        <label>Expiry Date</label>
                        <div class="form-control" v-html="item.kyc_expiry_date" placeholder="expiry_date"></div>
                    </td>
                    <td>
                        <label>Uploaded File</label>
                        <div class="form-control">
                            <a v-show="item.kyc_file != null" :href="'/uploads/kyc/'+item.kyc_file" target="_blank"><i class="fa fa-file mr-1"></i>View Attachment</a>
                            <span v-show="item.kyc_file == null">No Attachment</span>
                        </div>
                    </td>
                </tr>
            </table> 
            <div class="col-md-12 mb-3" v-else>
                <hr class="m-0"/> 
                <div class="row mt-2">
                    <div class="col-3"><input type="text" class="form-control" required :placeholder="'Type of '+item.name" v-model="item.type"></div>
                    <div class="col-2"><input type="text" class="form-control" required :placeholder="'ID/Number of '+item.name" v-model="item.identification"></div>
                    <div class="col-2" v-if="kyc_items[index].expires == true"><input type="date" required class="form-control" v-model="item.expiry_date" placeholder="expiry_date"></div>
                    <div class="col-5" v-if="kyc_items[index].file == true"><input type="file" required class="form-control" @change="addFile(index, $event)">
                        <input type="hidden" name="file_name" id="file_name" v-model="item.file">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            kyc_items: [],
        }
    },
    mounted() {
        Fire.$on('KYCDataFIll', kyc_items => {
            this.kyc_items = kyc_items;
        });
    },
    methods:{
    },
    props:{
        user: Object,
    }
}
</script>
