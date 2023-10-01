<template>
<section>
    <form @submit.prevent="getCreditScore() ">
        <alert-error :form="loanConfirmationData"></alert-error> 
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Action</label>
                    <select type="text" class="form-control" id="action" name="action"  v-model="loanConfirmationData.action" required>
                        <option value=''>---Select Action---</option>
                        <option v-for="(action,index) in actions" :value="action.stage_number">{{ index == 0 ? 'Send To' : 'Return To' }} {{ action.role.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Last name</label>
                    <wysiwyg rows="5" v-model="loanConfirmationData.description"></wysiwyg>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Action</label>
                    <select type="text" class="form-control" id="action" name="action"  v-model="loanConfirmationData.action" required>
                        <option value=''>---Select Action---</option>
                        <option v-for="(action,index) in actions" :value="action.stage_number">{{ index == 0 ? 'Send To' : 'Return To' }} {{ action.role.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Comments</label>
                    <wysiwyg rows="5" v-model="loanConfirmationData.description"></wysiwyg>
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
        return {
            actions: [],
            account: {},
            current: {},
            loan_types: [],
            loanConfirmationData: new Form({
                action: '',
                description: '',
                loan_id:'', 
            }),
        }
    },
    methods:{
        createConfirmation(){
            this.loanConfirmationData.loan_id = this.account.id;
            this.loanConfirmationData.post('/api/loans/confirms')
            .then(response=>{
                Fire.$emit('GetCourse', response);
                Swal.fire({
                    icon: 'success',
                    title: 'New Requirement was created successfully',
                });
                this.loanConfirmationData.reset();
                this.$router.push('/staff/confirm/loans');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        },
        getCreditScore(){},
        getInitials(){
            axios.get('/api/loans/confirms/initials/'+this.$route.params.id).then(response =>{
                this.actions = response.data.actions,
                this.account = response.data.account;
                this.current = response.data.current;
            })
            .catch(()=>{
                toast.fire({
                    icon: 'error',
                    title: 'Loan Confirmation Form Initialization failed',
                })
            });
        },
    },
    mounted() {
        this.getInitials()
        Fire.$on('RequirementDataFill', requirement =>{
            this.requirementData.fill(requirement);
        });     
    },
    props: {
        editMode: Boolean,
    },
}
</script>