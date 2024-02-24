<template>
    <!-- Modal -->
    <div class="modal fade" id="EDIT_STAFF"  data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Staff</h5>
                    </div>
                    <div class="modal-body">
                        <div class="bg-light rounded h-100 p-4">

                            <label for="name" class="form-label">Name</label>
                            <input id="name" class="form-control form-control-sm" v-model="form.name"
                                type="text" placeholder="Name">
                            <label for="phone" class="form-label">phone</label>
                            <input id="phone" class="form-control form-control-sm" v-model="form.phone" type="text"
                                placeholder="Phone">

                            <img  class="img-fliud" style="width: 50px; height: 50px;" :src="base_url+'staff_images/'+form.image" alt="">
                            <br/>

                            <label for="image" class="form-label">Image</label>
                            <input id="image" type="file" class="form-control form-control-sm"
                                @input="form.image = $event.target.files" accept="image/*">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal" @click="updateStaff">Update</button>
                    </div>

            </div>
        </div>
    </div>
</template>


<script setup>
import { useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
let base_url= _url;
let form = reactive({
    name: '',
    phone: '',
    image: null
})

eventBus.on('EDIT_STAFF', function (data) {
    let myModal = new bootstrap.Modal(document.getElementById('EDIT_STAFF'), {
        keyboard: false
    })
    myModal.show();
    form.id = data.id;
    form.name = data.name;
    form.phone = data.phone;
    form.image = data.image;
});



let updateStaff = () => {
    axios.post(route('staff.update'), form, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
        .then(res => {
            eventBus.emit('STAFF_ADDED',res.data.data)
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
