<template>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
            <div class="card  card-widget widget-user"> 
                <div class="card-body p-0"> 
                    <div class="widget-user-header bg-success">
                        <h3 class="widget-user-username">{{user | FullName}}</h3>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" :src="user | userImage" :alt="user | FullName" >
                    </div>
                    <div class="p-4 border-bottom border-block-end-dashed"> 
                        <p class="fs-15 mb-2 me-4 fw-semibold">Contact Information :</p>
                        <div class="text-muted"> 
                            <p class="mb-2"> 
                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted"> <i class="fa fa-envelope align-middle fs-14"></i> </span>
                                {{user.email}}
                            </p>
                            <p class="mb-2"> 
                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted"> <i class="fa fa-phone align-middle fs-14"></i> </span>
                                {{user.phone}} {{user.alt_phone ? ', '+user.alt_phone: ''}}
                            </p>
                            <p class="mb-0"> <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted"> <i class="fa fa-location-dot align-middle fs-14"></i> </span> 
                                {{user.customer_address ? user.customer_address.street : ''}} {{user.customer_address && user.customer_address.street2 ? ', '+user.customer_address.street2: ''}}, {{user.customer_address ?  user.customer_address.city : ''}}, {{user.customer_address && user.customer_address.state_id && user.customer_address.state != null? user.customer_address.state.name: ''}}. 
                            </p>
                        </div> 
                    </div> 
                    <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-center"> 
                        <p class="fs-15 mb-2 me-4 fw-semibold">Social Networks <i class="fab fa-facebook text-warning"></i> :</p><br />
                        
                    </div> 
                </div> 
                <div class="card-footer p-0">
                    <ul class="nav flex-column" v-if="user.social_medias != null">
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fab fa-facebook-square text-primary mr-1"></i>Facebook: <span class="float-right badge bg-primary">{{ user.social_medias.facebook_url }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fab fa-twitter-square text-primary mr-1"></i>Twitter: <span class="float-right badge bg-primary">{{ user.social_medias.twitter_url }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fab fa-instagram-square text-primary mr-1"></i>Instagram: <span class="float-right badge bg-primary">{{ user.social_medias.instagram_url }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><i class="fab fa-linkedin-square text-primary mr-1"></i>LinkedIn: <span class="float-right badge bg-primary">{{ user.social_medias.linkedin_url }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card custom-card"> 
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab" role="tab" href="#basic" aria-selected="false" tabindex="-1">Basic</a> </li> 
                        <li class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#address" aria-selected="false" tabindex="-1">Addresses</a> </li> 
                        <li class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#nok" aria-selected="false" tabindex="-1">Next of Kin</a> </li> 
                        <li class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#security" aria-selected="false" tabindex="-1">Security</a> </li> 
                        <li class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#socials" aria-selected="true">Social Media</a> </li>
                        <li class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#kyc" aria-selected="true">Know Your Customer</a> </li> 
                        <li v-if="user.staff == null" class="nav-item" role="presentation"> <a class="nav-link" data-bs-toggle="tab" role="tab" href="#employment" aria-selected="true">Current Employer</a> </li> 
                    </ul> 
                </div> 
                <div class="card-body"> 
                     
                    <div class="tab-content"> 
                        <div class="tab-pane text-muted active show" id="basic" role="tabpanel"> 
                            <PMFormBasic :editMode="editMode" :user="user" />
                        </div>
                        <div class="tab-pane text-muted" id="address" role="tabpanel"> 
                            <PMFormAddress :areas="areas" :editMode="editMode" :states="states" :user="user" />
                        </div> 
                        <div class="tab-pane text-muted" id="nok" role="tabpanel"> 
                            <PMFormNOK :nok="nok"/>
                        </div> 
                        <div class="tab-pane text-muted" id="security" role="tabpanel"> 
                            <PMFormPassword />
                        </div> 
                        <div class="tab-pane text-muted" id="socials" role="tabpanel">
                            <PMFormSocials />     
                        </div> 
                        <div class="tab-pane text-muted" id="kyc" role="tabpanel">
                            <PMFormKYC :user="user" :editMode="user.kyc != null" />     
                        </div> 
                        <div class="tab-pane text-muted" id="employment" role="tabpanel">
                            <UserFormEmployment :user="user" :areas="areas" :editMode="editMode" :sectors="sectors" :states="states"/>     
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>                           
</div>
</template>

<script>
export default {
    data(){
        return  {
            areas:[],  
            editMode: true, 
            kyc_items: {},
            nations: [],  
            nok:{},
            sectors: [],
            socials: {},
            states:[],
            user:{}, 
        }
    },
    created() {
        this.getInitials();
        Fire.$on('Reload', response =>{this.refreshProfile(response);});
    },
    methods:{
        getInitials(){
            axios.get('/api/ums/profile').then(response =>{
                this.$Progress.finish();
                this.reloadProfile(response);
                toast.fire({
                    icon: 'success',
                    title: 'Profile loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Profile not loaded successfully',
                })
            });
        },
        reloadProfile(response){
            this.user = response.data.user;
            this.areas = response.data.areas;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.states = response.data.states;
            this.nok = response.data.nok;
            this.nations = response.data.nations;
            this.kyc_items = response.data.kyc_items;
            this.kyc_list = response.data.kyc_list;
            this.sectors = response.data.sectors;
            this.socials = response.data.socials;
            
            Fire.$emit('BasicDataFill', this.user);
            Fire.$emit('NextOfKinFill', this.nok); 
            Fire.$emit('AddressDataFill', this.user.customer_address);
            Fire.$emit('SocialDataFill', {'user': this.user, 'socials': this.socials})
            Fire.$emit('UserKYCDataFill', {'user_id': this.user.id, 'kyc_items': this.kyc_items,});
        },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.form.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                swal.fire({
                    type: 'error',
                    title: 'File is too large'
                });
            }
        }
    }
}
</script>