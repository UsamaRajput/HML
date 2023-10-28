<template>
    <!-- Modal -->
    <div class="modal fade" id="requestedRoomModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ name }} Room Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Room</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rr, ind) in r_rooms" :key="ind">
                                    <td>{{ rr.room_number }}</td>
                                    <td>
                                        <button :disabled="disabled" :class="disabled ?? 'disabled'" @click="approve(rr.id)"
                                            class="btn btn-info"></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" @click="rejectRoom" :class="disabled ?? 'disabled'" :disabled="disabled"
                        data-bs-dismiss="modal">Reject</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { okAlert, simpleAlert } from '@/notify';
import { ref, reactive } from 'vue';
let r_rooms = {};

let name = ref('name');
let user_id = null;
let disabled = ref(false);

let approve = (room_id) => {
    disabled.value = true;
    axios.post(route('requested.approveRoom'), { room_id, user_id })
        .then(function (res) {
            if (res.status == 200) {
                simpleAlert(res.data.message);
            } else {
                disabled.value = false;
                okAlert('error', 'Wrong', res.data.message)
            }
        }).catch(function (err) {
            disabled.value = false;
            console.log(err);
        })
}

let rejectRoom = () => {
    disabled.value = true;
    axios.post(route('requested.rejectRoom'), { id: user_id })
        .then(function (res) {
            simpleAlert(res.data.message);
        }).catch(function (err) {
            disabled.value = false;
            console.log(err);
        })
}

eventBus.on('REQUESTED_ROOM', function (data) {
    disabled.value = false;
    r_rooms = data.requested_room;
    name.value = data.name;
    user_id = data.id;
    let myModal = new bootstrap.Modal(document.getElementById('requestedRoomModal'), {
        keyboard: false
    })
    myModal.show();
});

</script>
