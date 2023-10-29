<template>
<section>
<div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <div type="text" required class="form-control" v-html="BioData.first_name"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <div type="text" class="form-control" v-html="BioData.middle_name"></div> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <div type="text" class="form-control" v-html="BioData.last_name" ></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <div type="text" class="form-control" v-html="BioData.email"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <div type="text" class="form-control" v-html="BioData.phone"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Bank Verification Number</label>
                <div type="text" class="form-control" id="bvn" name="bvn" v-html="BioData.bvn"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <div class="form-control" id="sex" name="sex">
                    <span v-if="BioData.sex == ''">---Select Sex---</span>
                    <span v-else-if="BioData.sex == 'Female'">Female</span>
                    <span v-else-if="BioData.sex == 'Male'">Male</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <div name="dob" id="dob" class="form-control" v-html="BioData.dob"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Status</label>
                <div class="form-control">
                    <span v-if="BioData.status == null">--Verified Status--</span>
                    <span v-else-if="BioData.status == 1"> BVN Verified</span>
                    <span v-if="BioData.status == 0"> BVN Unverified</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Verified By:</label>
                <div class="form-control" id="verified_by" name="verified_by"  :class="{'is-invalid' : BioData.errors.has('verified_by') }">
                    {{BioData.verified_by | FullName}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Verified At:</label>
                <div type="text" class="form-control" v-html="BioData.verified_at"></div> 
            </div>
        </div>
    </div>
    <input type="hidden" name="id" id="id" v-model="BioData.id">
</div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            BioData: new Form({
                bvn: '',
                dob:'', 
                email:'',
                first_name: '', 
                id:'', 
                image:'', 
                last_name:'', 
                middle_name:'', 
                phone:'', 
                sex:'',
                status: '',
                user_id: '',
                verified_by: '',
                verified_at: '',
                unique_id: '', 
            }),
            user: {}
        }
    },
    mounted() {
        Fire.$on('BioDataFill', user =>{
            this.BioData.fill(user);
            this.user = user
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.BioData.fill(data)));
        });
    },
    methods:{
        createBioData(){
            console.log("Working book");
            this.$Progress.start();
            this.BioData.post('/api/ums/users')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User '+ response.data.user.first_name+' '+  response.data.user.last_name+' has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
        updateBioData(){
            this.$Progress.start();
            this.BioData.user_id = this.user.id;
            this.BioData.put('/api/ums/users/'+ this.BioData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User'+ response.data.user.first_name+' '+  response.data.user.last_name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });            
        },
        getProfilePic(){
            let photo = (this.BioData.image.length >= 150) ? this.BioData.image : "./"+this.BioData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.BioData.image = reader.result;
                    console.log(reader.result);
                    }
                reader.readAsDataURL(file)
            }
            else{
                Swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        },
    },
    props:{
        areas: Array,
        branches: Array, 
        departments: Array, 
        states: Array,
        staffs: Array,
        user: Object,
        editMode: Boolean,
    }
}
</script>
