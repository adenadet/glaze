<template>
<section>
    <form @submit.prevent="editMode ? updateCPM() : createCPM() ">
        <alert-error :form="cpmData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Module</label>
                    <div class="form-control">{{ module.name }}</div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Name</label>
                    <input id="name" name="name" v-model="cpmData.name" class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Loan Type</label>
                    <select id="loan_type_id" name="loan_type_id" v-model="cpmData.loan_type_id" class="form-control">
                        <option value="">--Select Loan Type--</option>
                        <option v-for="loan_type in loan_types" :value="loan_type.id">{{ loan_type.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Detailed Text</label>
                    <wysiwyg id="detail" name="detail" v-model="cpmData.details" required></wysiwyg>
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
        return  {
            cpmData: new Form({
                id: '',
                details: '',
                loan_id: '',
                module_id: '',
                name: '',
            }),
            module: {},
            loan_types: [],
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ModuleTemplateDataFill', template =>{
            this.cpmData.fill(template);
            this.module = template.module;
        });
    },
    methods:{
        createCPM(){
            this.$Progress.start();
            this.cpmData.module_id = this.module.id;
            this.cpmData.post('/api/settings/cpm_module_templates')
            .then(response =>{
                Fire.$emit('BranchRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Branch'+ this.cpmData.name+' has been created',
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
            this.$Progress.finish();
            this.cpmData.clear();
        },
        getInitials(){
            axios.get('/api/settings/cpm_module_templates')
            .then(response =>{
                this.loan_types = response.data.loan_types;
            })
            .catch(()=>{
                toast.fire({icon: 'error', title: 'Modules were not loaded successfully',})
            });
        },
        updateCPM(){
            this.$Progress.start();
            this.cpmData.put('/api/loans/cpm_templates/'+ this.cpmData.id)
            .then(response =>{
                Fire.$emit('BranchRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Branch '+this.cpmData.name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$Progress.finish();
                this.cpmData.clear();
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
    },
    props:{
        editMode: Boolean,
        //loan_types: Array,
        //module: Object,  
    },
}
</script>
