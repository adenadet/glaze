<template>
<section  v-if="guarantor != null">
    <div class="card">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Title *</label>
                    <div class="form-control" id="title" name="title" placeholder="Title *" v-html="guarantor.title" ></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>First Name *</label>
                    <div class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-html="guarantor.first_name" ></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Other Name </label>
                    <div class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name *" v-html="guarantor.middle_name" ></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Last Name*</label>
                    <div class="form-control" id="last_name" name="last_name" placeholder="Last Name *" v-html="guarantor.last_name"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Bank Verification Number</label>
                    <div class="form-control" id="bvn" name="bvn" maxlength="11" placeholder="Bank Verification Number" v-html="guarantor.bvn"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Marital Status</label>
                    <div class="form-control">
                        {{guarantor.marital_status | firstUp}}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Relationship with Guarantee</label>
                    <div class="form-control" id="relationship" name="relationship" v-html="guarantor.relationship" ></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Annual Income Range</label>
                    <div class="form-control" id="net_income"  name="net_income" >
                        <span v-if="guarantor.net_income= '<500000'">less than 500,000</span>
                        <span v-else-if="guarantor.net_income= '500,000 - 2,000,000'">500,000 - 1,000,000</span>
                        <span v-else-if="guarantor.net_income= '500,000 - 2,000,000'">1,000,000 - 10,000,000</span>
                        <span v-else-if="guarantor.net_income= '>10000000'">greater than 10,000,000</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nationality</label>
                            <div class="form-control" id="nationality_id" name="nationality_id">
                                {{guarantor.nationality != null ? guarantor.nationality.name : 'Not Chosen'}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <div type="date" class="form-control" id="dob" name="dob" v-html="guarantor.dob"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="form-control" id="email" name="email" placeholder="e" v-html="guarantor.email"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <div class="form-control" id="phone" name="phone" placeholder="Phone Number" v-html="guarantor.phone"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form--group">
                            <label>Residential Address</label>
                            <div rows=3 v-html="guarantor.official_address"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Employer</label>
                            <div class="form-control" id="employer" name="employer" v-html="guarantor.employer"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Office Email Address</label>
                            <div type="email" class="form-control" id="employer_email" name="employer_email" v-html="guarantor.employer_email"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Office Phone Number</label>
                            <div type="number" class="form-control" id="employer_phone" name="employer_phone" v-html="guarantor.employer_phone"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Office Address</label>
                            <div rows=3 v-html="guarantor.employer_address" ></div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form--group">
                    <label>Comment</label>
                    <div rows=3 v-html="guarantor.description"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form--group">
                    <label>Signature</label>
                    <img :src="guarantor.signature != null ? confirmation.signature : ''" />
                </div>
            </div>   
        </div>
    </div>
</section>
<section v-else>
    <p>Select Guarantor To View</p>
</section>
</template>
<script>
export default {
    data(){
        return  {
            guarantor: {},
        }
    },
    mounted() {
        Fire.$on('GuarantorDataFill', guarantor => {
            this.guarantor = guarantor;
            alert(guarantor.first_name);
        });
    },
    methods:{
        
    },
    props:{
        
    },
}
</script>