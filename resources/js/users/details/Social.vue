<template>
<section v-if="(user.social_medias != null) && (user.social_medias.id != null) && (typeof(user.social_medias) !='undefined')">
    <div class="row">
        <div class="col-offset-md-1 col-md-9 col-sm-12">
            <div class="form-group">
                <label><i class="fab fa-facebook mr-1"></i>Facebook</label>
                <div class="form-control" id="facebook_url" name="facebook_url" v-html="user.social_medias.facebook_url"></div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="form-group">
                <label><i class="fab fa-twitter mr-1"></i>Twitter</label>
                <div class="form-control" id="twitter_url" name="twitter_url" v-html="user.social_medias.twitter_url" minlength="8"></div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="form-group">
                <label><i class="fab fa-linkedin mr-1"></i>LinkedIn</label>
                <div class="form-control" id="linkedin_url" name="linkedin_url" v-html="user.social_medias.linkedin_url"></div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="form-group">
                <label><i class="fab fa-instagram mr-1"></i>Instagram</label>
                <div class="form-control" id="instagram_url" name="instagram_url" v-html="user.social_medias.instagram_url"></div>
            </div>
        </div>
    </div>
</section>
<section v-else>
    <div class="card">
        <div class="card-body">
            No Social Media Accounts Have been added
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