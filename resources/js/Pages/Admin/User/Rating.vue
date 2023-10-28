<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import EditRatingModal from "@/Pages/Admin/Room/Modal/EditRatingModal.vue";
import AddRatingModal from "@/Pages/Admin/Room/Modal/AddRatingModal.vue";
import { VueToggles } from "vue-toggles";

function editRating() {
    eventBus.emit('RATING_ROOM','hdsfsd');
}

</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Rooms List</h6>
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
                                    <th>Images</th>
                                    <th>Capacity</th>
                                    <th>Current</th>
                                    <th>Room</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>jhon@email.com</td>
                                    <td>
                                        <select id="assignRoom" class="form-select-sm">
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                        </select>
                                    </td>
                                    <td>
                                        <VueToggles :value="true" />
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="editRating">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
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
    <EditRatingModal />
    <AddRatingModal />
</template>


