<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { VueToggles } from "vue-toggles";

</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Rooms List</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>Capacity</th>
                                    <th>Current</th>
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
                                        <VueToggles :value="true"/>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info ml-1">
                                            <i class="fa fa-pencil-alt"></i>
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
</template>

