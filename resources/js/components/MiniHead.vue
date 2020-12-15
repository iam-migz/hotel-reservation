<template>
    <div class="container">
        <div class="d-flex justify-content-between">
            <div id="MyClockDisplay" class="clock">
           
            </div>
            <div class="right">
                <router-link :to="link">
                    Your Reservations
                </router-link>
            </div>
        </div>
    </div>
</template> 

<script>
export default {
    props: ['userId'],
    data(){
        return{
            link: `/user/${this.userId}`
        }
    },
    methods: {
        showTime(){
            const date = new Date();
            let h = date.getHours(); // 0 - 23
            let m = date.getMinutes(); // 0 - 59
            let s = date.getSeconds(); // 0 - 59
            let session = "AM";
            
            if(h == 0){
                h = 12;
            }
            
            if(h > 12){
                h = h - 12;
                session = "PM";
            }
            
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            const time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;
            
            setTimeout(this.showTime, 1000);

        }
    },
    mounted(){
        this.showTime();
    }
}
</script>

<style lang="scss" scoped>
a {
    color: black;
    font-weight: bold;
}
</style>