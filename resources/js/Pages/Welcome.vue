<script setup>


import { Head, Link } from '@inertiajs/vue3';
import "../../css/user/user.css";
import "../../css/user/style.css";
import { ref,reactive } from 'vue'; 
// import "../../css/user/slicknav.css";
// import "../../css/user/flaticon.css"; 
// import "../../css/user/slicknav.css";
// import "../../css/user/flaticon.css";
import { Icon } from '@iconify/vue';
let base_url= _url;

let props = defineProps({
    data: {
        type: Object,
    },
    canLogin: {
        type: Boolean,
    },
    auth: {
        type: Object,
    },

}); 

let disable = ref(false);

let paginate = ref({
    current_page:1,
    last_page:2
});

let rooms = reactive(props.data.rooms.data);

let form = ref({
    name:null,
    email:null,
    message:null
});
let pagiHide = ref(false);
function contactMail() {
    disable.value = true;
    form.value = {};
    axios.post(route('contactMail'),form.value )
    .then(res => {
        disable.value = false;
        notify.simpleAlert('Mail sent successfully');
    }).catch((err) => {
        disable.value = false;
        notify.simpleAlert('Something Wrong', 'error');
    });
 
}

function loadMore(){
    
    if(paginate.value.last_page <= paginate.value.current_page && paginate.value.current_page != 1){
        pagiHide.value = true; 
        return ;
    }
    paginate.value.current_page = paginate.value.current_page+1;

    axios.get(route('room.paginate',{page:paginate.value.current_page}) )
    .then(res => {   
        rooms.push(res.data.data.data[0]);
        paginate.value.current_page = res.data.data.current_page;
        paginate.value.last_page = res.data.data.last_page;

    }).catch((err) => {
        disable.value = false;
        notify.simpleAlert('Something Wrong', 'error');
    });
}

</script>


<template class="template">
    <Head title="Welcome" />
    <header class="header-section">
        <div class="menu-item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <h2>
                                HMS
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li class="active"><a href="/">Home</a></li>
                                    <li><a href="#rooms-all">Rooms</a></li>
                                    <li><a href="#about-us">About Us</a></li>
                                    <li><Link :href="route('login')" v-if="canLogin">Login</Link></li>
                                    <li><Link :href="route('user.rooms')" v-if="!canLogin && props?.auth?.user?.role!=1">Panel</Link></li>


                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- hero-section -->
    <section class="hero-section"  :style="`background-image: url('${base_url}main_images/${props.data.main_content.banner}');background-size: coverlog;background-repeat: repeat;` ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="hero-text">
                        <h1>{{ props.data.main_content.title }}</h1>
                        <p>{{ props.data.main_content.content }}</p> 
                    </div>
                </div>
                <!-- <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Contact Us </h3>
                        <form   @submit.prevent="contactMail">
                            <div class="check-date">
                                <label for="date-in">Name:</label>
                                <input type="text" v-model="form.name">

                            </div>
                            <div class="check-date">
                                <label for="date-out">Email:</label>
                                <input type="email" v-model="form.email">

                            </div>
                            <div class="check-date">
                                <label for="date-out">Message:</label>
                                <input type="text" v-model="form.message">

                            </div>

                            <button type="submit" :disabled="disable">Send</button>

                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad" id="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Superintendent</span>
                            <h3>{{ props.data.main_content.superintendent_name }} </h3>
                        </div>
                        <p class="f-para"> {{ props.data.main_content.superintendent_desc }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-12">
                                <img :src="`${base_url}main_images/${props.data.main_content.superintendent_image}`" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section End -->
    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Discover Our Service</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6" v-for="(service, ind) in props.data.services" :key="ind">
                    <div class="service-item">
                        <h4>{{ service.name }}</h4>
                        <p>{{ service.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section" id="rooms-all">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Discover Our Room</span>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3" v-for="(room , ind) in rooms" :key="ind">
                        <div class="hp-room-item set-bg " 
                        :style="`background-image: url('${base_url}room_images/${room?.images_room[0]?.image}');`"
                        >
                            <div class="hr-text" style="background: black; border-radius: 5px; opacity: 0.5; padding: 20px;" >
                                <h3>Room {{ room.room_number }}</h3><br>
                                <h2>{{ parseFloat(room.price??0) + parseFloat(room.amount??0) }} RS</h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max {{room.capacity}}</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Stars:</td>
                                            <td>{{ parseFloat(room.rating??0,2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Link :href="route('user.room_details',room.id)" class="primary-btn">More Details</Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" v-show="!pagiHide">
                    <div class="offset-md-4 col-md-4 text-center">
                        <span class="btn btn-warning btn-block" @click="loadMore">Load More</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Meet</span>
                        <h2>Our Staff</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-for="(staf,ind) in props.data.staff" :key="ind" class="col-lg-4">
                    <div class="blog-item set-bg "  :style="`background-image:url('${base_url}staff_images/${staf.image}')`"  >
                        <div class="bi-text">
                            <span class="b-tag">{{staf.name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img :src="`../../img/footer-logo.png`" alt="">
                                </a>
                            </div>
                            <p>We inspire and reach millions of travelers<br /> across 90 local websites</p>

                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                <li>(12) 345 67890</li>
                                <li>info.hms@gmail.com</li>
                                <li>gcs LHR.</li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <ul>
                            <li><a href="#">Contact</a></li>  
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text">
                            <p>
                                Copyright &copy; All rights reserved 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->
</template>

<!--


<style>
.hp-room-items{
    margin-right: -15px;
    overflow: hidden;
    height: 600px;

}
.set-bg{
    background-repeat: no-repeat;
}
</style> -->

<style>
 

.set-bg.hero2 {

    background-image: url("../../images/hero-2.jpg");

}

.set-bg.hero3 {

    background-image: url("../../images/hero-3.jpg");


}

.set-bg.room1 {

    background-image: url("../../images/room-b1.jpg");

}

.set-bg.room2 {

    background-image: url("../../images/room-b2.jpg");

}

.set-bg.room3 {

    background-image: url("../../images/room-b3.jpg");

}

.set-bg.room4 {

    background-image: url("../../images/room-b4.jpg");

}

.set-bg.blog1 {

    background-image: url("../../images/blog-1.jpg");

}

.set-bg.blog2 {

    background-image: url("../../images/blog-2.jpg");

}

.set-bg.blog3 {

    background-image: url("../../images/blog-3.jpg");

}

.set-bg.blog4 {

    background-image: url("../../images/blog-wide.jpg");

}

.set-bg.blog5 {

    background-image: url("../../images/blog-10.jpg");

}</style>
