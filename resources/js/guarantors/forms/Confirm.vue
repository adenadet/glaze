<template>
<section class="card">
    <form class="form" action="#" @submit.prevent="customerRegister">
        <div class="card-header">Guarantee A Loan</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12"><LoanDetailSummary /></div>
            </div>
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
                        <label>Other Name *</label>
                        <input type="text" required class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name *" v-model="confirmationData.middle_name" >
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
                        <input type="text" class="form-control" id="bvn" name="bvn" maxlength="11" placeholder="Bank Verification Number" v-model="confirmationData.bvn"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Marital Status</label>
                        <select type="text" class="form-control" id="marital_status" name="marital_status" v-model="confirmationData.marital_status">
                            <option value="">--Select Marital Status--</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nationality</label>
                        <select class="form-control" id="nationality_id" name="nationality_id" v-model="confirmationData.nationality_id">
                            <option value=''>--Select Nationality--</option>
                            <option v-for="nation in nations" :key="nation.id" :value="nation.id">{{ nation.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" v-model="confirmationData.dob"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="e" v-model="confirmationData.email"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" v-model="confirmationData.phone"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form--group">
                                <label>Residential Address</label>
                                <wysiwyg rows=3 v-model="confirmationData.official_address"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Office Email Address</label>
                                <input type="email" class="form-control" id="official_email" name="official_email" v-model="confirmationData.official_email"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Office Phone Number</label>
                                <input type="email" class="form-control" id="official_phone" name="official_phone" v-model="confirmationData.official_phone"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Office Address</label>
                                <wysiwyg rows=3 v-model="confirmationData.official_address"/>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
            <!--div class="row">
                <div class="col-sm-6">
                    <div class="form--group">
                        <label>Signature</label>
                        <VueSignature :options="options" class="signature" ref="signaturePad" v-model="confirmationData.signaturePad" />
                    </div>
                </div>   
            </div-->
            <button class="btn btn-success" type="submit">Guarantee Loan</button>
            <button class="btn btn-danger" type="button" @click="rejection()">Reject Request</button>
        </div>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            loan: {},
            confirmationData: new Form({
                id: '',
                loan_id:'', 
                first_name:'', 
                middle_name:'', 
                last_name:'', 
                bvn:'', 
                marital_status: '',
                dob: '',
                nationality_id: '',
                address: '',
                phone: '',
                email: '',
                official_address:'',
                official_email: '',
                position: '',
                official_phone: '',
                net_monthly_income: '',
                declaration: '',
                signaturePad: '',
            }),
            pad: 0,
			options:{
				penColor:"rgb(0, 0, 0)",
				backgroundColor:"rgb(255,255,255)",
			},
			
        }
    },
    mounted() {
        Fire.$on('AddressDataFill', base =>{
            this.address = base;
            base != null ? this.AddressData.fill(base) : this.AddressData.clear();
        });
    },
    methods:{
        undo(id) {this.$refs.signaturePad.undoSignature();},
		change() {this.options = {penColor: "#00f",};},
		resume() {this.options = {penColor: "#c0f",};},
		sign(id){this.$Progress.start();$('#signaturetModal').modal('show');this.$Progress.finish();},
		ClearFormData()
		{
			this.consentForm.signaturePad = "";
			//document.FORM1.sigRawData.value = "Base64 String: ";
			document.getElementById('SignBtn').disabled = false;
		},
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
        getInitials(){
            axios.get('/api/loans/accounts/staffs')
            .then(response => {
                this.loans = response.data.accounts;
                toast.fire({ icon: 'success', title: 'Loan Accounts loaded successfully', });
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({ icon: 'error', title: 'Loan Accounts not loaded successfully', });
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
    props:{},
}
</script>
