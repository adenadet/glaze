<template>
<section class="card">
    <div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h6 class="modal-title">{{template.name}} </h6> 
                    <button type="button" class="btn-default btn btn-sm" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()">
                        <i class="text-danger fa fa-times"></i>
                    </button> 
                </div> 
                <div class="modal-body p-3"> 
                    <LoanFormRequirement :editMode="editMode"/>
                </div> 
            </div>
        </div> 
    </div>
    <div class="modal fade" id="templateFormModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> 
        <div class="modal modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h6 class="modal-title">{{editMode ? 'Update Template' : 'Create New Template'}} </h6> 
                    <button type="button" class="btn-default btn btn-sm" data-bs-dismiss="modal" aria-label="Close" @click="closeModal()">
                        <i class="text-danger fa fa-times"></i>
                    </button> 
                </div> 
                <div class="modal-body p-3"> 
                    <AdminFormCPMTemplate :editMode="editMode"/>
                </div> 
            </div>
        </div> 
    </div>
    <div class="card-header">{{ module.name }}
        <div class="card-tools">
            <button class="btn btn-success btn-sm" @click="addNew()">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped table-hover m-b-0">
                <thead>
                    <tr>
                        <th>Template Name</th>
                        <th>Loan Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="template in module.templates" :key="template.id">
                        <td>{{template.name}}</td>
                        <td>{{ template.loan_type ? template.loan_type.name : 'Does not apply'}}
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <button class="btn btn-block dropdown-item" @click="viewTemplate(template)"><i class="fa fa-eye mr-1 text-primary"></i> View </button>
                                <button class="btn btn-block dropdown-item" @click="editTemplate(template)"><i class="fa fa-edit mr-1 text-warning"></i> View </button>
                                <button class="btn btn-block dropdown-item" @click="deleteTemplate(template.id)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
                            </div>
                        </td>
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
            module: {},
            template: {},
        }
    },
    methods:{
        addTemplate(){Fire.$emit('ModuleDataFill', {});},
        closeModal(){$('#templateModal').modal('hide');$('#templateFormModal').modal('hide');},
        deleteTemplate(id){
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
                    this.form.delete('/api/settings/cpm_module_templates/'+id)
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
        editTemplate(template){
            Fire.$emit('TemplateDataFill', template);
            $('#templateModal').modal('show');
        },
    },
    mounted() {
        Fire.$on('TemplateRefresh', response =>{
            $('#templateModal').modal('hide');
        });
        Fire.$on('ViewModuleDataFill', module =>{
            this.module = module;
        })
    },
}
</script>