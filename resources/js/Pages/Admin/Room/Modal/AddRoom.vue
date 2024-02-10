<template>
    <!-- Modal -->
    <div class="modal fade" id="adRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="bg-light rounded h-100 p-4">

                            <label for="room_number" class="form-label">Number</label>
                            <input id="room_number" class="form-control form-control-sm" v-model="form.room_number"
                                type="text" placeholder="Room number">
                            <label for="capacity" class="form-label">Capacity</label>

                            <input id="capacity" class="form-control form-control-sm" v-model="form.capacity" type="text"
                                placeholder="Room Capacity">
                            <label for="capacity" class="form-label">price</label>

                            <input id="price" class="form-control form-control-sm" v-model="form.price" type="number" step="0.01"
                                placeholder="Room price">
                            <label for="room_desc" class="form-label">room description</label>

                            <input id="room_desc" class="form-control form-control-sm" v-model="form.room_desc" type="text" 
                                placeholder="Room Description">
                            <label for="image" class="form-label">Image</label>
                            <input id="image" type="file" class="form-control form-control-sm"
                                @input="form.images = $event.target.files" multiple accept="image/*">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal" @click="createRoom">Add</button>
                    </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { multiAlert, simpleAlert } from "@/notify";
let form = reactive({
    room_number: '',
    price: '',
    capacity: '',
    room_desc:'',
    images: []
})

let createRoom = () => {
    axios.post(route('room.store'), form, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
        .then(res => {
            simpleAlert(res.data.message);
            eventBus.emit('ROOM_ADDED', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                simpleAlert('server error','error');
            }

        })
}


</script>
