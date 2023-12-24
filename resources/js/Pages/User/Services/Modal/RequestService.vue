<template>
    <!-- Modal -->
    <div class="modal fade" id="REQUEST_SERVICE"  data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="date" class="form-label">date</label>
                        <input id="date" class="form-control form-control-sm" required v-model="form.date" type="date"
                            placeholder="date">

                            <label for="entry" class="form-label">Entry</label>
                        <input id="entry" class="form-control form-control-sm" required v-model="form.entry" type="time"
                            placeholder="Entry">

                        <label for="exit" class="form-label">Exit</label>
                        <input id="exit" class="form-control form-control-sm" required v-model="form.exit" type="time"
                            placeholder="exit">


                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button  class="btn btn-primary" @click="requestService" data-bs-dismiss="modal">Request</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { ref } from 'vue';


let form = reactive({
    entry: '',
    exit: '',
    date: '',
    general_service_id:null
})
let service = ref({});
eventBus.on('REQUEST_SERVICE', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('REQUEST_SERVICE'), {
        keyboard: false
    })
    myModal.show();
    service.data = data;
    form.general_service_id = data.id;
});



let requestService = () => {
    console.log(form);
    axios.post(route('service.request'), form)
    .then(res => {
        notify.simpleAlert(res.data.message);
    }).catch((err) => {
        if (err.response.status == 422) {
            notify.multiAlert('error', 'Validation error', err.response.data.errors)
        } else {
            notify.okAlert('error','server error');
        }

    })
}


</script>
