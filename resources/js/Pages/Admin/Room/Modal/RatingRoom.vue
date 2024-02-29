<template>
    <!-- Modal -->
    <div class="modal fade" id="RATING_ROOM" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Room Rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="5">Service</th>
                                    <th scope="col" colspan="5">Rating</th>
                                    <th scope="col" >Increment Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr v-for="(rr, ind) in r_rooms" :key="ind">
                                    <td colspan="5"> {{ rr.rating_name }}</td>
                                    <td colspan="5"> {{ rr.rating }}</td>
                                    <td> {{ rr.increment_amount }}</td>
                                    <td>  
                                        <button v-if="rr.room_id != room.id" @click="addRemoveRating(rr.rating_id,room.id,'added')" class="btn btn-sm btn-info">Add</button>
                                        <button v-if="rr.room_id == room.id" @click="addRemoveRating(rr.rating_id,room.id,'remove')" class="btn btn-sm btn-danger">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" @click="redirectRoom" >Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { okAlert, simpleAlert } from '@/notify';
import { ref, reactive } from 'vue';
import { Link,router } from '@inertiajs/vue3';

let r_rooms = ref({});

let room = ref({});
let user_id = null; 

let addRemoveRating = (rating_id,room_id,mode) => {
    axios.post(route('rating.addRemoveRoom'), { room_id,rating_id,mode })
    .then(function (res) {
        if (res.status == 200) {
            r_rooms.value = res.data.data;
            simpleAlert(res.data.message);
        } else { 
            okAlert('error', 'Wrong', res.data.message)
        }
    }).catch(function (err) { 
        console.log(err);
    })
}

let redirectRoom = () =>{
    return router.visit(route('room.index'))
}

eventBus.on('RATING_ROOM', function (data) {
    room.value = data.room;
    r_rooms.value = data.data.data; 
    let myModal = new bootstrap.Modal(document.getElementById('RATING_ROOM'), {
        keyboard: false
    })
    myModal.show();
});

</script>
