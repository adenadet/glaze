<template>
<section>
    <form>
        <div class="row">
            <div class="col-md-4"><div class="form-group"><label>First Name</label><div class="form-control" v-html="user.first_name"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Middle Name</label><div class="form-control" v-html="user.middle_name"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Last Name</label><div class="form-control" v-html="user.last_name"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Date of Birth</label><div class="form-control" v-html="user.dob"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Phone Number</label><div class="form-control" v-html="user.phone"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="user.sex"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Email</label><div class="form-control" v-html="user.email"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>BVN</label><div class="form-control" v-html="user.bvn"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>National ID</label><div class="form-control" v-html="user.nin"></div></div></div>
        </div>
        <div class="row">
            <button class="col-md-3 btn btn-warning" @click="PericulumBVNCheck()" type="button">
                Check using Periculum
            </button>
        </div>
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
                    <wysiwyg rows="5" v-model="bvnConfirmationData.description"></wysiwyg>
                </div>
            </div>
        </div>
    </form>
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
            bvnConfirmationData: new Form({
                user_id: '',
                bvn:'', 
                confirmation_channel: '',
                confirmation: '',
            }),
            QoreForm: new Form({
                firstname: '',
                lastname: '',
                dob: '',
                email: '',
            }),
            qore: {},
            qore_used: false,
        }
    },
    methods:{
        PericulumBVNCheck(){
            this.$Progress.start();
            this.bvnConfirmationData.user_id = this.user.id;
            this.bvnConfirmationData.bvn = this.user.bvn;
            this.bvnConfirmationData.confirmation_channel = 'Periculum';
            this.bvnConfirmationData.confirmation = '';
            this.bvnConfirmationData.et =  this.periculumUser.dataTicket;

            this.bvnConfirmationData.post('/api/servers/periculum/bvn_check')
            .then(
                response => {
                    this.$Progress.finish();
                }
            )
            .catch(()=> {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'BVN Check failed',});
            });
        },
        QoreIDCheck(){
            this.QoreForm.firstname = user.first_name;
            this.QoreForm.lastname = user.last_name;
            this.QoreForm.dob = user.dob;
            this.QoreForm.phone = user.phone;
            this.QoreForm.email = user.email;

            this.QoreForm.post('https://qoreid.url/v1/ng/identities/bvn-basic/'+this.user.bvn)
            .then(response => {
                this.qore_used = true;
                this.qore_bvn = response.data.bvn;
                if (response.data.status.status == "verified"){

                }
            })
            .catch(()=>{

            })
        },
        VerifyMeCheck(){
            this.bvnConfirmationData
        },
        createConfirmation(){
            this.bvnConfirmationData.loan_id = this.user.id;
            this.bvnConfirmationData.post('/api/ums/bvn_confirmations')
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
        getInitials(){
            this.$Progress.start();
            axios.get('/api/ums/bvn_verifications/user/'+this.$route.params.id).
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
        user: Object,
    }
}
</script>