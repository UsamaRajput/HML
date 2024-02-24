<template>
    <!-- Modal -->
    <div class="modal fade" id="SHOW_USER_GENERAL" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Approve Service</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 ">

                        <table>
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Date</td>
                                    <td>Entry</td>
                                    <td>Exit</td>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr v-for="(item, index) in users" :key="index" :id="`gap${index}`">
                                    <td>
                                        {{ item.name }}
                                    </td> 
                                    <td>
                                        {{ item.date }}
                                    </td>
                                    <td>
                                        {{ item.entry }}
                                    </td>
                                    <td>
                                        {{ item.exit }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-column">
                                            <div>
                                                <button class="btn btn-sm btn-info " @click="approveService(item.id,'approve',index)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger " @click="approveService(item.id,'reject',index)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>

                                        </div>
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
import { useForm } from '@inertiajs/vue3';
import { reactive,ref } from 'vue';

// let users = reactive({
//     id:null,
//     name:null
// });
let id = ref(null)
let users = ref({});

eventBus.on('SHOW_USER_GENERAL', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('SHOW_USER_GENERAL'), {
        keyboard: false
    });  
    myModal.show();
    id.value = data.id
    users.value = data.users;
});

function approveService(uid,status,index){

    axios.post(route('services.approveAction'),{service_id:id.value,user_id:uid,status})
        .then((res) => {
            notify.simpleAlert(status);
            eventBus.emit('GSERVICE_UPDATE',  res.data.data);
            document.getElementById('gap'+index).style.display = 'none'
        }).catch((err) => {
            notify.okAlert('error', 'server error');
        })
}

function rejectUser(){
    console.log('res');
}

</script>
