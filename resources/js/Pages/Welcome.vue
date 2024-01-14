<script setup>


import { Head, Link } from '@inertiajs/vue3';
import "../../css/user/user.css";
import "../../css/user/style.css";
// import "../../css/user/slicknav.css";
// import "../../css/user/flaticon.css";
import { Icon } from '@iconify/vue';


let props = defineProps({
    data: {
        type: Object,
    },
    canLogin: {
        type: Boolean,
    },

});




</script>






<template class="template">
    <Head title="Welcome" />
    <header class="header-section">
        <div class="top-nav">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><i class="fa fa-phone"></i> (12) 345 67890</li>
                            <li><i class="fa fa-envelope"></i> info.colorlib@gmail.com</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                            <a href="#" class="bk-btn">Booking Now</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                    <li class="active"><a href="./index.html">Home</a></li>
                                    <li><a href="./rooms.html">Rooms</a></li>
                                    <li><a href="#about-us">About Us</a></li>


                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <!-- hero-section -->
    <section class="hero-section" style="background-image: url({{ props.data.main_content.banner }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">

                    <div class="hero-text">
                        <h1>Sona A Luxury Hotel</h1>
                        <p>Here are the best hotel booking sites, including recommendations for international
                            travel and for finding low-priced hotel rooms.</p>
                        <a href="#" class="primary-btn">Discover Now</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Contact Us </h3>
                        <form action="#">
                            <div class="check-date">
                                <label for="date-in">Name:</label>
                                <input type="text">

                            </div>
                            <div class="check-date">
                                <label for="date-out">Email:</label>
                                <input type="email">

                            </div>
                            <div class="check-date">
                                <label for="date-out">Message:</label>
                                <input type="text">

                            </div>

                            <button type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
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
                                <img src="../../images/about-1.jpg" alt="">
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
                        <span>Discover Our Services</span>
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
    <section class="hp-room-section" id="about-us">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    <div class="col-lg-3 col-md-6" v-for="(room , ind) in props.data.rooms" :key="ind">
                        <div class="hp-room-item set-bg room1" style="background-image: url({{ props.data.room.banner }});">
                            <div class="hr-text">
                                <h3>{{ room.room_number }}</h3>
                                <h2>199$</h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Link :href="route('user.room_details')" class="primary-btn">More Details</Link>
                            </div>
                        </div>
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
                        <span>Hotel News</span>
                        <h2>Our Blog & Event</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item set-bg blog1" data-setbg="img/blog/blog-1.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Travel Trip</span>
                            <h4><a href="#">Tremblant In Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg blog2" data-setbg="img/blog/blog-2.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Camping</span>
                            <h4><a href="#">Choosing A Static Caravan</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg blog3" data-setbg="img/blog/blog-3.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Event</span>
                            <h4><a href="#">Copper Canyon</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg blog4" data-setbg="img/blog/blog-wide.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Event</span>
                            <h4><a href="#">Trip To Iqaluit In Nunavut A Canadian Arctic City</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg blog5" data-setbg="img/blog/blog-10.jpg">
                        <div class="bi-text">
                            <span class="b-tag">Travel</span>
                            <h4><a href="#">Traveling To Barcelona</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12th April, 2019</div>
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
                                    <img src="img/footer-logo.png" alt="">
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
                                <li>info.colorlib@gmail.com</li>
                                <li>856 Cordia Extension Apt. 356, Lake, United State</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>New latest</h6>
                            <p>Get the latest updates and offers.</p>
                            <form action="#" class="fn-form">
                                <input type="text" placeholder="Email">
                                <button type="submit">
                                    <Icon icon="bx:send" style=" color:white;" />
                                </button>
                            </form>
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
                            <li><a href="#">Terms of use</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Environmental Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="co-text">
                            <p>
                                Copyright &copy; All rights reserved | This template is made with <i class="fa fa-heart"
                                    aria-hidden="true"></i> by <a href="#" target="_blank"></a>
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
.hero-section {

    background-image: url("../../images/hero-3.jpg");

}

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
