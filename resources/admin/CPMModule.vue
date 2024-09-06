<template>
<section class="card">
    <div class="modal fade" id="templateFormModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Template: {{ template.name }} </h4>
                    <h4 class="modal-title" v-show="!editMode">New Template</h4>
                    <button type="button" class="close" @click="closeModal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <AdminFormCPMTemplate :editMode="editMode" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-header">{{ module.name }}
        <div class="card-tools">
            <button class="btn btn-success btn-sm" @click="addTemplate">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-stripped table-hover m-b-0">
                <thead>
                    <tr>
                        <th>Template Name</th>
                        <th>Module</th>
                        <th>Loan Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="template in module.templates" :key="template.id">
                        <td>{{template.name}}</td>
                        <td>{{module.name}}</td>
                        <td>{{ template.loan_type ? template.loan_type.name : 'Does not apply'}}
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <button class="btn btn-block dropdown-item" @click="viewTemplate(template)"><i class="fa fa-eye mr-1 text-primary"></i> View </button>
                                <button class="btn btn-block dropdown-item" @click="editTemplate(template)"><i class="fa fa-edit mr-1 text-warning"></i> Edit </button>
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
        addTemplate(){
            this.editMode = false;
            this.template = {name: '', module: this.module, loan_type: '',};
            Fire.$emit('ModuleTemplateDataFill', this.template);
            $('#templateFormModal').modal('show');
        },
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