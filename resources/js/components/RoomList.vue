<template>
    <div class="container">
        <h1 class="text-center">List of Rooms</h1>
        <div class="card mx-auto" style="width: 18rem;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"
                    v-for="room in rooms"
                    :key="room.id"
                >
                    <router-link :to="`/room/${room.id}`">
                    <div class="d-flex justify-content-between">
                        <div class="room-number">
                            <span class="capitalize">{{ room.type }}</span> Room {{ room.id }}
                        </div>
                        <div class="availability text-secondary" v-if="room.type == 'classic' ">
                            ₱ <b>1500</b> / Day
                        </div>
                        <div class="availability text-secondary" v-else>
                            ₱ <b>3000</b> / Day
                        </div>
                    </div>
                    </router-link>

                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            rooms: []
        }
    },
    methods: {
        getRoomList(){
            axios.get('api/rooms')
                .then(res => {
                    console.log(res.data);
                    this.rooms = res.data;
                })
                .catch(err => console.log(err));
        }
    },
    created(){
        this.getRoomList();
    }
}
</script>

<style lang="scss" scoped>
ul{
    li:hover {
        background: #ababab;
        transition: all 0.5s ease;
        cursor: pointer;
    }
    li {

        a {
            text-decoration: none;
        }

        .availability {
            font-style: italic;
        }
        
    }
    span.capitalize {
        text-transform: capitalize;
    }
}
</style>