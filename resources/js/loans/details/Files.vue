<template>
    <section>
        <div class="modal fade" id="fileModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Files Modal</h4>
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
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-default btn-xs">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                                <button type="button" class="btn btn-primary btn-xs" title="Add File" @click="addLoanFile()">
                                    <i class="fa fa-file mr-1"></i>Add File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>File</th>
                            <th>Uploaded</th>
                            <th>Status</th>
                            <th v-if="source == 'Staff'"></th>
                        </tr>
                    </thead>
                    <tbody v-if="files != null">
                        <tr v-for="(file, index) in files" :key="file.id">
                            <td>{{ index | addOne }}</td>
                            <td>{{ file.type }}</td>
                            <td>{{ file.source }}</td>
                            <td>{{ file.created_at | excelDate }}</td>
                            <td>{{ file.status  }}</td>
                            <td v-if="source == 'account'">
                                <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu">
                                    <button class="btn btn-block dropdown-item" @click="approveFile(file.id)"><i class="fa fa-check mr-1"></i> Approve</button>
                                    <button class="btn btn-block dropdown-item" @click="rejectFile(file.id)"><i class="fa fa-times mr-1"></i> Reject</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td :colspan="source=='account' ? 6 : 5">No File Has Been Uploaded</td>
                        </tr>
                    </tbody>
                </table>
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
            form: new Form({}),
        }
    },
    methods:{
        addLoanFile(){
            this.$Progress.start();
            this.editMode = false;
            Fire.$emit('FileDataFill', this.account.id);
            $('#fileModal').modal('show');
            this.$Progress.finish();
        },
        approveFile(id){},
        closeModal(){},
        rejectFile(id){},    
    },
    mounted() {
        //this.getInitials();     
    },
    props:{
        account: Object,
        files: Array,
        source: String, 
    },
}
</script>
