<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import AddUserModal from "@/Pages/Admin/User/Modal/AddUser.vue";
import UpdateUserModal from "@/Pages/Admin/User/Modal/UpdateUser.vue";
import DeductionHistoryModal from "@/Pages/Admin/User/Modal/DeductionHistory.vue";
import RoomHistoryModal from "@/Pages/Admin/User/Modal/RoomHistory.vue";
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

let  changeValue = (event,user_id)=>{ 
    axios.post(route('security.add'),{user_id,security_pay:event.target.value})
        .then((res) => { 
            notify.simpleAlert(res.data.message); 
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else {
                notify.okAlert('error', 'server error');
            }
        })
    
}

 
eventBus.on('ROOM_ADDED', function (data) {
    props.data.push(data)
});

let deductionHistory = (user_id,name)=>{
    axios.get(route('deduction.history',user_id))
        .then((res) => { 

            eventBus.emit('DEDUCTION_HISTORY', {data:res.data.data,name,user_id});
        }).catch((err) => {
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
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
                        <h6 class="mb-4">User List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th> 
                                    <th>Email</th> 
                                    <th>Security Pay</th> 
                                    <th>Remaining Security</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, ind ) in props.data" :key="ind">
                                    <td>{{ ind+1 }}</td>
                                    <th>{{ user.name }}</th>
                                    <td>{{ user.email }}</td> 
                                    <td>
                                    <input class="w-50 form-control form-control-sm" type="number" :value="user.security_pay" @change="changeValue($event,user.user_id)">
                                    </td> 
                                    <td >
                                     {{ parseInt(user.security_pay??0) - parseInt(user.remaining_security??0)}}
                                    </td> 
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="deductionHistory(user.user_id,user.name)">
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
    <AddUserModal />
    <DeductionHistoryModal />
    <UpdateUserModal />
    <RoomHistoryModal />
</template>


