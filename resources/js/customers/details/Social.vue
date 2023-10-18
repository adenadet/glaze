<template>
<section>
    <div class="row">
    <div class="col-offset-md-1 col-md-9 col-sm-12">
        <div class="form-group">
            <label><i class="fab fa-facebook mr-1"></i>Facebook</label>
            <input type="text" class="form-control" id="facebook_url" name="facebook_url" v-model="user.social_medias.facebook_url">
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="form-group">
            <label><i class="fab fa-twitter mr-1"></i>Twitter</label>
            <input type="text" class="form-control" id="twitter_url" name="twitter_url" v-model="user.social_medias.twitter_url" minlength="8">
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="form-group">
            <label><i class="fab fa-linkedin mr-1"></i>LinkedIn</label>
            <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" v-model="user.social_medias.linkedin_url">
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="form-group">
            <label><i class="fab fa-instagram mr-1"></i>Instagram</label>
            <input type="text" class="form-control" id="instagram_url" name="instagram_url" v-model="user.social_medias.instagram_url">
        </div>
    </div>
</div>
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
            user: {},
        }
    },
    methods:{
        
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
    props:{
        user: Object,
    },
}
</script>