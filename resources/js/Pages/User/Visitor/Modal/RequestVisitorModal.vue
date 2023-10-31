<template>

    <!-- Modal -->
    <div class="modal fade" id="requestVisitorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
       aria-labelledby="staticBackdropLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="staticBackdropLabel">Request visitor</h5>
               </div>
               <div class="modal-body">
                   <div class="bg-light rounded h-100 p-4">
                       <label for="Name" class="form-label">Name</label>
                       <input id="Name" class="form-control form-control-sm" v-model="form.name" type="text"
                           placeholder="Name">
                   </div>
                   <div class="bg-light rounded h-100 p-4">
                       <label for="visit" class="form-label">Visit</label>
                       <input id="visit" class="form-control form-control-sm" v-model="form.visit" type="date"
                           placeholder="visit">
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
    name: '',
    visit:''
})

function addComplain(){
   axios.post(route('user.visitorRequest'),form)
       .then(res => {
           notify.simpleAlert(res.data.message);
           eventBus.emit('VISIT_ADDED', res.data.data);
       }).catch((err) => {
           if (err.response.status == 422) {
               notify.multiAlert('error', 'Validation error', err.response.data.errors)
           } else {
               notify.simpleAlert('server error','error');
           }

       })
}

</script>
