<template>
<section>
    <form id="password_form" @submit.prevent="editMode ? updateSocial() : createSocial() ">
        <alert-error  :form="socialData"></alert-error>
        <div class="row">
            <div class="col-md-12">{{ editMode ? 'Update Social Media Details' : 'Create Social Media Details' }}</div>
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
            editMode: false,
            socialData: new Form({
                user_id: '',
                facebook_url: '',
                twitter_url: '',
                instagram_url: '',
                linkedin_url: '',
                id: '',
            }),
            user: {},
        }
    },
    methods:{
        createSocial(){
            this.$Progress.start();
            this.socialData.user_id = this.user.id;
            this.socialData.post('/api/ums/socials')
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
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
        },
        updateSocial(){
            this.$Progress.start();
            this.socialData.put('/api/ums/socials/'+this.socialData.id)
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.data.message,
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
    mounted() {
        Fire.$on('SocialDataFill', details => {
            this.user = details.user;
            if (details.socials == null || details.socials.id == null || typeof(details.socials) == 'undefined'){
                this.editMode = false;
                this.socialData.reset();
            }
            else{
                this.editMode = true;
                this.socialData.fill(details.socials);
            }
        });
    },
    props:{},
}
</script>