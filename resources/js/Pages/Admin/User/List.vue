<script setup>
import { onMounted,ref } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddUserModal from "@/Pages/Admin/User/Modal/AddUser.vue";
import UpdateUserModal from "@/Pages/Admin/User/Modal/UpdateUser.vue";
import RoomHistoryModal from "@/Pages/Admin/User/Modal/RoomHistory.vue";
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

let users = ref(props.data.users)

function room_history (id){
    axios.post(route('room.history'),{user_id:id})
        .then((res) => {  
            eventBus.emit('ROOM_HISTORY', res.data.data); 
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else {
                notify.okAlert('error', 'server error');
            }
        })

}

eventBus.on('USER_UPDATED', function (data) {
    users.value = data
});

eventBus.on('USER_ADDED', function (data) {
    users.value = data
});

let edituser = (user_id)=>{
    axios.get(route('user.edit',user_id))
        .then((res) => { 
            eventBus.emit('ROOM_EDIT', res.data.data);
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else {
                notify.okAlert('error', 'server error');
            }
        })
}

function room_change(event,id) {
    let room_id = event.target.value;

    if(room_id == 'remove'){
        axios.post(route('remove.UserRoom'),{user_id:id})
        .then((res) => { 
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else {
                notify.okAlert('error', 'server error');
            }
        })
    }else{
        axios.post(route('requested.approveRoom'), {user_id:id,room_id})
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
    
}

function delUser(id,ind){
    axios.delete(route('user.destroy', id))
    .then((res)=>{
        document.getElementById(`col-room-${ind}`).style.display = 'none';
        notify.simpleAlert(res.data.message);
    }).catch((err)=>{
        notify.okAlert('error', 'server error');
    })
}

</script>


<template>
    <AdminLayout>
        <div class="row g-5">
            <div class="col-13">
                <div class="bg-light rounded h-100 p-5">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">User List</h6>
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
                                    <th>Room</th>
                                    <th>active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, ind ) in users" :key="ind"  :id="`col-room-${ind}`">
                                    <td>{{ ind + 1}}</td>
                                    <td>
                                        <img  class="img-fliud" style="width: 50px; height: 50px; border-radius: 50%;" :src="base_url+'user_images/'+user.user_info?.image" alt="">
                                    </td>
                                    <th>{{ user.name }}</th>
                                    <td>{{ user.email }}</td> 
                                    <td >
                                        <div class="d-flex"> 
                                            <select class="form-control"  :value="user.rooms[0]?.id" @change="room_change($event,user.id)">
                                                <option value="remove">Remove</option>
                                                <option v-for="room in props.data.rooms" :value="room.id" :disabled="room.users_count >= room.capacity">{{ room.room_number }}</option>
                                            </select>
                                            <button class="btn btn-sm ml-1 btn-info " @click="room_history(user.id)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <!-- <td>{{ user.rooms[0]?.room_number }}</td> -->
                                    <td>
                                        <VueToggles @click="userActiveInactive(user.id)" :value="user.status" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="edituser(user.id)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <a class="btn btn-sm btn-danger ml-1" @click.prevent="delUser(user.id,ind)" 
                                             as="button" type="button">
                                             <i class="fa fa-trash" aria-hidden="true"></i> 
                                        </a>   
                                        <!-- <Link class="btn btn-sm btn-danger ml-1" :href="route('user.destroy', user.id)"
                                            method="DELETE" as="button" type="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </Link> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
    <AddUserModal />
    <UpdateUserModal />
    <RoomHistoryModal />
</template>


