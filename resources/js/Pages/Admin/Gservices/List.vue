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

function edititem(data) {
    eventBus.emit('EDIT_GSERVICE', data);
}

function showUser(id){

    axios.get(route('services.show', id))
        .then((res) => {
            eventBus.emit('SHOW_USER_GENERAL',res.data.data);
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
                                    <th>Active</th>
                                    <th>Requests</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">

                                    <th>{{ ind+1 }}</th>
                                    <th>{{ item.name }}</th>
                                    <td>
                                        <VueToggles @click="itemActiveInactive(item.id)" :value="item.is_active" />
                                    </td>
                                    <td>{{ item.users_count }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="showUser(item.id)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="edititem(item)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('services.destroy', item.id)"
                                            method="DELETE" as="button" type="button">
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
    <AddServiceModal />
    <EditServiceModal />
    <ShowUserModal />
</template>


