<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddMessModal from "@/Pages/Admin/Mess/Modal/AddMess.vue"; 
import UpdateMessModal from "@/Pages/Admin/Mess/Modal/UpdateMess.vue"; 
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

function editMess(data) {
    axios.get(route('mess.edit',data))
    .then(res => { 
        console.log('res.data.data',res.data);
        eventBus.emit('EDIT_MESS', res.data); 
    }).catch((err) => {
        notify.simpleAlert('server error', 'error');
    })
}



eventBus.on('MESS_ADDED', function (data) {
    props.data.push(data)
});


</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Mess List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#MESS_ADDED">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th> 
                                    <th>Name</th> 
                                    <th>Time</th> 
                                    <th>Day</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(mess, ind ) in props.data" :key="ind">
                                    <td>{{ ind }}</td>
                                    <th>{{ mess.name }}</th> 
                                    <th><input type="time" readonly :value="mess.time"/></th>  
                                    <th> 
                                        <select v-model="mess.day" disabled>
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thrusday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturady</option>
                                            <option value="7">Sunday</option>
                                        </select>
                                    </th> 
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="editMess(mess.id)">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <Link class="btn btn-sm btn-danger ml-1" :href="route('mess.destroy', mess.id)"
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
    <AddMessModal/> 
    <UpdateMessModal/> 
</template>


