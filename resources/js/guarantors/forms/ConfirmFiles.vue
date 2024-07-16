<template>
    <section class="card row p-0 m-0 overlay-wrapper">
        <div class="overlay dark" v-if="loading"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
        <form class="" method="POST" @submit.prevent="guaranteeLoanFiles()">
            <div class="card-header"><h3 class="card-title">Upload Required Files</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bank Verification Number</label>
                            <input type="text" required class="form-control" id="bvn" name="bvn" maxlength="11" placeholder="Bank Verification Number" v-model="confirmationData.bvn"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>National Identification Number</label>
                            <input type="text" required class="form-control" id="nin" name="nin" maxlength="11" placeholder="National Identification Number" v-model="confirmationData.nin"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form--group">
                            <label>Valid Identification</label>
                            <input type="file" class="form-control" @change="addFile('valid_id', $event)" required/>
                            <input type="hidden" v-model="confirmationData.valid_id" id="guarantor_valid_id" name="guarantor_valid_id"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form--group">
                            <label>Proof of Address</label>
                            <input type="file" class="form-control" @change="addFile('address_proof', $event)" required/>
                            <input type="hidden" v-model="confirmationData.guarantor_valid_id" id="guarantor_address_proof" name="guarantor_address_proof"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Guarantee Loan</button>
            </div>
        </form>
    </section>    
</template>
<script>
export default {
    data(){
        return  {
            account: {},
            confirmationData: new Form({
                address_proof: '',
                address_proof_type: '',
                bvn: '',
                id: '',
                nin: '',
                valid_id: '',
                valid_id_type: '',
            }),
            editMode: false,
            guarantor: {},
            loading: false,
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
        Fire.$on('reloadGuarantorRequest', guarantor_request => {
            this.confirmationData.loan_id = guarantor_request.loan_id;
        });
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
                }
                reader.readAsDataURL(file)
            }
        },
        change() {
            this.options = {penColor: "#00f",};
        },
        guaranteeLoanFiles(){
            this.confirmationData.request_id = this.$route.params.id;
            this.loading = true;
            this.confirmationData.put('/api/guarantor_requests/'+this.$route.params.id) 
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Loan has been guaranteed',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.loading = false;
                Fire.$emit('reloadGuarantorConfirm', response);
            })
            .catch(()=>{
                this.loading = false;
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
            this.loading = true;
            this.rejectDatathis.confirmationData.post('/api/guarantor_requests/reject')
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Loan Guarantee Offer has been rejected',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.loading = false;
                this.$router.push('/requests/thanks');
            })
            .catch(()=>{
                this.loading = false;
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