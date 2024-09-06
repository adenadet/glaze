<template>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Branches</h3>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Branch Manager</th>
                                    <th>Address</th>
                                    <th>Number of Staffs</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="branch in branches.data" :key="branch.id">
                                    <td>{{branch.name}}</td>
                                    <td>{{branch.manager | FullName}}</td>
                                    <td>{{branch.address}}</td>
                                    <td>{{branch.staffs.length}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu">
                                            <router-link class="btn btn-block dropdown-item" :to="'/admin/branches/'+branch.id"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                            <button class="btn btn-block dropdown-item" @click="deleteBranch(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="branches" @pagination-change-page="getBranches">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            branches: {},
        }
    },
    methods:{
        deleteBranch(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                
                if(result.value){
                    this.form.delete('/api/ums/branches/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Branch has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editBranch(branch){
            Fire.$emit('BranchDataFill', branch);
            
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/branches').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Branchs were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branchs were not loaded successfully',
                })
            });
        },
        getBranches(page=1){
            axios.get('/api/ums/branches?page='+page)
            .then(response=>{
                this.branches = response.data.branches;   
            });
        },
        refresh(response){
            this.branches = response.data.branches;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('BranchRefresh', response =>{
            this.refresh(response);
            $('#BranchModal').modal('hide');
        });
    }
}
</script>