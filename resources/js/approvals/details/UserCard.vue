<template>
    <section class="card">
        <div class="card-header"><h3 class="card-title">{{type |firstUp}} Details</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 offset-2"><img :src="'/img/profile/'+user.image" class="img-fluid" /></div>
                <div class="col-md-4"><div class="form-group"><label>Last Name</label><div class="form-control" v-html="user.last_name"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>First Name</label><div class="form-control" v-html="user.first_name"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>Middle Name</label><div class="form-control" v-html="user.middle_name"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>Date of Birth</label><div class="form-control" v-html="user.dob"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>Phone Number</label><div class="form-control" v-html="user.phone"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>Gender</label><div class="form-control" v-html="user.sex"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>Email</label><div class="form-control" v-html="user.email"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>BVN</label><div class="form-control" v-html="user.bvn"></div></div></div>
                <div class="col-md-4"><div class="form-group"><label>National ID</label><div class="form-control" v-html="user.nin"></div></div></div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {}
    },
    methods:{},
    mounted() {},
    props:{
        type: String,
        user: Object,
    }
}
</script>