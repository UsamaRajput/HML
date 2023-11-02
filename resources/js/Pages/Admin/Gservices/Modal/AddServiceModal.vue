<template>
    <!-- Modal -->
    <div class="modal fade" id="AddServiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Service</h5>
                    </div>
                    <div class="modal-body">
                        <div class="bg-light rounded h-100 p-4">

                            <label for="name" class="form-label">Name</label>
                            <input id="name" class="form-control form-control-sm" v-model="form.name"
                                type="text" placeholder="Service number">

                            <label for="spentable_time" class="form-label">spentable time</label>
                            <input id="spentable_time" class="form-control form-control-sm" v-model="form.spentable_time" type="text"
                                placeholder="Service spentable time">

                            <label for="usage" class="form-label">usage</label>
                            <input id="usage" class="form-control form-control-sm" v-model="form.usage" type="text"
                                placeholder="Service usage">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal" @click="createService">Add</button>
                    </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { multiAlert, simpleAlert } from "@/notify";
let form = reactive({
    name: '',
    spentable_time: '',
    usage: '',
    is_active: 1
})

let createService = () => {
    axios.post(route('services.store'), form, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
        .then(res => {
            simpleAlert(res.data.message);
            eventBus.emit('SERVICE_ADDED', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                simpleAlert('server error','error');
            }

        })
}


</script>
