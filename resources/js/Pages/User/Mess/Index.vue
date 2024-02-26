<script setup>
import { Link } from '@inertiajs/vue3'
import UserLayout from '@/Layouts/UserLayout.vue';
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

</script>


<template>
    <UserLayout>

        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Mess List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th> 
                                    <th>Name</th> 
                                    <th>Time</th> 
                                    <th>Day</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(mess, ind ) in props.data" :key="ind">
                                    <td>{{ ind+1 }}</td>
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
                                   
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>

</template>


