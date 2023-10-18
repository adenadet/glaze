<template>
<section v-if="nokForm.id != null">
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
    methods:{},
    mounted() {
        //this.nokForm.fill(this.nok);
        Fire.$on('NextOfKinFill', update =>{

            if(update != null && update.id != null){
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