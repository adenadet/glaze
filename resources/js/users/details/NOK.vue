<template>
<section v-if="nokForm.id != '' && nokForm.id != null">
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label>Name *</label>
                <div class="form-control" v-html="nokForm.name"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Relationship *</label>
                <div class="form-control" v-html="nokForm.relationship"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Address</label>
                <div class="form-control" v-html="nokForm.address"></div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number*</label>
                <div class="form-control" v-html="nokForm.phone"></div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email</label>
                <div class="form-control" v-html="nokForm.email"></div>
            </div>
        </div>
    </div>
</section>
<section v-else>
    User has not added any Next of Kin
</section>
</template>
<script>
export default {
    data(){
        return {
            nokForm: new Form({
                id:'',
                name:'',
                relationship:'',
                address:'',
                email:'',
                phone:'',
            }),
            editMode:false,
        }
    },
    methods:{
        createNextOfKin(){
            this.$Progress.start();
            this.nokForm.post('/api/ums/nok')
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Next of Kin details has been created',
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
        },
        updateNextOfKin(){
            this.$Progress.start();
            this.nokForm.put('/api/ums/nok/'+this.nokForm.id)
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Next of Kin details has been updated',
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
                
        },
        
    },
    mounted() {
        this.nokForm.fill(this.nok);
        Fire.$on('NextOfKinFill', update =>{
            if(update.id != null){
                this.editMode = true;
                this.nokForm.fill(update);
            }
            else{
                this.editMode = false;
            }
        });
    },
    props:{
        'nok': Object,
    },
}
</script>