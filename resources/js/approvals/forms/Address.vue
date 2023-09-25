<template>
<section>
    <form id="password_form" @submit.prevent="editMode ? updateSocial() : createSocial() ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Date of Visit</label>
                    <input type="datetime" class="form-control" id="visit_date" name="visit_date" placeholder="New text" v-model="AddressConfirmationData.visit_date">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Date of Visit 2 (if necessary)</label>
                    <input type="datetime" class="form-control" id="visit_date" name="visit_date" placeholder="Re-enter New text" v-model="AddressConfirmationData.visit_date_2">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Visit Update</label>
                    <select class="form-control" id="visit_update" name="visit_update" v-model="AddressConfirmationData.update">
                        <option value="">--Select Update--</option>
                        <option value="1">Found Address Correct as Provided</option>
                        <option value="2">Wrong Address and needs to be changed to</option>
                        <option value="3">Address Does Not Exist</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12" v-if="AddressConfirmationData.update == 2">
                <div class="form-group">
                    <label>New Address</label>
                    <wysiwyg id="alternate_address" name="alternate_address" placeholder="Enter the alternate address" v-model="AddressConfirmationData.alternate_address" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Met With</label>
                    <select class="form-control" id="met_with" name="met_with" v-model="AddressConfirmationData.met_with">
                        <option value="">--Select Who Was Met --</option>
                        <option value="customer">Customer</option>
                        <option value="relative">Relative</option>
                        <option value="neighbour">Neighbour</option>
                        <option value="no one">Meet with Noone</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12" v-if="AddressConfirmationData.met_with == 'relative' || AddressConfirmationData.met_with == 'neighbour'">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="met_with_name" name="met_with_name" placeholder="Name of Person met with" v-model="AddressConfirmationData.met_with_name">
                </div>
            </div>
            <div class="col-md-6 col-sm-12" v-if="AddressConfirmationData.met_with == 'relative' || AddressConfirmationData.met_with == 'neighbour'">
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" class="form-control" id="met_with_relations" name="met_with_relations" placeholder="Relationship" v-model="AddressConfirmationData.met_with_relations">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" id="met_with_phone" name="met_with_phone" placeholder="Phone" v-model="AddressConfirmationData.met_with_phone">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Ease of Location</label>
                    <select class="form-control" id="location_ease" name="location_ease" v-model="AddressConfirmationData.location_ease">
                        <option value="">--Select Update--</option>
                        <option value="easy">Easy</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="difficult">Difficult</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>Description</label>
                    <wysiwyg rows="5" v-model="AddressConfirmationData.description"/>
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
            AddressConfirmationData: new Form({
                id: '',
                address_id: '',
                description: '',
                remarks: '',
                location_ease: '',
                visit_date: '',
                visit_date_2: '',
                update: '',
                alternate_address: '',
                met_with: '',
                met_with_name: '',
                met_with_relations: '',
                met_with_phone: '',
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