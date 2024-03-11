<template>
    <section class="card">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Uploaded Files</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
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
                            <td v-if="source == 'Staff'">
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
                            <td :colspan="source==Staff ? 6 : 5">No FIle Has Been Uploaded</td>
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
            file_types: [],
            form: new Form({}),
        }
    },
    methods:{
        addFiles(){
            this.$Progress.start();
            this.loanData.post('/api/loans/accounts')
            .then(response=>{
                this.$Progress.finish();
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('getGuarantors', response);
                //this.$route.push('/loans/'+response.data.loan.id+'/guarantor_request');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        },
        approveFile(id){},
        rejectFile(id){},    
    },
    methods:{},
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
