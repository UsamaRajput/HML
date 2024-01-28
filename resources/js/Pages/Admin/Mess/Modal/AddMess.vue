<template>
    <!-- Modal -->
    <div class="modal fade" id="MESS_ADDED" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Mess</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="name" class="form-label">Name</label>
                        <input id="name" class="form-control" v-model="form.name" type="text" placeholder="Name">

                        <label for="time" class="form-label">Time</label>
                        <input id="time" class="form-control" v-model="form.time" type="time" placeholder="Name">

                        <label for="day" class="form-label">Day</label>
                        <select id="day" class="form-control" v-model="form.day">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thrusday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturady</option>
                            <option value="7">Sunday</option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" @click="createMess">Add</button>
                </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { multiAlert, simpleAlert } from "@/notify";
let form = ref({})

let createMess = () => {
    axios.post(route('mess.store'), form.value)
        .then(res => {
            simpleAlert(res.data.message);
            eventBus.emit('MESS_ADDED', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                simpleAlert('server error', 'error');
            }

        })
}


</script>
