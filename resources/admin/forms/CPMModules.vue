<template>
<section>
    <form @submit.prevent="editMode ? updateModule() : createModule() ">
        <alert-error :form="moduleData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="moduleData.name" required>
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
            moduleData: new Form({
                id: '',
                name: '',
            }),
        }
    },
    mounted() {
        Fire.$on('moduleDataFill', module =>{this.moduleData.fill(module)});
    },
    methods:{
        createModule(){
            this.$Progress.start();
            this.cpmData.post('/api/loans/cpms')
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
        updateCPM(){
            this.$Progress.start();
            this.cpmData.put('/api/ums/branches/'+ this.cpmData.id)
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
    props:{branch: Object, editMode: Boolean, users: Array,}
}
</script>
