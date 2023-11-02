<script setup>

import { useForm } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import { ref } from 'vue';
import RequestVisitorModal from "@/Pages/User/Visitor/Modal/RequestVisitorModal.vue";

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


function updateUser() {

    form.post(route('profile.updateProfile'), {
        onSuccess: (res) => {
            if (props.message != null) {
                notify.simpleAlert(props.message, 'success',)
            }
        },
        onError: (err) => {
            console.log(err);
            notify.multiAlert('error', 'oops!', err)
        }
    })
}

function changeLeave(event,id){
    console.log('leave',event.target.value);
    let data = {
        id:id,
        leave:event.target.value,
    }

    axios.post(route('user.visitorLeave'),data)
       .then(res => {
           notify.simpleAlert(res.data.message);
           eventBus.emit('VISIT_ADDED', res.data.data);
       }).catch((err) => {
           if (err.response.status == 422) {
               notify.multiAlert('error', 'Validation error', err.response.data.errors)
           } else {
               notify.simpleAlert('server error','error');
           }

       })
}

eventBus.on('VISIT_ADDED', function (data) {
    props.data.push(data)
});


</script>

<template>
<RequestVisitorModal/>
    <UserLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Visitor List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#requestVisitorModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Room</th>
                                    <th>Arrpove</th>
                                    <th>Visit</th>
                                    <th>leave</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">
                                    <th>{{ ind+1 }}</th>
                                    <th>{{ item.name }}</th>
                                    <th>{{ item.room?.room_number }}</th>
                                    <td>{{ item.arrpove?"Approved":'Not approved' }}</td>
                                    <td>{{ item.visit }}</td>
                                    <td>
                                        <input :value="item.leave" :disabled="!item.arrpove" type="date" @change="changeLeave($event,item.id)" id="">
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
