<template>
<section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Loan Guarantors</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-stripped ">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Guarantor</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(guarantor, index) in guarantors" :key="guarantor.id">
                        <td>{{ index | addOne }}</td>
                        <td>{{ guarantor.first_name+' '+guarantor.last_name }}</td>
                        <td>{{ guarantor.email }} | {{ guarantor.phone }}</td>
                        <td>{{ guarantor.status == 0 ? 'Not Done' : (guarantor.status == 1 ? 'Confirmed': (guarantor.status == 2 ? 'Rejected' : 'Unknown')) }}</td>
                        <td :title="guarantor.description">{{ guarantor.description }}</td>
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <router-link class="btn btn-block dropdown-item" :to="'/loans/1'"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                <button class="btn btn-block dropdown-item" @click="editRequirement(checklist.id)"><i class="fa fa-edit mr-1"></i> Modify</button>
                                <button v-if="account.status > 13" class="btn btn-block dropdown-item" @click="closeLoan()"><i class="fa fa-times mr-1 text-danger"></i> Close Loan</button>
                                <button v-else class="btn btn-block dropdown-item" @click="deleteLoan(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
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
            account: {},
            guarantors: {},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/loans/guarantors/loans/'+this.$route.params.id).then(response =>{
                this.reloadPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Account was loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Accounts was not loaded successfully',
                })
            });
        },
        reloadPage(response){
            this.account = response.data.account;
            this.guarantors = response.data.guarantors;
        }
    },
    mounted() {
        this.getAllInitials();
    },
}
</script>