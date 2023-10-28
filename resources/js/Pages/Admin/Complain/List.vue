<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from 'axios';

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

function editRoom(data) {
    eventBus.emit('EDIT_ROOM', data);
}

eventBus.on('ROOM_ADDED', function (data) {
    props.data.push(data)
});

function complainProgress(fieldName, id) {

    axios.post(route('complain.complainProgress', id), { fieldName })
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
                    <h6 class="mb-4">Complain List</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Message</th>
                                    <th>watched</th>
                                    <th>inprogress</th>
                                    <th>closed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">
                                    <th>{{ ind + 1 }}</th>
                                    <td>
                                        {{ item.user?.name }}
                                    </td>
                                    <td>
                                        {{ item.message }}
                                    </td>
                                    <td>
                                        <VueToggles :disabled="item.watched" @click="complainProgress('watched', item.id)" :value="item.watched" />
                                    </td>
                                    <td>
                                        <VueToggles :disabled="item.inprogress" @click="complainProgress('inprogress', item.id)"
                                            :value="item.inprogress" />
                                    </td>
                                    <td>
                                        <VueToggles :disabled="true" @click="complainProgress('closed', item.id)" :value="item.closed" />
                                    </td>
                                    <td>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('complain.destroy', item.id)"
                                            method="DELETE" as="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </Link>
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


