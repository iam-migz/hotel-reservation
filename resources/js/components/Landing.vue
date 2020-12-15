<template>
    <div class="container">

        <div class="landing d-flex flex-column text-center">
            <div class="header mt-4 ">
                <h1 class="display-3">Comfortable &<br> Affordable</h1>  
            </div>
            <div class="second mt-4">
                <router-link to="/rooms">
                    <button type="button" class="btn btn-primary">
                        View All Rooms
                    </button>
                </router-link>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.landing{
    // border: 1px solid black;
    height: 70vh;

    align-items: stretch;
    .header{
        margin-top: 50%;
    }
}
.btn{
    border-radius: 25px;
    padding: 10px;
}
</style>