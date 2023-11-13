<template>
<section class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">CPM Modules</h3></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="module_unit in modules.data" :key="module_unit.id">
                                    <td>{{module_unit.name}}</td>
                                    <td>
                                        <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-menu">
                                            <button class="btn btn-block dropdown-item" @click="viewModule(module_unit)"><i class="fa fa-eye mr-1 text-primary"></i> View </button>
                                            <button class="btn btn-block dropdown-item" @click="deleteModule(module_unit.id)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="modules" @pagination-change-page="getAllInitials">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <AdminCPMModuleSingle />
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            modules: {},
        }
    },
    methods:{
        addModule(){
            Fire.$emit('ModuleDataFill', {});
            $('#moduleModal').modal('show');
        },
        closeModal(){
            $('#moduleModal').modal('hide');
        },
        deleteModule(id){
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
                    this.form.delete('/api/settings/cpm_modules/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Module has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editModule(module){
            Fire.$emit('ModuleDataFill', module);
            $('#moduleModal').modal('show');
        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/settings/cpm_modules?page='+page).then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Modules were not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.modules = response.data.modules;
            this.users = response.data.users;
            this.loan_types = response.data.loan_types;
            Fire.$emit('ViewModuleDataFill', this.modules.data[0]);
        },
        viewModule(module){
            Fire.$emit('ViewModuleDataFill', module);
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('BranchRefresh', response =>{
            this.refresh(response);
            $('#BranchModal').modal('hide');
        });
            //$('#moduleModal').modal('show');
        
    }
}
</script>