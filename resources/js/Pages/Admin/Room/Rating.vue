<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import EditRatingModal from "@/Pages/Admin/Room/Modal/EditRatingModal.vue";
import AddRatingModal from "@/Pages/Admin/Room/Modal/AddRatingModal.vue";
import { VueToggles } from "vue-toggles";
import { Link } from '@inertiajs/vue3'
import axios from 'axios';

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



function editRating(data) {
    eventBus.emit('EDIT_RATING', data);
}

eventBus.on('RATING_ADDED', function (data) {
    props.data.push(data)
});

function roomActiveInactive(id) {

    axios.get(route('rating.activeInactive', id))
        .then((res) => {
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No record Found");
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
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Rating List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addRatingModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rating</th>
                                    <th>service</th>
                                    <th>Increment Price</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rating, ind) in props.data" :key="ind">
                                    <th>{{ ind + 1 }}</th>
                                    <td>{{ rating.rating }}</td>
                                    <td>{{ rating.service }}</td>
                                    <td>{{ rating.increment_amount }}</td>
                                    <td>
                                        <VueToggles :value="rating.is_active" @click="roomActiveInactive(rating.id)" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="editRating(rating)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('rating.destroy', rating.id)"
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
    <EditRatingModal />
    <AddRatingModal />
</template>


