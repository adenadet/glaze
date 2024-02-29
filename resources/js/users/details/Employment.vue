<template>
<section class="row">
    <div class="col-md-12">Working</div>
    <!--div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Name *</label>
                <div type="text" required class="form-control" v-html="employment.name"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Employed On</label>
                <div type="text" class="form-control" v-html="employment.employment_date"></div> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Educational Level*</label>
                <div type="text" class="form-control" v-html="employment.educational_level" ></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <div type="text" class="form-control" v-html="employment.employer_email"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <div type="text" class="form-control" v-html="employment.employer_telephone_no"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Status</label>
                <div type="text" class="form-control" id="bvn" name="bvn" v-html="employment.employment_status"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address</label>
                <div class="form-control" v-html="employment.employer_address"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Area</label>
                <div class="form-control"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Closest landmark</label>
                <div class="form-control" v-html="employment.landmark"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Verified By:</label>
                <div class="form-control" id="verified_by" name="verified_by"  :class="{'is-invalid' : employment.errors.has('verified_by') }">
                    
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Verified At:</label>
                <div type="text" class="form-control" v-html="employment.verified_at"></div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tax Number</label>
                <div class="form-control" v-html="employment.tax_no"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Pension Number</label>
                <div class="form-control" v-html="employment.pension_number"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Staff ID</label>
                <div class="form-control" v-html="employment.staff_id"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Verified By:</label>
                <div class="form-control" id="verified_by" name="verified_by"  :class="{'is-invalid' : employment.errors.has('verified_by') }">
                    {{employment.verified_by | FullName}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Verified At:</label>
                <div type="text" class="form-control" v-html="employment.verified_at"></div> 
            </div>
        </div>
    </div-->
</section>
</template>
<script>
export default {
    data(){
        return  {
            employment: {},
            user: {}
        }
    },
    mounted() {
        Fire.$on('EmploymentFill', user =>{
            this.Employment.fill(user);
            this.user = user
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.Employment.fill(data)));
        });
    },
    methods:{
        createEmployment(){
            console.log("Working book");
            this.$Progress.start();
            this.Employment.post('/api/ums/users')
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
        updateEmployment(){
            this.$Progress.start();
            this.Employment.user_id = this.user.id;
            this.Employment.put('/api/ums/users/'+ this.Employment.id)
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
            let photo = (this.Employment.image.length >= 150) ? this.Employment.image : "./"+this.Employment.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.Employment.image = reader.result;
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
        editMode: Boolean,
    }
}
</script>
