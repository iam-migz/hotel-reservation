<template>
    <div>
        <MiniHead :user-id="userId"/>
        <router-view :user-id="userId"></router-view>
    </div>
</template>

<script>
import MiniHead from './MiniHead';
export default {
    props: ['userId'],
    components: {
        MiniHead
    },
    data(){
        return {
            reservations: []
        }
    },
    methods: {
        getAllReservations(){
            axios
                .get('/api/reservations')
                .then(res => this.reservations = res.data )
                .catch(err => console.log(err));
        },
        deleteReservation(reservation_id){
            axios
                .delete(`/api/reservation/${reservation_id}`)
                .then(res => this.$router.go() ) 
                .catch(err => console.log(err) );
        },
        expiredReservation(){
            // check all reservation if they are expired or not
            this.reservations.forEach(reservation => {

                const check_out = new Date(reservation.check_out);
                const today = new Date();
                if( check_out < today ){
                    this.deleteReservation(reservation.id);
                }

            });
        },
        everySecond(){
            window.setInterval( () => {
                this.expiredReservation();
            }, 1000);
        }
    },
    mounted() {
        this.everySecond();
    },
    created() {
        this.getAllReservations();
    }
}
</script>

<style lang="scss" scoped>

</style>