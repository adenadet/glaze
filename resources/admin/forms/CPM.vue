<template>
<section>
    <form @submit.prevent="editMode ? updateCPM() : createCPM() ">
        <alert-error :form="cpmData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Loan Details</label>
                    <div class="form-control">Put Loan Details Here</div>
                    <input type="hidden" id="loan_id" name="loan_id" v-model="cpmData.loan_id">
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Detailed Text</label>
                    <wysiwyg id="detail" name="detail" v-model="cpmData.detail" required></wysiwyg>
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
                detail: '',
                loan_id: '',
            }),
        }
    },
    mounted() {
        Fire.$on('cpmDataFill', cpm =>{this.cpmData.fill(cpm)});
    },
    methods:{
        createCPM(){
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
    props:{branch: Object, editMode: Boolean,}
}
</script>