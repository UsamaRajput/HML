<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddServiceModal from "@/Pages/Admin/Gservices/Modal/AddServiceModal.vue";
import EditServiceModal from "@/Pages/Admin/Gservices/Modal/EditServiceModal.vue";
import ShowUserModal from "@/Pages/Admin/Gservices/Modal/ShowUserModal.vue";

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

 function showHistory(id){

    axios.post(route('services.show_hostory'),{user_id:id})
        .then((res) => {
            eventBus.emit('SHOW_USER_GENERAL_HISTORY',{id,users:res.data.data});
        }).catch((err) => {
            notify.okAlert('error', 'server error');
        })
}



</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Services List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#AddServiceModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>count</th>
                                    <th>History</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">
                                    <th>{{ ind+1 }}</th>
                                    <th>{{ item.name }}</th>
                                    <td>{{ item.general_services_count }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="showHistory(item.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
    <AddServiceModal />
    <EditServiceModal />
    <ShowUserModal />
</template>


