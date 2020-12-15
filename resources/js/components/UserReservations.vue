<template>
    <div class="container">
        <!-- reservations list -->
        <h1 class="display-4 text-center mt-4">Reservations</h1>
        <div 
            class="card mx-auto mt-4" 
            style="width: 30rem;"
            v-for="(reservation, index) in reservations"
            :key="reservation.id"
        >
            <div class="card-body">
                <h5 class="card-title">Room {{ reservation.room_id }} </h5>
                <p class="card-text">Check-In: {{ dateFormatter(reservation.check_in) }} @ {{ timeFormatter(reservation.check_in) }} </p>
                <p class="card-text">Check-Out: {{ dateFormatter(reservation.check_out) }} @ {{ timeFormatter(reservation.check_out) }} </p>

                <div class="ready" v-if="records.length">
                    <p class="card-text">Days: {{ records[index].days }}</p>
                    <p class="card-text">Price: {{ records[index].price }} </p>
                </div>

                <a @click="cancelReservation(reservation.id, reservation.room_id)" class="btn btn-danger mt-4">Cancel Reservation</a>
            </div>
        </div>

        <!-- display price -->
        <div class="card mx-auto mt-4" style="width: 30rem;" >
            <div class="card-body">
                Total Price: {{ totalPrice }}

            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['userId'],
    data(){
        return {
            reservations: [],
            rooms: [],
            records: [],
            totalPrice: 0
        }
    },
    computed: {
        
    },
    methods: {
        getReservations(){
            axios
                .get(`/api/reservation/${this.userId}`)
                .then(res => this.reservations = res.data)
                .catch(err => console.log(err));
        },
        getRoomList(){
            axios
                .get('/api/rooms')
                .then(res => this.rooms = res.data )
                .catch(err => console.log(err));
        },
        cancelReservation(reservation_id, room_id){
            axios
                .delete(`/api/reservation/${reservation_id}`)
                .then(res => this.$router.go() ) 
                .catch(err => console.log(err) );

        },

        dateFormatter(date){
            const newDate = new Date(date);

            const year = newDate.getFullYear();
            const month = newDate.getMonth();
            const day = newDate.getDate();
            const weekDay = newDate.getDay();
            
            let formattedDate = new Date(year, month, day, weekDay);
            let options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric', 
            };

            return formattedDate.toLocaleString('en-US', options);
        },
        timeFormatter(date){ 
            const time = date.slice(-5).split(':'); 
            let hours = time[0];
            let minutes = time[1];
            const AmOrPm = hours >= 12 ? 'PM' : 'AM';
            
            hours = (hours % 12) || 12;

            return `${hours}:${minutes} ${AmOrPm}`;
        }


    },
    created() {
        this.getRoomList();
        this.getReservations();
    },
    watch: {
        reservations(){
            this.reservations.forEach((reservation, index) => {
            // get number of days for this reservation
            const check_in = new Date(reservation.check_in);
            const check_out = new Date(reservation.check_out);
            let days =  Math.round( (check_out - check_in ) / (1000 * 60 * 60 * 24) );

            // get price for this reservation
            const price = this.rooms[index].type == 'deluxe' ? 3000 : 1500;
            this.totalPrice += price;

            // store days and price in records
            this.records.push({
                days,
                price
            })
        });
        }
    }
}
</script>

<style lang="scss" scoped>

</style>