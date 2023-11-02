<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddRoomModal from "@/Pages/Admin/Room/Modal/AddRoom.vue";
import EditRoomModal from "@/Pages/Admin/Room/Modal/EditRoom.vue";
import axios from 'axios';

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

eventBus.on('ROOM_ADDED', function (data) {
    props.data.push(data)
});

function roomActiveInactive(id) {

    axios.get(route('room.activeInactive', id))
        .then((res) => {
            console.log(res);
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, ind ) in props.data" :key="ind">
                                    <td>
                                        <img  class="img-fliud" style="width: 50px; height: 50px; border-radius: 50%;" :src="base_url+'user_images/'+user.user_info?.image" alt="">
                                    </td>
                                    <th>{{ user.name }}</th>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.user_info?.phone }}</td>
                                    <td>
                                        <VueToggles @click="userActiveInactive(user.id)" :value="user.status" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="edituser(user)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('user.destroy', user.id)"
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
    <EditRoomModal />
</template>


