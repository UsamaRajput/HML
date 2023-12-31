<script setup>


import { Head, Link } from '@inertiajs/vue3';
import "../../../../css/user/detail.css"
import "../../../../css/user/user.css";
import "../../../../css/user/style.css";
// import "../../css/user/slicknav.css";
// import "../../css/user/flaticon.css";
// import { Icon } from '@iconify/vue';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});




</script>



<script>
export default {
  data() {
    return {
      activeImage: 0, // Initially set to the first image
      images: [
        { url: 'http://placekitten.com/400/251', thumbnailUrl: 'http://placekitten.com/200/120' },
        { url: 'http://placekitten.com/400/252', thumbnailUrl: 'http://placekitten.com/200/123' },
        { url: 'http://placekitten.com/400/254', thumbnailUrl: 'http://placekitten.com/200/122' },
        { url: 'http://placekitten.com/400/260', thumbnailUrl: 'http://placekitten.com/200/131' },
        { url: 'http://placekitten.com/400/256', thumbnailUrl: 'http://placekitten.com/200/124' },
      ],
    };
  },
  methods: {
    changeActiveImage(index) {
      this.activeImage = index;
    },
  },
};
</script>
<template


>
    <Head title="Room-Details" />
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
                                    <li class="active">
                                        <Link href="/">Home</Link>
                                    </li>
                                    <li>
                                        <Link href="#">Rooms</Link>
                                    </li>
                                    <li>
                                        <Link href="/#about-us">About Us</Link>
                                    </li>


                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <main class="detail-section">
        <div class="container-fluid">
            <div class="card">
                <div class="container">
                    <div class="wrapper row">
                        <div class="preview col-md-6">
    <div class="preview-pic tab-content">
      <div v-for="(image, index) in images" :key="index" :class="{ 'tab-pane': true, 'active': index === activeImage }" :id="'pic-' + (index + 1)">
        <img :src="image.url" @click="changeActiveImage(index)" />
      </div>
    </div>
    <ul class="preview-thumbnail nav nav-tabs">
      <li v-for="(image, index) in images" :key="index" :class="{ 'active': index === activeImage }">
        <a :data-target="'#pic-' + (index + 1)" data-toggle="tab" @click="changeActiveImage(index)">
          <img :src="image.thumbnailUrl" />
        </a>
      </li>
    </ul>
  </div>
                        <div class="details col-md-6">
                            <h3 class="product-title">men's shoes fashion</h3>
                            <div class="rating">
                                <div class="stars">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <span class="review-no">41 reviews</span>
                            </div>
                            <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium
                                cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
                            <h4 class="price">current price: <span>$180</span></h4>
                            <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong>
                            </p>
                            <h5 class="sizes">sizes:
                                <span class="size" data-toggle="tooltip" title="small">s</span>
                                <span class="size" data-toggle="tooltip" title="medium">m</span>
                                <span class="size" data-toggle="tooltip" title="large">l</span>
                                <span class="size" data-toggle="tooltip" title="xtra large">xl</span>
                            </h5>
                            <h5 class="colors">colors:
                                <span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
                                <span class="color green"></span>
                                <span class="color blue"></span>
                            </h5>
                            <div class="action mt-3">
                                <button class="add-to-cart btn btn-default" type="button">add to cart</button>
                                <button class="like btn btn-default ms-3" type="button"><span
                                        class="fa fa-heart"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="details">
            <div class="container">
                <div class="row">
                    <div class="col-8">

                        <div class="card">
                            <div class="card-header">
                                <h2>Details</h2>
                            </div>
                            <div class="card-body">
                                <p class="text">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum dolore modi soluta
                                    aperiam dolorum ut, magni, officiis numquam ipsum delectus quidem neque ad. Ipsa hic
                                    inventore aut voluptatem cumque amet nam commodi, sit porro corrupti magni quaerat
                                    incidunt quod possimus odit architecto numquam dolore. Aut magni eius distinctio
                                    mollitia? Amet.
                                    <hr>
                                </p>
                                <table class="table  ">
                                    <thead class="table-warning" >
                                        <tr>
                                            <th>Rooms</th>
                                            <th>Space</th>
                                            <th>Beds</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-secondary">
                                        <tr >
                                            <td >1</td>
                                            <td >20ft</td>
                                            <td >3</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>20ft</td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>20ft</td>
                                            <td>3</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>



























                        </div>







                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h2>Similar Items</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-4">

                                        <img src="../../../../images/bed-rooms.jpg" alt="">
                                    </div>
                                    <div class="col-8">
                                        <a href="" class="text-decoration-none">
                                            <h4>Bed Room</h4>
                                            <p class="room-details">
                                                Lorem ipsum dolor sit amet consectetur
                                            </p>
                                        </a>
                                    </div>
                                </div> <hr>  <div class="row">

                                    <div class="col-4">

                                        <img src="../../../../images/bed-rooms.jpg" alt="">
                                    </div>
                                    <div class="col-8">
                                        <a href="" class="text-decoration-none">
                                            <h4>Bed Room</h4>
                                            <p class="room-details">
                                                Lorem ipsum dolor sit amet consectetur
                                            </p>
                                        </a>
                                    </div>
                                </div> <hr> <div class="row">

                                    <div class="col-4">

                                        <img src="../../../../images/bed-rooms.jpg" alt="">
                                    </div>
                                    <div class="col-8">
                                        <a href="" class="text-decoration-none">
                                            <h4>Bed Room</h4>
                                            <p class="room-details">
                                                Lorem ipsum dolor sit amet consectetur
                                            </p>
                                        </a>
                                    </div>
                                </div> <hr>



























































                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</template>



