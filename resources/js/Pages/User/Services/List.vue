<template>
    <UserLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Services List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#adRoomModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Request</th>
                                    <th>History</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind">
                                    <th>{{ ind }}</th>
                                    <td>
                                        {{item.name}}
                                    </td>
                                    <td>
                                        <button v-if="item.users_count == 0" class="btn btn-sm btn-info " @click="requestService(item)">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                        <!-- {{ item.users_count }} -->
                                        <button v-if="item.users_count > 0" class="btn btn-sm btn-info"  @click="cancelService(item)">
                                            cancel
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="historyService(item.id)">
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
        <RequestService/>
        <HistoryService/>
    </UserLayout>
  </template>

  <script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { okAlert, simpleAlert } from '@/notify';
  import RequestService from '@/Pages/User/Services/Modal/RequestService.vue';
import HistoryService from "@/Pages/User/Services/Modal/HistoryService.vue";

  import UserLayout from '@/Layouts/UserLayout.vue';

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

let form = useForm({
    id : null,
});

function cancelService(item){
    form.id = item.id;

    form.post(route('service.cancel'));
}
function requestService(item){
    eventBus.emit('REQUEST_SERVICE',item);
}

function historyService(id){
    axios.get(route('service.history',id))
        .then(function (res) {
            eventBus.emit('HISTORY_SERVICE',res.data.data);
        }).catch(function (err) {
            okAlert('error','Something wrong');
            console.log(err);
        })
}
  </script>


