<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddRoomModal from "@/Pages/Admin/Room/Modal/AddRoom.vue";
import RatingRoomModal from "@/Pages/Admin/Room/Modal/RatingRoom.vue";
import EditRoomModal from "@/Pages/Admin/Room/Modal/EditRoom.vue";
import axios from 'axios';
import { ref } from 'vue';

let base_url= _url;

const props = defineProps({
    data: {
        type: Object,
    },
    error: {
        type: String
    },
    message: {
        type: String
    }
});

function editRoom(data) {
    eventBus.emit('EDIT_ROOM', data);
}

function ratingRoom(param) {
    axios.post(route('rating.room'),{id:param.id})
    .then((res) => {
        eventBus.emit('RATING_ROOM', {data:res.data,room:param});
    }).catch((err) => {
        if (err.response.status == 404) {
            notify.okAlert('error', "No Room Found");
        } else {
            notify.okAlert('error', 'server error');
        }
    })

}
let rooms = ref( props.data);
eventBus.on('ROOM_ADDED', function (data) {
    rooms.value.push(data)
});


eventBus.on('ROOM_UPDATED', function (data) {
    rooms.value = data;
});

function roomActiveInactive(id) {

    axios.get(route('room.activeInactive', id))
        .then((res) => { 
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else {
                notify.okAlert('error', 'server error');
            }
        })
}

</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Rooms List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#adRoomModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>rating</th>
                                    <th>Amount</th>
                                    <th>Capacity</th>
                                    <th>Current</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(room, ind ) in rooms" :key="ind">
                                    <th>{{ room.room_number }}</th>
                                    <td>
                                        <template v-for="(img, im) in room.images_room" >
                                            <a :href="base_url+'room_images/'+img.image" target="_blank">
                                                <img class="img-fliud" style="width: 50px; height: 50px; border-radius: 50%;" :key="im" :src="base_url+'room_images/'+img.image" alt="">
                                            </a>
                                        </template>
                                    </td>
                                    <td>{{ room.rating }}</td>
                                    <td>{{ (parseFloat(room.price)??0 )+ (parseFloat(room.amount)??0) }}</td>
                                    <td>{{ room.capacity }}</td>
                                    <td>{{ room?.users?.length }}</td>
                                    <td>
                                        <VueToggles @click="roomActiveInactive(room.id)" :value="room.is_active" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning mr-1" @click="ratingRoom(room)">
                                            <i class="fa fa-star"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info " @click="editRoom(room)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('room.destroy', room.id)"
                                            method="DELETE" as="button" type="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
    <AddRoomModal />
    <RatingRoomModal />
    <EditRoomModal />
</template>


