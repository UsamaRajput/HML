<template>

     <!-- Modal -->
     <div class="modal fade" id="addComplainModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Complain</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">
                        <label for="Complain" class="form-label">Complain</label>
                        <input id="Complain" class="form-control form-control-sm" v-model="form.message" type="text"
                            placeholder="Complain">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" @click="addComplain">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

let form = reactive({
    message: ''
})

function addComplain(){
    axios.post(route('user.addcomplain',form))
        .then(res => {
            notify.simpleAlert(res.data.message);
            eventBus.emit('COMPLAIN_ADDED', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                notify.multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                notify.simpleAlert('server error','error');
            }

        })
}
</script>
