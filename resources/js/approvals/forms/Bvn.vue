<template>
<section class="overlay-wrapper">
    <div class="overlay" v-if="loading"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Confirm {{ type | firstUp }} {{verify}}</h3>
            <div class="card-tools">
                <button class="btn btn-warning btn-xs" @click="PericulumBVNCheck()" type="button" v-if="verify == 'BVN'">
                    Check using Periculum
                </button>
                <button class="btn btn-warning btn-xs" @click="PericulumNINCheck()" type="button" v-if="verify == 'NIN'">
                    Check using Periculum
                </button>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4"><div class="form-group"><label>Last Name</label><div class="form-control" v-html="qoreForm.last_name"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>First Name</label><div class="form-control" v-html="qoreForm.first_name"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Other Names</label><div class="form-control" v-html="qoreForm.other_name"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Date of Birth</label><div class="form-control" v-html="qoreForm.dob"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Phone Number</label><div class="form-control" v-html="qoreForm.phone"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="qoreForm.sex"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Email</label><div class="form-control" v-html="qoreForm.email"></div></div></div>
                            <div class="col-md-4"><div class="form-group"><label>BVN</label><div class="form-control" v-html="qoreForm.bvn"></div></div></div> 
                            <div class="col-md-4"><div class="form-group"><label>NIN</label><div class="form-control" v-html="qoreForm.nin"></div></div></div>        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img :src="qoreForm.image != '' ? qoreForm.image : '/img/profile/default.png'" class="img-fluid" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comments</label>
                            <wysiwyg rows="5" v-model="bvnConfirmationData.description" required></wysiwyg>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-block btn-success" type="button" @click="createConfirmation('bvn&nin')">Confirm BVN and NIN</button>
                    </div>
                    <div class="col-md-3" v-if="verify == 'BVN'">
                        <button class="btn btn-block btn-info" type="button" @click="createConfirmation('bvn')">Confirm BVN only</button>
                    </div>
                    <div class="col-md-3" v-if="verify == 'NIN'">
                        <button class="btn btn-block btn-primary" type="button" @click="createConfirmation('nin')">Confirm NIN only</button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-block btn-danger"  type="button" @click="rejectConfirmation()">Reject details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</template>
<script>
export default {
    created(){
        this.$store.dispatch('periculum/loginUser');
	},
    computed:{
        periculumUser: {
            get(){
                return this.$store.state.periculum.user;
            }
        }
    },
    data(){
        return {
            bvnConfirmationData: new Form({user_id: '', bvn:'', confirmation_channel: '', confirmation: '', token: ''}),
            loading: false,
            qoreForm: new Form({
                bvn: '',
                comment: '',
                confirmation_channel: '',
                dob: '', 
                email: '',
                first_name: '', 
                image: '',
                last_name: '',
                nin: '',
                other_name: '',
                phone: '', 
                point: '',
                response: '',
                sex: '',
            }),
            qore_used: false,
        }
    },
    methods:{
        PericulumBVNCheck(){
            this.$Progress.start();
            this.loading = true;
            if (this.user.bvn == null ||this.user.bvn == ''){
                Swal.fire({
                    icon: 'error',
                    title: 'No BVN has been submitted',
                });
                return;
            }
            this.bvnConfirmationData.bvn = this.user.bvn;
            this.bvnConfirmationData.token =  this.periculumUser.et;
            this.bvnConfirmationData.post('/api/servers/periculum/bvn_check')
            .then(
                response => {
                    this.qoreForm.bvn = response.data.bvn;
                    this.qoreForm.confirmation_channel = "Periculum";
                    this.qoreForm.dob = response.data.dateOfBirth; 
                    this.qoreForm.email = response.data.email;
                    this.qoreForm.first_name = response.data.firstName; 
                    this.qoreForm.last_name = response.data.lastName;
                    this.qoreForm.other_name = response.data.middleName;
                    this.qoreForm.phone = response.data.phoneNumber1+' | '+response.data.phoneNumber2;
                    this.qoreForm.sex = response.data.gender;
                    this.qoreForm.nin = response.data.nin;
                    this.qoreForm.response = JSON.stringify(response.data, null, 2);
                    this.qoreForm.image = 'data:image/jpeg;base64,'+response.data.photo;
                    this.loading = false;
                    this.$Progress.finish();
                }
            )
            .catch(()=> {
                this.$Progress.fail();
                this.loading = false;
                toast.fire({icon: 'error', title: 'BVN Check failed',});
            });
        },
        PericulumNINCheck(){
            this.$Progress.start();
            if (this.user.nin == null ||this.user.nin == ''){
                Swal.fire({
                    icon: 'error',
                    title: 'No NIN has been submitted',
                });
                return;
            }
            this.loading = true;
            this.bvnConfirmationData.nin = this.user.nin;
            this.bvnConfirmationData.token =  this.periculumUser.et;
            this.bvnConfirmationData.post('/api/servers/periculum/nin_check')
            .then(response => {
                if(response.data.message )
                this.qoreForm.bvn = response.data.bvn;
                this.qoreForm.confirmation_channel = "Periculum";
                this.qoreForm.dob = response.data.dateOfBirth; 
                this.qoreForm.email = response.data.email;
                this.qoreForm.first_name = response.data.firstName; 
                this.qoreForm.last_name = response.data.lastName;
                this.qoreForm.other_name = response.data.middleName;
                this.qoreForm.phone = response.data.phoneNumber1+' | '+response.data.phoneNumber2;
                this.qoreForm.sex = response.data.gender;
                this.qoreForm.nin = response.data.nin;
                this.qoreForm.response = JSON.stringify(response.data, null, 2);
                this.qoreForm.image = 'data:image/jpeg;base64,'+response.data.photo;
                this.loading = false;
                this.$Progress.finish();
            })
            .catch(()=> {
                this.$Progress.fail();
                this.loading = false;
                toast.fire({icon: 'error', title: 'BVN Check failed',});
            });
        },
        VerifyMeCheck(){
            //this.bvnConfirmationData
        },
        createConfirmation(items){
            this.loading = true;
            this.qoreForm.items = items;
            this.qoreForm.point = this.type;
            this.qoreForm.validation_id = this.user.id;
            this.qoreForm.post('/api/ums/bvn_verifications')
            .then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'BVN was verified successfully',
                });
                this.bvnConfirmationData.reset();
                this.$router.push('/staff/confirm/bvns');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
                this.loading = false;
            });
        },
        getInitials(){
            this.loading = true;
            this.$Progress.start();
            axios.get('/api/ums/bvn_verifications/user/'+this.$route.params.id).
            then(response =>{
                this.reloadPage(response);
                this.loading = false;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Accounts was not loaded successfully',
                })
            });
        },
        rejectConfirmation(){
            this.bvnConfirmationData.loan_id = this.user.id;
            this.bvnConfirmationData.post('/api/ums/bvn_confirmations/reject')
            .then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'New Requirement was created successfully',
                });
                this.bvnConfirmationData.reset();
                this.$router.push('/staff/confirm/loans');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        },
        reloadPage(response){
            this.user = response.data.user;
        },
    },
    mounted() {
    },
    props:{
        type: String,
        user: Object,
        verify: String,
    }
}
</script>