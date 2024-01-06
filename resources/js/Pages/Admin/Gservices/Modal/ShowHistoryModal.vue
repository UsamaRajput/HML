<template>
    <!-- Modal -->
    <div class="modal fade" id="SHOW_USER_GENERAL_HISTORY" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Service History</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 ">

                        <table>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr v-for="(item, index) in services" :key="index">

                                    <td>
                                        {{index}}
                                    </td>
                                    <td>
                                        {{ item.name }}
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
import { ref } from 'vue';

// let services = reactive({
//     id:null,
//     name:null
// });
let id = ref(null)
let services = ref({});

eventBus.on('SHOW_USER_GENERAL_HISTORY', function (data) {

    let myModal = new bootstrap.Modal(document.getElementById('SHOW_USER_GENERAL_HISTORY'), {
        keyboard: false
    });

    myModal.show();
    services.value = data.data;
});

</script>
