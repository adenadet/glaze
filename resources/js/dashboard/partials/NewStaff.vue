<template>
<div class="card custom-card">
    <div class="card-header justify-content-between"> 
        <div class="card-title"> New Staffs </div> 
        <div> 
            <button type="button" class="btn btn-light btn-wave btn-sm waves-effect waves-light">View All</button> 
        </div> 
    </div>
    <div class="card-body p-3">
        <div class="row gy-xl-0 gy-3">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12" v-for="user in staffs" :key="user.id"> 
                <span class="avatar avatar-lg me-2"> <img src="/assets/images/faces/7.jpg" alt="img"> </span>
                <p>Staff Name</p> 
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data() {
        return {
            options: {
                responsive: [
                    { end: 576, size: 1 },
                    { start: 576, end: 768, size: 2 },
                    { start: 768, end: 992, size: 3 },
                    { size: 4 },
                ],
                list: {windowed: 1200, padding: 24,},
                position: {start: 2,},
                autoplay: { play: true, repeat: true, speed: 2500 },
            },
             
        };
    },
    props:{
        'staffs': Array
    }
}
</script>
