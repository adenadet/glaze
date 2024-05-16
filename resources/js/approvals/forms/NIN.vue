<template>
<section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Confirm {{ type | firstUp }} nin</h3>
            <div class="card-tools">
                <button class="btn btn-warning btn-sm" @click="PericulumninCheck()" type="button">
                    Check using Periculum
                </button>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-4"><div class="form-group"><label>First Name</label><div class="form-control" v-html="qore.firstname"></div></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Last Name</label><div class="form-control" v-html="qore.lastname"></div></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Date of Birth</label><div class="form-control" v-html="qore.dateofbirth"></div></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Phone Number</label><div class="form-control" v-html="qore.fphone"></div></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="qore.gender"></div></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Email</label><div class="form-control" v-html="qore.email"></div></div></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comments</label>
                            <wysiwyg rows="5" v-model="ninConfirmationData.description"></wysiwyg>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-success" type="button" @click="createConfirmation">Confirm NIN</button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-danger"  type="button" @click="rejectConfirmation">Reject NIN</button>
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
            actions: [],
            account: {},
            current: {},
            loan_types: [],
            ninConfirmationData: new Form({user_id: '', nin:'', confirmation_channel: '', confirmation: '', token: ''}),
            QoreForm: new Form({firstname: '', lastname: '', dob: '', email: ''}),
            qore: {},
            qore_used: false,
        }
    },
    methods:{
        PericulumninCheck(){
            this.$Progress.start();
            this.ninConfirmationData.user_id = this.user.id;
            this.ninConfirmationData.nin = this.user.nin;
            this.ninConfirmationData.confirmation_channel = 'Periculum';
            this.ninConfirmationData.confirmation = '';
            this.ninConfirmationData.token =  this.periculumUser.et;
            
            this.ninConfirmationData.post('/api/servers/periculum/nin_check')
            .then(
                response => {this.$Progress.finish();}
            )
            .catch(()=> {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'nin Check failed',});
            });
        },
        QoreIDCheck(){
            this.QoreForm.firstname = user.first_name;
            this.QoreForm.lastname = user.last_name;
            this.QoreForm.dob = user.dob;
            this.QoreForm.phone = user.phone;
            this.QoreForm.email = user.email;

            this.QoreForm.post('https://qoreid.url/v1/ng/identities/nin-basic/'+this.user.nin)
            .then(response => {
                this.qore_used = true;
                this.qore_nin = response.data.nin;
                if (response.data.status.status == "verified"){

                }
            })
            .catch(()=>{

            })
        },
        VerifyMeCheck(){
            this.ninConfirmationData
        },
        createConfirmation(){
            this.ninConfirmationData.loan_id = this.user.id;
            this.ninConfirmationData.post('/api/ums/nin_confirmations')
            .then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'New Requirement was created successfully',
                });
                this.ninConfirmationData.reset();
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
        getInitials(){
            this.$Progress.start();
            axios.get('/api/ums/nin_verifications/user/'+this.$route.params.id).
            then(response =>{
                this.reloadPage(response);
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
            this.ninConfirmationData.loan_id = this.user.id;
            this.ninConfirmationData.post('/api/ums/nin_confirmations/reject')
            .then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'NIN was rejected successfully, the user has been notified',
                });
                this.ninConfirmationData.reset();
                this.$router.push('/staff/confirm/nins');
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
        //this.getInitials()
        Fire.$on('BasicDataFill', user => {
            this.user = user;
        });

    },
    props:{
        type: String,
        user: Object
    }
}
</script>