<template>
    <!-- Modal -->
    <div class="modal fade" id="EDIT_GSERVICE" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Service</h5>
                </div>
                <div class="modal-body">
                    <div class="bg-light rounded h-100 p-4">

                        <label for="name" class="form-label">Name</label>
                        <input id="name" class="form-control form-control-sm" v-model="form.name" type="text"
                            placeholder="Service name">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" @click="editService">Add</button>
                </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

let id = ref(null)
let form = ref({name:null,id:null});

eventBus.on('EDIT_GSERVICE', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('EDIT_GSERVICE'), {
        keyboard: false
    });

    myModal.show();
    form.value = data;
});

function editService() {
    axios.post(route('services.updated'),  form.value )
        .then((res) => {
            notify.simpleAlert('Service updated');
        }).catch((err) => {
            notify.okAlert('error', 'server error');
        })
}
 
</script>
