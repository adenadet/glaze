<template>
<section>
    <form id="password_form" @submit.prevent="editMode ? updateSocial() : createSocial() ">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label><i class="fab fa-facebook mr-1"></i>Facebook</label>
                    <input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="Enter Current text" v-model="socialData.facebook_url">
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label><i class="fab fa-twitter mr-1"></i>Twitter</label>
                    <input type="text" class="form-control" id="twitter_url" name="twitter_url" placeholder="New text"  v-model="socialData.twitter_url" minlength="8">
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label><i class="fab fa-linkedin mr-1"></i>LinkedIn</label>
                    <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" placeholder="Re-enter New text"  v-model="socialData.linkedin_url">
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label><i class="fab fa-instagram mr-1"></i>Instagram</label>
                    <input type="text" class="form-control" id="instagram_url" name="instagram_url" placeholder="Re-enter New text"  v-model="socialData.instagram_url">
                </div>
            </div>
        </div>
        <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
    </form>
</section>
</template>
<script>
export default {
    data(){
        return {
            socialData: new Form({
                user_id: '',
                facebook_url: '',
                twitter_url: '',
                instagram_url: '',
                linkedin_url: '',
                id: '',
            }),
        }
    },
    methods:{
        changePassword(){
            if (this.socialData.npw != this.socialData.cpw){ 
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Your new passwords do not match',
                    footer: 'Please try again later!'
                    }); 
                }
            else{
            this.$Progress.start();
            this.socialData.post('/api/hrms/password')
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: response.data.status,
                    title: 'Oops...',
                    text: response.data.message,
                    footer: 'Please try again later!'
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
            }    
        },          
    },
    mounted() {},
    props:{},
}
</script>