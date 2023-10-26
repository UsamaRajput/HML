<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">New added users</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">City</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <img class="rounded-circle flex-shrink-0" src="https://placehold.co/40" alt=""
                                        style="width: 40px; height: 40px;">
                                </th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                            </tr>

                            <tr>
                                <th>
                                    <img class="rounded-circle flex-shrink-0" src="https://placehold.co/40" alt=""
                                        style="width: 40px; height: 40px;">
                                </th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                            </tr>

                            <tr>
                                <th>
                                    <img class="rounded-circle flex-shrink-0" src="https://placehold.co/40" alt=""
                                        style="width: 40px; height: 40px;">
                                </th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                            </tr>

                            <tr>
                                <th>
                                    <img class="rounded-circle flex-shrink-0" src="https://placehold.co/40" alt=""
                                        style="width: 40px; height: 40px;">
                                </th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">New Complains</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Message</th>
                                <th scope="col">Visit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td><button class="btn btn-sm btn-primary">visit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Visitor</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Visitor</th>
                                <th scope="col">Entry</th>
                                <th scope="col">Leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>3-3-3</td>
                                <td>3-3-3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Room Request</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Current Room</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td><button class="btn btn-sm btn-primary">Check</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
