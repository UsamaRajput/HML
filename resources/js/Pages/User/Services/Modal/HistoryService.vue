<template>
    <!-- Modal -->
    <div class="modal fade" id="HISTORY_SERVICE" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                    <th scope="col">Date</th>
                                    <th scope="col">Entry</th>
                                    <th scope="col">Exit</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rr, ind) in history_service" :key="ind">
                                    <td >{{ rr.date }}</td>
                                    <td >{{ rr.entry }}</td>
                                    <td >{{ rr.exit }}</td>
                                    <td>
                                        <button  disabled="true"
                                            class="btn btn-sm btn-primary">{{rr.status==1?'approved':(rr.status==2?'rejected':'pending')}}</button>
                                    </td>
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
import { ref, reactive } from 'vue';

let history_service = ref({});

// let approve = (room_id) => {
//     disabled.value = true;
//     axios.post(route('requested.approveRoom'), { room_id, user_id })
//         .then(function (res) {
//             if (res.status == 200) {
//                 simpleAlert(res.data.message);
//             } else {
//                 disabled.value = false;
//                 okAlert('error', 'Wrong', res.data.message)
//             }
//         }).catch(function (err) {
//             disabled.value = false;
//             console.log(err);
//         })
// }



eventBus.on('HISTORY_SERVICE', function (data) {

    history_service.value = data;
    let myModal = new bootstrap.Modal(document.getElementById('HISTORY_SERVICE'), {
        keyboard: false
    })

    myModal.show();
});

</script>
