<template>
<section>
    <form>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"  v-model="bvnConfirmationData.first_name" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"  v-model="bvnConfirmationData.last_name" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"  v-model="bvnConfirmationData.first_name" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"  v-model="bvnConfirmationData.last_name" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>BVN</label>
                    <input type="text" class="form-control" id="bvn" name="bvn" size="11" maxlength="11" v-model="bvnConfirmationData.bvn" required>
                </div>
            </div>
        </div>
        <div class="row">
            <button class="col-md-3 btn btn-warning" @click="QoreIDCheck()" type="button">
                Check using QoreID
            </button>
            <button class="col-md-3 btn btn-success" @click="VerifyMeCheck()" type="button">
                Check using VerifyMe
            </button>
        </div>
        <div class="row" v-show="qore_used">
            <div class="col-7">
                <h2 class="lead"><b>Qore Verification</b></h2>
                <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span>First Name: {{qore.firstname}}</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span>Last Name: {{qore.lastname}}</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{qore.phone}}</li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-gender"></i></span> Sex: {{qore.phone}}</li>
                </ul>
            </div>
            <div class="col-5 text-center">
                <img src="/dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
            </div>
        </div>
            <div class="col-md-4"><div class="form-group"><label>First Name</label><div class="form-control" ></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Last Name</label><div class="form-control" v-html="qore.firstname"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Date of Birth</label><div class="form-control" v-html="qore.firstname"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="qore.firstname"></div></div></div>
            <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="qore.firstname"></div></div></div>
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
            user: {},
            qore: {},
            qore_used: false,
        }
    },
    methods:{
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
        getCreditScore(){},
    },
    mounted() {
        this.getInitials()
        Fire.$on('BasicDataFill', user => {
            this.user = user;
        });
        Fire.$on('BVNDataFill', confirmation => {

        });
    },
}
</script>