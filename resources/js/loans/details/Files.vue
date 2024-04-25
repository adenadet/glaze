<template>
    <section class="row">
        <div class="col-md-12">
            <div class="overlay-wrapper">
                <div class="overlay" v-if="loading">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
                <div class="modal fade" id="confirmFileModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirm File</h4>
                                <button type="button" class="close" data-dismiss="modal" @click="closeModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <LoanFormConfirmFile />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="fileModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Upload Files</h4>
                                <button type="button" class="close" data-dismiss="modal" @click="closeModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <LoanFormFile :editMode="editMode" :type="file_type"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Uploaded Files</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" title="Add File" @click="addLoanFile()">
                                <i class="fa fa-file mr-1"></i>Add File
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead class="bg-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>File</th>
                                    <th>Uploaded</th>
                                    <th>Status</th>
                                    <th v-if="source == 'account'"></th>
                                </tr>
                            </thead>
                            <tbody v-if="files != null">
                                <tr v-for="(file, index) in files" :key="file.id">
                                    <td>{{ index | addOne }}</td>
                                    <td>{{ file.file_type }}</td>
                                    <td><a :href="'/'+file.source" target="_blank"><i class="fa fa-file-pdf text-danger"></i> </a></td>
                                    <td>{{ file.created_at | excelDate }}</td>
                                    <td>{{ file.status == 0 ? 'Unconfirmed' : (file.status == 1 ? 'Confirmed' : 'Rejected') }}</td>
                                    <td v-if="source == 'account'">
                                        <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-if="file.status == 0"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu">
                                            <button :disabled="loading" class="btn btn-block dropdown-item" @click="confirmFile(file)" ><i class="fa fa-file mr-1"></i> Confirm File</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr><td :colspan="source=='account' ? 6 : 5">No File Has Been Uploaded</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {
            editMode: false,
            file_type: '',
            file: {},
            files: [],
            form: new Form({}),
            loading: true,
            search_query: '',
        }
    },
    methods:{
        addLoanFile(){
            this.$Progress.start();
            this.editMode = false;
            Fire.$emit('FileDataFill', (this.account != null ? this.account.id : this.$route.params.id));
            $('#fileModal').modal('show');
            this.$Progress.finish();
        },
        closeModal(){
            $('#confirmFileModal').modal('hide');
            $('#fileModal').modal('hide');
        },
        confirmFile(file){
            this.$Progress.start();
            this.editMode = false;
            Fire.$emit('FileDataFill', file);
            $('#confirmFileModal').modal('show');
            this.$Progress.finish();
        },
        /*approveFile(id){
            this.loading = true;
            axios.get('/api/loans/files/accept/'+id).
            then(response =>{
                this.files = response.data.files;
                this.loading = false;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Account Files was not loaded successfully',});
                this.loading = false;
            });
        },*/
        getInitials(){
            this.$Progress.start();
            axios.get('/api/loans/files/'+this.$route.params.id).
            then(response =>{
                this.files = response.data.files;
                this.loading = false;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Account Files was not loaded successfully',
                })
            });
        },
        rejectFile(id){
            this.loading = true;
            axios.get('/api/loans/files/reject/'+id).
            then(response =>{
                this.files = response.data.files;
                this.loading = false;
                this.$Progress.finish();

            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Account Files was not loaded successfully',});
                this.loading = false;
            });
        },
        searchLoanFile(){

        },   
    },
    mounted() {
        this.getInitials();
        Fire.$on('reloadLoanFiles', () => {
            this.getInitials();
            this.closeModal();
        });     
    },
    props:{
        account: Object,
        source: String, 
    },
}
</script>
