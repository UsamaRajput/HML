<script setup>
import { Link,useForm,router  } from '@inertiajs/vue3'
import { onMounted,ref } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { VueToggles } from "vue-toggles";
import AddComplainModal from "@/Pages/User/Complain/Modal/AddComplainModal.vue";


let base_url = _url;

const props = defineProps({
    data: {
        type: Object,
    },
    filter: {
        type: String
    },
    error: {
        type: String
    },
    message: {
        type: String
    }
});

let filter = ref(props.filter);


function complainProgress(fieldName, id) {
    axios.post(route('complain.user.complainProgress', id), { fieldName })
        .then((res) => {
            notify.simpleAlert(res.data.message);
        }).catch((err) => { 
            if (err.response.status == 404) {
                notify.okAlert('error', "No Room Found");
            } else   if (err.response.status == 400) { 
                notify.okAlert('error','Request for room first');
            } else {
                notify.okAlert('error', 'server error');
            }
        })
}

function filterComplain(){
    router.get(route('user.complain',filter.value))
}

eventBus.on('COMPLAIN_ADDED', function (data) {
    props.data.push(data)
});

function delComplain(id,ind){
    axios.delete(route('user.delComp', id))
    .then((res)=>{
        document.getElementById(`col-room-${ind}`).style.display = 'none';
        notify.simpleAlert(res.data.message);
    }).catch((err)=>{
        notify.okAlert('error', 'server error');
    })
}
</script>


<template>
    <AddComplainModal />
    <UserLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Complain List</h6>
                        <div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addComplainModal">
                                <i class="fa fa-plus"></i>
                            </button>
                            <span>Filter </span>
                            <select @change="filterComplain" v-model="filter" class="form-control-sm">
                                <option value="all">All</option>
                                <option value="watched">watched</option>
                                <option value="inprogress">inprogress</option>
                                <option value="closed">closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Message</th>
                                    <th>watched</th>
                                    <th>inprogress</th>
                                    <th>closed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, ind ) in props.data" :key="ind"  :id="`col-room-${ind}`">
                                    <th>{{ ind + 1 }}</th>

                                    <td>
                                        {{ item.message }}
                                    </td>
                                    <td>
                                        <VueToggles :disabled="true" @click="complainProgress('watched', item.id)"
                                            :value="item.watched" />
                                    </td>
                                    <td>
                                        <VueToggles :disabled="true"
                                            @click="complainProgress('inprogress', item.id)" :value="item.inprogress" />
                                    </td>
                                    <td>
                                        <VueToggles :disabled="item.closed" @click="complainProgress('closed', item.id)"
                                            :value="item.closed" />
                                    </td>
                                    <td>
                                        <!-- <Link class="btn btn-sm btn-danger ml-1" :href="route('complain.destroy', item.id)"
                                            method="DELETE" as="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </Link> -->
                                        <a class="btn btn-sm btn-danger ml-1" @click.prevent="delComplain(item.id,ind)" 
                                             as="button" type="button">
                                             <i class="fa fa-trash" aria-hidden="true"></i>    
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
