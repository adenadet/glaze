<template>
<section>
    <form v-if="allowed == true"></form>
    <div v-else>
        You do not have the required Access right to Confirm to the next stage.
    </div>
</section>
</template>
<script>
</script>