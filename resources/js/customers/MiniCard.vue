<template>
<div class="card bg-light d-flex flex-fill">
    <div class="card-header text-muted border-bottom-0">
        {{customer.unique_id}}
    </div>
    <div class="card-body pt-0">
        <div class="row">
        <div class="col-7">
            <h2 class="lead"><b>{{ customer.first_name+' '+customer.last_name }}</b></h2>
            <!--p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p-->
            <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{ customer | userAddress }}</li>
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> {{ customer.phone }}</li>
                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> {{ customer.email }}</li>
            </ul>
        </div>
        <div class="col-5 text-center">
            <img :src="customer | userImage " alt="user-avatar" class="img-circle img-fluid">
        </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-right">
            <router-link :to="'/staff/customers/'+customer.id" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> View Profile</router-link>
            <!--button type="button" class="btn btn-sm btn-success"><i class="fas fa-building"></i> Loans</button-->
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/dashboard')
            .then(response =>{
                this.birthdays      = response.data.birthdays;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Dashboard not loaded successfully',});
            });
        },
    },
    mounted() {
        ///this.getAllInitials();
    },
    props:{
        customer: Object,
    }
}
</script>