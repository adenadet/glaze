<template>
    <section class="card">
        <div v-if="loading" class="overlay dark"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
        <div class="card-header">
            <h3 class="card-title" v-if="file != null && file.file_name != null">{{ file.file_name }} Confirmation</h3>
            <h3 class="card-title" v-else>Something Went Wrong</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="createConfirmation() ">
                <alert-error :form="fileConfirmationData"></alert-error> 
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Action</label>
                            <select type="text" class="form-control" id="status" name="status"  v-model="fileConfirmationData.status" required>
                                <option value=''>---Select status---</option>
                                <option value="1">Accept</option>
                                <option value="2">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comments</label>
                            <wysiwyg rows="5" v-model="fileConfirmationData.approved_remarks"></wysiwyg>
                        </div>
                    </div>
                </div>
                <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
            </form>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {
            actions: [],
            account: {},
            current: {},
            file: {},
            loading: false,
            loan_types: [],
            fileConfirmationData: new Form({
                approved_remarks: '',
                file_id: '',
                status: '',
            }),
        }
    },
    methods:{
        createConfirmation(){
            this.loading = true;
            this.fileConfirmationData.file_id = this.file.id;
            this.fileConfirmationData.put('/api/loans/files/confirm/'+this.file.id)
            .then(response=>{
                this.loading = false;
                Fire.$emit('GetCourse', response);
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                });
                this.fileConfirmationData.reset();
            })
            .catch(()=>{
                this.loading = false;
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        },
    },
    mounted() {
        Fire.$on('FileDataFill', file => {
            this.file = file;
        });  
    },
    props: {
        editMode: Boolean,
    },
}
</script>