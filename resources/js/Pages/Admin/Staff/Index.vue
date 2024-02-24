<script setup>
import { onMounted ,ref } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddStaffModal from "@/Pages/Admin/Staff/Modal/AddStaff.vue";
import EditStaffModal from "@/Pages/Admin/Staff/Modal/EditStaff.vue";
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
let staff = ref(props.data)
function editStaff(data) {
    eventBus.emit('EDIT_STAFF', data);
}



eventBus.on('STAFF_ADDED', function (data) {
    staff.value = data;
});


</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Staff List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#STAFF_ADDED">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>Name</th>
                                    <th>Phone</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, ind ) in staff" :key="ind">
                                    <td>{{ ind }}</td>
                                    <td>
                                        <img  class="img-fliud" style="width: 50px; height: 50px; border-radius: 50%;" :src="base_url+'staff_images/'+user.image" alt="">
                                    </td>
                                    <th>{{ user.name }}</th>
                                    <td>{{ user.phone }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="editStaff(user)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('staff.destroy', user.id)"
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
    <AddStaffModal />
    <EditStaffModal />
</template>


