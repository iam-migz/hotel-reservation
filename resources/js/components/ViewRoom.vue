<template>
    <div class="container">
        <div class="d-flex justify-content-center mt-4">

            <!-- create reservation -->
            <div class="card" style="width: 25rem;">
                <div class="card-body">
                    <h2 class="card-title ">Room {{ room.id }}</h2>

                        <!-- conditionals -->
                        <p class="card-text text-success" v-if="!reservations.length">
                            There are no reservations for this room
                        </p>

                        <div class="availability text-secondary" v-if="room.type == 'classic' ">
                            <i>₱ <b>1500</b> / Day</i>
                        </div>
                        <div class="availability text-secondary" v-else>
                            <i>₱ <b>3000</b> / Day</i>
                        </div>

                    <p class="card-text">{{ room.type }} Room</p>
                    
                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-12 col-form-label">Check-in</label>
                        <div class="col-12">
                            <input class="form-control" type="datetime-local"  v-model="checkin"  id="example-datetime-local-input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-12 col-form-label">Check-out</label>
                        <div class="col-12">
                            <input class="form-control" type="datetime-local"  v-model="checkout"  id="example-datetime-local-input">
                            <div class="dateError mt-4 text-danger"></div>
                        </div>
                    </div>

                    <a 
                        @click="updateRoom"
                        class="btn btn-primary" 
                    >
                        Reserve Room 
                    </a>
                </div>
            </div>

            <!-- reservations -->
            <div class="card " style="width: 20rem;"  v-if="reservations.length">
                <div class="card-header">
                    {{ reservations.length }} Reservations for this room
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"
                        v-for="reservation in reservations"
                        :key="reservation.id"
                    >
                        <p class="card-text">Check-In: {{ dateFormatter(reservation.check_in) }} @ {{ timeFormatter(reservation.check_in) }}</p>
                        <p class="card-text">Check-Out: {{ dateFormatter(reservation.check_out) }} @ {{ timeFormatter(reservation.check_out) }} </p>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    props: ['userId'],
    data(){
        return{
            room: {},
            reservations: [],
            checkin: "",
            checkout: ""
        }
    },
    methods: {
        getRoomAndReservations(){
            axios
                .get(`/api/room/${this.$route.params.id}`)
                .then(res => {
                    this.room = res.data
                    axios
                        .get(`/api/reservation/room/${this.room.id}`)
                        .then(reservations => {
                            this.reservations = reservations.data
                            console.log(this.reservations);
                        })
                        .catch(err => console.log(err));
                })
                .catch(err => console.log(err));
        },
        updateRoom(){
            const checkin_date = new Date(this.checkin);
            const checkout_date = new Date(this.checkout);
            console.log('checkin_date :>> ', checkin_date);
            console.log('checkout_date :>> ', checkout_date);
            // return;
            const errorDiv = document.querySelector('.dateError');
            const now = new Date();
            now.setHours(0,0,0,0);

            if( this.checkin >= this.checkout ){
                errorDiv.innerHTML = "please set the dates correctly";
                return;
            }

            if( checkin_date < now ){
                errorDiv.innerHTML = "cannot reserve date in the past";
                return;
            }

            let retVal = 0;
            // check if dates are already reserved
            this.reservations.forEach(reservation => {
                const reserve_in = new Date(reservation.check_in).getTime();
                const reserve_out = new Date(reservation.check_out).getTime();

                if( checkin_date.getTime() > reserve_in && checkin_date.getTime() < reserve_out){
                    errorDiv.innerHTML = "dates already reserved";
                    retVal++;
                }
            });
            if( retVal ){
                return;
            }

            // create a reservation 
            const reserve = {
                user_id: this.userId,
                room_id: this.$route.params.id,
                check_in: checkin_date.toString().slice(0,21),
                check_out: checkout_date.toString().slice(0,21)
            }

            axios
                .post('/api/reservation/store', reserve)
                .then(res => {
                    this.$router.push(`/user/${this.userId}`);
                })
                .catch(err => console.log(err));
        
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
    created(){
        this.getRoomAndReservations();
    }
}
</script>

<style lang="scss" scoped>
.card-text{
    text-transform: capitalize;
}
</style>