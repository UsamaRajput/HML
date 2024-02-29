<script setup>
import { useForm } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';

let base_url = _url;

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

function search(val, arr){
    for (let i=0; i < arr.length; i++) {
        if (arr[i].id === val) {
            return true;
        }
    }
}

function requestRoom(id){
    axios.post(route('user.requestRoom'), {id})
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
    <UserLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Rooms List</h6> 
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>Capacity</th>
                                    <th>Current</th>
                                    <th>Price</th>
                                    <th>Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(room, ind ) in props.data" :key="ind">
                                    <th>{{ room.room_number }}</th>
                                    <td>
                                        <template  v-for="(img, im) in room.images_room" >
                                            <a :href="base_url+'room_images/'+img.image" target="_blank" rel="noopener noreferrer">
                                                <img style="width: 50px; height: 50px; border-radius: 50%;" class="img-fliud"   :src="base_url+'room_images/'+img.image" alt="">
                                            </a>
                                        </template>
                                    </td>
                                    <td>{{ room.capacity }}</td>
                                    <td>{{ room.users.length??0 }}</td>
                                    <td>{{ parseFloat(room.price??0) + parseFloat(room.amount??0) }}</td>
                                    <td>
                                        <button v-if="!search($page.props.auth.user.id,room.users )" class="btn btn-sm btn-info " @click="requestRoom(room.id)">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
