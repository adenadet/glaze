<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guarantee A Loan</h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-danger" type="button" @click="toggleRequest()" v-if="!reject">Reject Request</button>
                        <button class="btn btn-sm btn-success" type="button" @click="toggleRequest()" v-if="reject">Approve Request</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Loan Summary</h3>
                                    
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-sm table-bordered table-hover table-stripped">
                                        <tbody>
                                            <tr>
                                                <td >Loan Name</td>
                                                <td colspan="3"><strong>{{ account.name }} [{{ account.unique_id }}]</strong></td>
                                                <td>Loan Type</td>
                                                <td><strong>{{ account.type ? account.type.name : 'Old Type' }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Requested By</td>
                                                <td colspan="3"><strong>{{ account.user | fullName }}</strong></td>
                                                <td>Requested On</td>
                                                <td><strong>{{ account.created_at | excelDate }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Amount</td>
                                                <td colspan="2"><strong>{{ account.amount | currency }}</strong></td>
                                                <td>Estimated Monthly Installment</td>
                                                <td><strong>{{ account.emi | currency }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" v-if="status == 'Pending'">
                        <form class="" method="POST" @submit.prevent="rejectLoan()" v-if="reject">
                            <div class="card-header">Guarantor's Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Title *</label>
                                            <input type="text" required class="form-control" id="title" name="title" placeholder="Title *" v-model="rejectData.title" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>First Name *</label>
                                            <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="rejectData.first_name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Other Name </label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name *" v-model="rejectData.middle_name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Last Name*</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="rejectData.last_name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="EMail address" v-model="rejectData.email" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" v-model="rejectData.phone" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form--group">
                                            <label>Comment</label>
                                            <wysiwyg rows=3 v-model="rejectData.description" required/>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger" type="submit">Reject Request</button>
                                <button class="btn btn-success" type="button" @click="toggleRequest()">Approve Request</button>
                            </div>
                        </form>
                        <form class="" method="POST" @submit.prevent="guaranteeLoan()" v-if="!reject">
                            <div class="card-header">Guarantor's Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Title *</label>
                                            <input type="text" required class="form-control" id="title" name="title" placeholder="Title *" v-model="confirmationData.title" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>First Name *</label>
                                            <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="confirmationData.first_name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Other Name </label>
                                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name *" v-model="confirmationData.middle_name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Last Name*</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="confirmationData.last_name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Bank Verification Number</label>
                                            <input type="text" required class="form-control" id="bvn" name="bvn" maxlength="11" placeholder="Bank Verification Number" v-model="confirmationData.bvn"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Marital Status</label>
                                            <select class="form-control" id="marital_status" required name="marital_status" v-model="confirmationData.marital_status">
                                                <option value="">--Select Marital Status--</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Relationship with Guarantee</label>
                                            <input type="text" class="form-control" id="relationship" name="relationship" v-model="confirmationData.relationship" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Annual Income Range</label>
                                            <select class="form-control" id="net_income"  required name="net_income" v-model="confirmationData.net_income">
                                                <option value="">--Select Net Income Range--</option>
                                                <option value="<500000">less than 500,000</option>
                                                <option value="500,000 - 2,000,000">500,000 - 1,000,000</option>
                                                <option value="500,000 - 2,000,000">1,000,000 - 10,000,000</option>
                                                <option value=">10000000">greater than 10,000,000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nationality</label>
                                                    <select class="form-control" id="nationality_id" required name="nationality_id" v-model="confirmationData.nationality_id">
                                                        <option value=''>--Select Nationality--</option>
                                                        <option v-for="nation in nations" :key="nation.id" :value="nation.id">{{ nation.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" v-model="confirmationData.dob" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Personal EMail Address" v-model="confirmationData.email" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" v-model="confirmationData.phone" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form--group">
                                                    <label>Residential Address</label>
                                                    <wysiwyg rows=3 v-model="confirmationData.residential_address" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Employer</label>
                                                    <input type="text" class="form-control" id="employer" name="employer" v-model="confirmationData.employer" placeholder="Employer / Business Name" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Office Email Address</label>
                                                    <input type="email" class="form-control" id="employer_email" name="employer_email" v-model="confirmationData.employer_email" placeholder="Office EMail Address" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Office Phone Number</label>
                                                    <input type="number" class="form-control" id="employer_phone" name="employer_phone" v-model="confirmationData.employer_phone"  placeholder="Office Phone NUmber" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Office Address</label>
                                                    <wysiwyg rows=3 v-model="confirmationData.employer_address"  required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form--group">
                                            <label>Passport Photograph</label>
                                            <input type="file" class="form-control" @change="addFile('passport', $event)" required/>
                                            <input type="hidden" v-model="confirmationData.passport" id="guarantor_passport" name="guarantor_passport"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form--group">
                                            <label>Valid Identification</label>
                                            <input type="file" class="form-control" @change="addFile('valid_id', $event)" required/>
                                            <input type="hidden" v-model="confirmationData.valid_id" id="guarantor_valid_id" name="guarantor_valid_id"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form--group">
                                            <label>Proof of Address</label>
                                            <input type="file" class="form-control" @change="addFile('address_proof', $event)" required/>
                                            <input type="hidden" v-model="confirmationData.guarantor_valid_id" id="guarantor_address_proof" name="guarantor_address_proof"/>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form--group">
                                            <label>Comment</label>
                                            <wysiwyg rows=3 v-model="confirmationData.description" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form--group">
                                            <label>Signature</label>
                                            <VueSignaturePad :options="options" class="signature" ref="signaturePad" v-model="confirmationData.guarantor_signature" required />
                                            <div class="btn-group mt-2">
                                                <button @click="undo" class="btn btn-sm btn-default">Undo</button>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <button class="btn btn-success" type="submit">Guarantee Loan</button>
                                <button class="btn btn-danger" type="button" @click="toggleRequest()">Reject Request</button>
                            </div>
                        </form>
                    </div> 
                    <div class="card" v-else>
                        <div class="card-header">Processed Request</div>
                        <div class="card-body" v-html="message"></div>
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
            account: {},
            confirmationData: new Form({
                address: '',
                address_proof: '',
                address_proof_type: '',
                bvn: '',
                description: '',
                dob: '',
                email: '',
                employer: '',
                employer_address: '',
                employer_email: '',
                employer_phone: '',
                first_name: '',
                gender: '',
                id: '',
                loan_id: '',
                last_name: '',
                marital_status: '',
                middle_name: '',
                net_income: '',
                passport: '',
                passport_type: '',
                phone: '',
                relationship: '',
                request_id: '',
                residential_address: '',
                signature: '',
                status: '',
                title: '',
                valid_id: '',
                valid_id_type: '',
            }),
            editMode: false,
            guarantor: {},
            message: '',
            nations: [],
            options:{
				penColor:"rgb(0,0,255)",
				backgroundColor:"rgb(255,255,255)",
			},
            pad: 0,
            reject: false,
            rejectData: new Form({
                comment: '',
                email: '',
                first_name: '',
                last_name: '',
                other_name: '',
                phone: '',
                request_id: '',
                title: '',
            }),
            status: '',
        }
    },
    mounted() {
        this.getInitials();
    },
    methods:{
        addFile(fileKey, event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            if (file['size'] > 2000000){
                Swal.fire({icon: 'error', title: 'File is too large'});
            }
            else if((file['type'] != 'image/png') && (file['type'] != 'image/jpg') && (file['type'] != 'image/jpeg') && (file['type'] != 'application/pdf')){
                Swal.fire({icon: 'error', title: 'Invalid File Type'});
            }
            else{
                reader.onloadend = (event) => {
                    if (fileKey == 'address_proof'){
                        this.confirmationData.address_proof = reader.result;
                        this.confirmationData.address_proof_type = ((file['type'] == 'image/png') || (file['type'] == 'image/jpg') || (file['type'] == 'image/jpeg')) ? 'Image': 'PDF';
                    }
                    else if (fileKey == 'passport'){
                        this.confirmationData.passport = reader.result;
                        this.confirmationData.passport_type = ((file['type'] == 'image/png') || (file['type'] == 'image/jpg') || (file['type'] == 'image/jpeg')) ? 'Image': 'PDF';
                    }
                    else if (fileKey == 'valid_id'){
                        this.confirmationData.valid_id = reader.result;
                        this.confirmationData.valid_id_type = ((file['type'] == 'image/png') || (file['type'] == 'image/jpg') || (file['type'] == 'image/jpeg')) ? 'Image': 'PDF';
                    }
                    console.log(fileKey);
                    console.log(reader.result);
                }
                reader.readAsDataURL(file)
            }
        },
        change() {
            this.options = {penColor: "#00f",};
        },
        getInitials(){
            axios.get('/api/guarantor_requests/'+this.$route.params.id)
            .then(response => {
                this.loadPage(response);
                toast.fire({ icon: 'success', title: 'Loan Accounts loaded successfully', });
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({ icon: 'error', title: 'Loan Accounts not loaded successfully', });
            });
        },
        guaranteeLoan(){
            this.confirmationData.request_id = this.$route.params.id;
            //this.save();
            this.confirmationData.post('/api/guarantor_requests') 
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Loan has been guaranteed',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$router.push('/requests/thanks');
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            })
        },
        loadPage(response){
            this.account = response.data.account;
            this.nations = response.data.nations;
            this.status = response.data.status;
            this.message = response.data.message;
        },
        rejectLoan(){
            this.rejectData.request_id = this.$route.params.id;
            this.rejectDatathis.confirmationData.post('/api/guarantor_requests/reject')
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Loan Guarantee Offer has been rejected',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$router.push('/requests/thanks');
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            })
        },
        resume() {
            this.options = {penColor: "#00f",};
        },
        save() {
            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
            this.confirmationData.guarantor_signature = data;
        },
        toggleRequest(){
            this.reject = !this.reject;
        },
        undo() {
            this.$refs.signaturePad.undoSignature();
        }
    },
    props:{},
}
</script>
<style>
.signature {
	border: double 3px transparent;
	border-radius: 5px;
	background-image: linear-gradient(white, white), radial-gradient(circle at top left, #4bc5e8, #9f6274);
	background-origin: border-box;
	background-clip: content-box, border-box;
	height: 300px;
}

.container {
    width: "100%";
    padding: 8px 16px;
}

.buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 8px;
}
</style>
