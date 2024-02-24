<template>
    <!-- Modal -->
    <div class="modal fade" id="EDIT_RATING" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit rating</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="rating" class="form-label">Rating</label>
                        <input id="rating" class="form-control form-control-sm" v-model="form.rating" type="number" max="5"
                            min="1" placeholder="Rating">
                        <label for="service" class="form-label">Service</label>
                        <input id="service" class="form-control form-control-sm" v-model="form.service" type="text"
                            placeholder="Service">

                        <label for="increment_amount" class="form-label">increment_amount</label>
                        <input id="increment_amount" class="form-control form-control-sm" v-model="form.increment_amount"
                            min="1" type="number" placeholder="increment_amount">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" @click="editRating">update</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

let form = reactive({
    id: '',
    rating: '',
    service: '',
    increment_amount: '',
})

eventBus.on('EDIT_RATING', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('EDIT_RATING'), {
        keyboard: false
    })
    myModal.show();
    form.id = data.id;
    form.rating = data.rating;
    form.service = data.service;
    form.increment_amount = data.increment_amount;
});


let editRating = () => {
    axios.post(route('rating.update', form.id), form)
        .then(res => {
            eventBus.emit('RATING_UPDATE', res.data.data);
            notify.simpleAlert(res.data.message);
        }).catch((err) => {
            if (err.response.status == 422) {
                notify.multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                notify.okAlert('error', 'server error');
            }

        })
}

</script>
