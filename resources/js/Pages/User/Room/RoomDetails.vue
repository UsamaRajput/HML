<script setup>
import { Head, Link } from '@inertiajs/vue3';
import "../../../../css/user/detail.css"
import "../../../../css/user/user.css";
import "../../../../css/user/style.css";
import { ref,onMounted } from 'vue';
// import "../../css/user/slicknav.css";
// import "../../css/user/flaticon.css";
// import { Icon } from '@iconify/vue';


let base_url = _url;

let props = defineProps({
    data: {
        type: Object,
    },
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


let activeImage = ref(0);

let images = ref([{
    url: 'http://placekitten.com/400/251', thumbnailUrl: 'http://placekitten.com/200/120'
}]);

function changeActiveImage(index) {
    this.activeImage = index;
}



onMounted(()=>{
    // console.log('props.data.data',props.data.images_room);
    images.value = props.data.images_room.map((item)=>{
        return {
            url: `${base_url}room_images/${item.image}`,
            thumbnailUrl: `${base_url}room_images/${item.image}`
        }
    });
    console.log('images.value',images.value);

});
</script>



 
<template


>
    <Head title="Room-Details" />
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
                                <div v-for="(image, index) in images" :key="index"
                                    :class="{ 'tab-pane': true, 'active': index === activeImage }"
                                    :id="'pic-' + (index + 1)">
                                    <img :src="image.url" @click="changeActiveImage(index)" />
                                </div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <li v-for="(image, index) in images" :key="index"
                                    :class="{ 'active': index === activeImage }">
                                    <a :data-target="'#pic-' + (index + 1)" data-toggle="tab"
                                        @click="changeActiveImage(index)">
                                        <img :src="image.thumbnailUrl" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="details col-md-6">
                            <h3 class="product-title">men's shoes fashion</h3>
                            <div class="rating">
                                <div class="stars"> 
                                    <template v-for="(val,ind) in 5">
                                        <span class="fa fa-star" :class="val > parseInt( props.data.rating??0) ?'':'checked'"></span>
                                    </template>
                                     
                                </div> 
                            </div>
                            <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium
                                cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
                            <h4 class="price">current price: <span>{{ parseFloat( props.data.price??0) + parseFloat( props.data.amount??0) }} RS</span></h4>
                            <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong>
                            </p>
                        
                            <div class="action mt-3">
                                <h6>For booking</h6>
                                <Link v-if="canLogin" :href="route('login')" class="add-to-cart btn btn-default" type="button">Login/Register</Link>                              
                                <Link v-if="!canLogin" :href="route('user.rooms')" class="add-to-cart btn btn-default" type="button">Visit for request</Link>                              
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
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Rooms</th>
                                            <th>Space</th>
                                            <th>Beds</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-secondary">
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
                                </div>
                                <hr>
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
                                </div>
                                <hr>
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
                                </div>
                                <hr>



























































                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</main></template>



