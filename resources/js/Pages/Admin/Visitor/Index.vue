<script setup>
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from 'axios';

let base_url= _url;

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
 
eventBus.on('ROOM_ADDED', function (data) {
    props.data.push(data)
});

function approveVisitor(id) {

    axios.post(route('visitor.approve'),{id})
        .then((res) => {
            console.log(res);
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
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Visitor List</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Visitor</th>
                                    <th>Room</th>
                                    <th>User</th>
                                    <th>Visit</th>
                                    <th>Leave</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">
                                    <th>{{ ind+1 }}</th>
                                    <th>{{ item.name }}</th>
                                    <td>{{ item.room?.room_number }} </td>
                                    <td>{{ item.user?.name }}</td>
                                    <td>{{ item.visit }}</td>
                                    <td>{{ item.leave }}</td>
                                    <td>
                                        <VueToggles :value="item.approve"  @click="approveVisitor(item.id)" :disabled="item.approve" :class="item.approve?'disabled':''"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>


