<script setup>
import { Head, Link } from '@inertiajs/vue3';
import "../../../../css/user/detail.css"
import "../../../../css/user/user.css";
import "../../../../css/user/style.css";
import { ref, onMounted } from 'vue';
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
    related: {
        type: Object,
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



onMounted(() => {
    // console.log('props.data.data',props.data.images_room);
    images.value = props.data.images_room.map((item) => {
        return {
            url: `${base_url}room_images/${item.image}`,
            thumbnailUrl: `${base_url}room_images/${item.image}`
        }
    });
    console.log('images.value', images.value);

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
                            <h3 class="product-title">Room Number {{ props.data.room_number }}</h3>
                            <div class="rating">
                                <div class="stars">
                                    <template v-for="(val, ind) in 5">
                                        <span class="fa fa-star"
                                            :class="val > parseInt(props.data.rating ?? 0) ? '' : 'checked'"></span>
                                    </template>

                                </div>
                            </div>
                            <h4 class="price">current price: <span>{{ parseFloat(props.data.price ?? 0) + parseFloat(
                                props.data.amount ?? 0) }} RS</span></h4>
                            <div class="action mt-3">
                                <h3>For booking</h3>
                                <Link v-if="canLogin" :href="route('login')" class="add-to-cart btn btn-default"
                                    type="button">Login/Register</Link>
                                <Link v-if="!canLogin" :href="route('user.rooms')" class="add-to-cart btn btn-default"
                                    type="button">Visit for request</Link>
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
                                    {{ props.data.room_desc }}
                                    <hr>
                                </p>
                            <h3 class="product-title">Services</h3>
                                <table class="table  ">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Stars</th>
                                            <th>Service Name</th>
                                            <th>Charges</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-secondary">
                                        <tr v-for="rating in props.data.ratings">
                                            <td>
                                                <div class="stars">
                                                    <template v-for="(val, ind) in 5">
                                                        <span class="fa fa-star"
                                                            :class="val > parseInt(rating.rating ?? 0) ? '' : 'checked'"></span>
                                                    </template>
                                                </div>
                                            </td>
                                            <td>{{rating.service}}</td>
                                            <td>{{ rating.increment_amount }}</td>
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
                               <template v-for="item in props.related">
                                <div class="row">
                                    <div class="col-4">
                                        <img :src="`${base_url}room_images/${item.images_room[0]?.image}`" alt="">
                                    </div>
                                    <div class="col-8">
                                        <a href="" class="text-decoration-none">
                                            <h6>Room Number {{ item.room_number }}</h6>
                                            <p class="room-details">
                                                {{ item.room_desc }}
                                            </p>
                                        </a>
                                    </div>
                                    </div>
                                    <hr>
                               </template>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</template>



