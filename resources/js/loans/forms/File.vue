<template>
    <section>
        <div class="col-md-12">
            <form @submit.prevent="createFile()" enctype="multipart/form-data">
                <alert-error :form="fileData"></alert-error> 
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>File Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name of Document" v-model="fileData.file_name" required/> 
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>File Type</label>
                            <select v-if="type == null || type == ''" class="form-control" id="file_type" name="file_type" placeholder="Youtube Video Link" v-model="fileData.file_type"  required>
                                <option value="">---Select file Type---</option>
                                <option v-for="file_type in file_types" :value="file_type" :key="file_type">{{  file_type }}</option>
                            </select>
                            <div class="form-control" v-else><input type="hidden" v-model="fileData.file_type"/> {{ type }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Upload File</label>
                            <input type="file" class="form-control" @change="uploadFile"/> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <wysiwyg v-model="fileData.description"  required/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <input type="submit" name="submit" class="submit btn btn-success" value="Submit" :disabled="loading"/>
                        <i class="fa fa-spinner rotation-animation text-primary" v-if="loading"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {
            file: '',
            fileData: new Form({
                loan_id: '',
                file_name: '',
                file_type: '',
                description: '',
                source: '',
                file: '',
            }),
            file_types: ['Collateral Documents', 'Guarantor Form', 'Statement of Account (3 months)', 'Statement of Account (6 months)'],
            loading: false,
        }
    },
    methods:{
        createFile(){
            this.$Progress.start();
            this.loading = true;
            if (this.fileData.file_type == ""){this.fileData.file_type = this.type;} 
            this.fileData.post('/api/loans/files')
            .then(response=>{
                this.$Progress.finish();
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('reloadLoanFiles');
                this.loading = false;
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({ icon: 'error', title: 'Your form was not sent try again later!',});
                this.loading = false;
            });
        },
        uploadFile(e){
            let file = e.target.files[0];
            let allowed_types = ['application/pdf']; 
            let reader = new FileReader();
            
            if (file['size'] >= 2000000) {Swal.fire({icon: 'error', title: 'File is too large'});}
            else if (!(allowed_types.includes(file['type']))){Swal.fire({icon: 'error', title: 'File is not a PDF file'});}
            else if ((file['size'] < 2000000) && (allowed_types.includes(file['type']))) {
                reader.onloadend = (e) => {
                    this.fileData.file = reader.result;
                }
                reader.readAsDataURL(file)
            }
            else{Swal.fire({type: 'error', title: 'File is too large'})}
        },
    },
    mounted(){
        Fire.$on('FileDataFill', id =>{this.fileData.loan_id = id;});
    },
    props:{
        account_id: Number,
        specific: String,
        type: String,
    }

}
</script>
