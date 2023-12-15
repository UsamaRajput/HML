<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import RequestedModal from "@/Pages/Admin/Room/Modal/RequestedModal.vue";
import axios from "axios";

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


function requestedRoom(id) {
    axios.post(route('requested.requestedRoom'),{id})
    .then(function(res){
        // console.log('res.data.data',res.data.data);
        eventBus.emit('REQUESTED_ROOM', res.data.data);
    }).catch(function(err){
        console.log(err);
    })
}
</script>

<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Requested Users</h6>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(req, ind) in props.data">
                                    <th>{{ ind + 1 }}</th>
                                    <td>{{ req.name }}</td>
                                    <td>{{ req.user_info?.image ?? '' }}</td>
                                    <td>{{ req.user_info?.phone ?? '' }} </td>
                                    <td>

                                        <button class="btn btn-sm btn-info " @click="requestedRoom(req.id)">
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
    <RequestedModal />
</template>


