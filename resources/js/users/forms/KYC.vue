<template>
<div>
<form action="POST" @submit.prevent="createUserKYCData()" enctype="multipart/form-data">
    <alert-error :form="UserKYCData"></alert-error>
    <input type="hidden" v-model="UserKYCData.user_id" id="user_id" name="user_id" />
    <div class="row" v-for="(item, index) in UserKYCData.kyc_items " :key="item.id">
        <div class="col-12"><label>{{index | addOne}} {{ item.name }}</label></div>
        <table class="table table-sm" v-if="item.name == 'Address'">
            <tr>
                <td>
                    <select class="form-control" :placeholder="'Type of '+item.name" v-model="UserKYCData.kyc_items[index].kyc_type" required>
                        <option value="">--Utility Bill Type--</option>
                        <option value="power">Power</option>
                        <option value="sanitation">Sanitation</option>
                        <option value="water">Water</option>
                    </select>
                </td>
                <td v-if="item.kyc_file != null">
                    <div class="form-control">
                        <a v-show="item.kyc_file != null" :href="'/uploads/kyc/'+item.kyc_file" target="_blank"><i class="fa fa-file mr-1"></i>View Attachment</a>
                    </div>
                </td>
                <td>
                    <input type="file" class="form-control" @change="addFile(index, $event)">
                    <input type="hidden" name="file_name" id="file_name" v-model="UserKYCData.kyc_items[index].file" required>
                </td>
                
            </tr>
        </table> 
        <table class="table table-sm" v-else-if="item.name == 'Identity Card'">
            <tr>
                <td>
                    <label>Type</label>
                    <select class="form-control" :placeholder="'Type of '+item.name" v-model="UserKYCData.kyc_items[index].kyc_type" required>
                        <option value="">--Select Card Type--</option>
                        <option value="national_id">National ID</option>
                        <option value="passport">International Passport</option>
                        <option value="drivers_license">Driver's License</option>
                        <option value="pvc">Permanent Voter's Card</option>
                    </select>
                </td>
                <td>
                    <label>Number/ID</label>
                    <input type="text" class="form-control" :placeholder="'ID/Number of '+item.name" v-model="UserKYCData.kyc_items[index].kyc_identification" required>
                </td>
                <td>
                    <label>Expiry Date</label>
                    <input type="date" class="form-control" v-model="UserKYCData.kyc_items[index].kyc_expiry_date" placeholder="expiry_date" v-show="UserKYCData.kyc_items[index].kyc_type == 'drivers_license' ||UserKYCData.kyc_items[index].kyc_type == 'passport'">
                </td>
                <td v-if="item.kyc_file != null">
                    <label>Attachment</label>
                    <div class="form-control">
                        <a v-show="item.kyc_file != null" :href="'/uploads/kyc/'+item.kyc_file" target="_blank"><i class="fa fa-file mr-1"></i>View</a>
                    </div>
                </td>
                <td>
                    <label>Upload File</label>
                    <input type="file" class="form-control" @change="addFile(index, $event)" required>
                    <input type="hidden" name="file_name" id="file_name" v-model="UserKYCData.kyc_items[index].kyc_file">
                </td>
            </tr>
        </table> 
        <div class="col-md-12 mb-3" v-else>
            <hr class="m-0"/> 
            <div class="row mt-2">
                <div class="col-3"><input type="text" class="form-control" required :placeholder="'Type of '+item.name" v-model="UserKYCData.kyc_items[index].kyc_type"></div>
                <div class="col-2"><input type="text" class="form-control" required :placeholder="'ID/Number of '+item.name" v-model="UserKYCData.kyc_items[index].kyc_identification"></div>
                <div class="col-2" v-if="kyc_items[index].expires == true"><input type="date" required class="form-control" v-model="UserKYCData.kyc_items[index].kyc_expiry_date" placeholder="expiry_date"></div>
                <div class="col-5" v-if="kyc_items[index].file == true"><input type="file" required class="form-control" @change="addFile(index, $event)">
                    <input type="hidden" name="file_name" id="file_name" v-model="UserKYCData.kyc_items[index].kyc_file">
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" id="id" v-model="UserKYCData.id">
    <button @submit.prevent="editMode ? updateUserKYCData() : createUserKYCData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            kyc_items: [],
            UserKYCData: new Form({
                kyc_items:{}, 
                user_id: '',
            }),
        }
    },
    mounted() {
        //this.getInitials();
        Fire.$on('UserKYCDataFill', details =>{
            this.UserKYCData.user_id = details.user_id;
            this.kyc_items = details.kyc_list;
            this.UserKYCData.kyc_items = details.kyc_items;
            for (var i = 0; i < details.kyc_items.length; i++){
                this.UserKYCData.kyc_items[i].name = details.kyc_items[i].name;
                this.UserKYCData.kyc_items[i].kyc_type = details.kyc_items[i].kyc_type; 
                this.UserKYCData.kyc_items[i].kyc_identification = details.kyc_items[i].kyc_identification;
                this.UserKYCData.kyc_items[i].kyc_file = details.kyc_items[i].kyc_file;
                this.UserKYCData.kyc_items[i].kyc_file_type = details.kyc_items[i].kyc_file_type;
                this.UserKYCData.kyc_items[i].kyc_expiry_date = details.kyc_items[i].kyc_expiry_date;
            }
        });
    },
    methods:{
        addFile(fileKey, event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            if (file['size'] > 2000000){
                Swal.fire({icon: 'error', title: 'File is too large'});
            }
            else if((file['type'] != 'image/png') && (file['type'] != 'image/jpg') && (file['type'] != 'image/jpeg') && (file['type'] != 'application/pdf')){
                Swal.fire({icon: 'error', title: 'Invalid File Type'});
            }
            else{
                reader.onloadend = (event) => {
                    this.UserKYCData.kyc_items[fileKey].kyc_file = reader.result;
                    this.UserKYCData.kyc_items[fileKey].kyc_file_type = ((file['type'] == 'image/png') || (file['type'] == 'image/jpg') || (file['type'] == 'image/jpeg')) ? 'Image': 'PDF';
                    }
                reader.readAsDataURL(file)
            }
        },
        createUserKYCData(){
            this.$Progress.start();
            this.UserKYCData.user_id = this.user.id;
            this.UserKYCData.post('/api/ums/user_kyc')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User KYC has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'});
                this.$Progress.fail();
            });
        },
        getInitials(){
            axios.get('/api/ums/kyc_items').then(response =>{
                this.kyc_items = response.data.kyc_items;
                for (let i=0; i < this.kyc_items.length; i++){
                    var item = {id: this.kyc_items[i].id, name: this.kyc_items[i].name, file: '', expiry_date: '', type: '', identification: '',};
                    this.UserKYCData.kyc_items.push(item);
                }
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'User KYC items not loaded successfully',});
            });
        },
        updateUserKYCData(){
            this.$Progress.start();
            this.UserKYCData.put('/api/ums/user_kyc/'+ this.UserKYCData.id)
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
        updateFile(e){
            alert('Test');
        }
    },
    props:{
        user: Object,
        editMode: Boolean,
    }
}
</script>
