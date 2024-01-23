<template>
    <!-- Modal -->
    <div class="modal fade" id="ROOM_HISTORY" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> Room Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="5">Room</th>
                                    <th scope="col">Allocation Date</th>
                                    <th scope="col">Leaving Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr v-for="(rr, ind) in r_rooms" :key="ind">
                                    <td colspan="5"> {{ rr.room_number }}</td>
                                    <td> {{ rr.allocation_date }} </td>
                                    <td> {{ rr.leaving_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { okAlert, simpleAlert } from '@/notify';
import { ref } from 'vue';
let r_rooms = ref([]);

let name = ref('name');

eventBus.on('ROOM_HISTORY', function (data) {
    console.log('data.rooms',data);
    r_rooms.value = data;  
    let myModal = new bootstrap.Modal(document.getElementById('ROOM_HISTORY'), {
        keyboard: false
    })
    myModal.show();
});

</script>
