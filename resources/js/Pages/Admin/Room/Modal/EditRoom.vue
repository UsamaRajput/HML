<template>
    <!-- Modal -->
    <div class="modal fade" id="editRoomModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="room_number" class="form-label">Number</label>
                        <input id="room_number" class="form-control form-control-sm" v-model="form.room_number" type="text"
                            placeholder="Room number">
                        <label for="capacity" class="form-label">Number</label>

                        <input id="capacity" class="form-control form-control-sm" v-model="form.capacity" type="text"
                            placeholder="Room number">
                        <label for="capacity" class="form-label">price</label>

                        <input id="price" class="form-control form-control-sm" v-model="form.price" type="number"
                            step="0.01" placeholder="Room price">

                        <label for="capacity" class="form-label">room description</label>

                        <input id="price" class="form-control form-control-sm" v-model="form.room_desc" type="text"
                            step="0.01" placeholder="Room description">

                        <label for="image" class="form-label">Image</label>
                        <input id="image" type="file" class="form-control form-control-sm"
                            @input="form.images = $event.target.files" multiple accept="image/*">
                        <div class="container">
                            <div class="row w-100">
                                <div v-for="(imge, ind) in form.preImages" :id="`img-${imge.id}`" :key="ind"
                                    class=" col-md-3">
                                    <div class=" position-relative" >
                                        <img class="img-fliud" style="width: 50px; height: 50px; border-radius: 50%;"
                                            :key="ind" :src="base_url + 'room_images/' + imge.image" alt="">
                                     
                                        <a @click.prevent="delImg(imge.id)" class=" cursor-pointer  position-absolute  bi bi-x"> </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" @click="updateRoom" data-bs-dismiss="modal">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
let base_url = _url;
let form = reactive({
    room_number: '',
    capacity: '',
    room_desc: '',
    price: '',
    images: [],
    preImages: [],
})

eventBus.on('EDIT_ROOM', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('editRoomModal'), {
        keyboard: false
    })

    myModal.show();
    form.id = data.id;
    form.room_desc = data.room_desc;
    form.room_number = data.room_number;
    form.price = data.price;
    form.capacity = data.capacity;
    form.preImages = data.images_room;
});

let delImg = (id) => {
    axios.get(route('room.delImg', id))
        .then(res => {
            document.getElementById('img-' + id).style.display = 'none'
            eventBus.emit('ROOM_UPDATED', res.data.data);
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 422) {
                notify.multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                notify.okAlert('error', 'server error');
            }
        })
}

let updateRoom = () => {
    axios.post(route('room.update', form.id), form, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
        .then(res => {
            eventBus.emit('ROOM_UPDATED', res.data.data);
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 422) {
                notify.multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                notify.okAlert('error', 'server error');
            }
        })
}


</script>
