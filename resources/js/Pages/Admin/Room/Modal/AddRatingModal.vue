<template>
    <!-- Modal -->
    <div class="modal fade" id="addRatingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Rating</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="rating" class="form-label">Rating</label>
                        <input id="rating" class="form-control form-control-sm" v-model="form.rating" type="number" max="5" min="1"
                            placeholder="Room number">
                        <label for="service" class="form-label">Service</label>
                        <input id="service" class="form-control form-control-sm" v-model="form.service" type="text"
                            placeholder="Service">

                        <label for="increment_amount" class="form-label">increment_amount</label>
                        <input id="increment_amount" class="form-control form-control-sm" v-model="form.increment_amount" min="1" type="number"
                            placeholder="increment_amount">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" @click="addRating">Add</button>
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
    rating: '',
    service: '',
    increment_amount: '',
    is_active:1
})

let addRating = () => {
    axios.post(route('rating.store',form))
        .then(res => {
            simpleAlert(res.data.message);
            eventBus.emit('RATING_ADDED', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                simpleAlert('server error','error');
            }

        })
}


</script>
