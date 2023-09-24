<template>
<div class="card custom-card">
    <div class="card-header justify-content-between"><div class="card-title">Birthdays</div></div>
    <div class="card-body p-0">
        <div class="card custom-card"> 
            <div class="card-body contact-action" v-for="user in birthdays" :key="user.id"> 
                <div class="contact-overlay"></div> 
                <div class="d-flex align-items-top "> 
                    <div class="d-flex flex-fill flex-wrap gap-2"> 
                        <div class="avatar avatar-xl avatar-rounded me-3"> 
                            <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" :alt="user ? user.first_name+' '+user.middle_name+' '+user.last_name : 'Default Image' " :title="user ? user.first_name+' '+user.middle_name+' '+user.last_name : 'Celebrant\'s  Image' "> 
                        </div> 
                        <div> 
                            <h6 class="mb-1 fw-semibold"> {{user.first_name}} {{user.last_name}} </h6> 
                            <p class="mb-1 text-muted contact-mail text-truncate">{{user.dob | ExcelDateMonth}}</p>
                        </div> 
                    </div> 
                    <div> 
                        <i class="ri-heart-3-fill fs-16 text-danger"></i> 
                    </div> 
                </div> 
                <div class="d-flex align-items-center justify-content-center gap-2 contact-hover-buttons"> 
                    <button type="button" class="btn btn-sm btn-light contact-hover-btn"> View Contact </button> 
                    <div class="dropdown contact-hover-dropdown">
                        <button class="btn btn-sm btn-icon btn-light btn-wave waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                            <i class="fa-solid fa-ellipsis-vertical"></i> 
                        </button> 
                        <ul class="dropdown-menu"> 
                            <li><a class="dropdown-item" href="#"><i class="ri-share-line me-2 align-middle d-inline-block"></i>Share</a></li> 
                            <li><a class="dropdown-item" href="#"><i class="ri-phone-line me-2 align-middle d-inline-block"></i>Call</a></li> 
                            <li><a class="dropdown-item" href="#"><i class="ri-chat-2-line me-2 align-middle d-inline-block"></i>Message</a></li> 
                            <li><a class="dropdown-item" href="#"><i class="ri-video-chat-line me-2 align-middle d-inline-block"></i>Video Call</a></li> 
                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line me-2 align-middle d-inline-block"></i>Delete</a></li> 
                            <li><a class="dropdown-item" href="#"><i class="ri ri-heart-3-line me-2 align-middle d-inline-block"></i>Favourite</a></li> 
                        </ul> 
                    </div> 
                    <button aria-label="button" class="btn btn-sm btn-icon btn-light contact-hover-dropdown1" type="button"> 
                        <i class="ri-heart-3-fill text-danger"></i> 
                    </button> 
                </div> 
            </div> 
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {}
    },
    methods:{
        scrollHanle(evt) {},
    },
    mounted() {
        //this.getAllInitials();
    },
    props:{
        'birthdays': Array,
    },
}
</script>