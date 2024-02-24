<template>
    <!-- Modal -->
    <div class="modal fade" id="ROOM_EDIT" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="bg-light rounded h-100 p-4">

                            <label for="name" class="form-label">Name</label>
                            <input id="name" class="form-control form-control-sm" v-model="form.name"
                                type="text" placeholder=" number">

                            <label for="email" class="form-label">email</label>
                            <input id="email" class="form-control form-control-sm" v-model="form.email" type="text"
                                placeholder=" email">

                            <label for="Password" class="form-label">Password</label>
                            <input id="Password" class="form-control form-control-sm" v-model="form.password" type="password"
                                placeholder=" Password">

                            <label for="cnic" class="form-label">cnic</label>
                            <input id="cnic" class="form-control form-control-sm" v-model="form.cnic" type="text"
                                placeholder=" cnic">

                            <label for="phone" class="form-label">phone</label>
                            <input id="phone" class="form-control form-control-sm" v-model="form.phone" type="text"
                                placeholder=" phone">

                            <label for="emergency_phone" class="form-label">emergency_phone</label>
                            <input id="emergency_phone" class="form-control form-control-sm" v-model="form.emergency_phone" type="text"
                                placeholder=" emergency_phone">

                            <label for="address" class="form-label">address</label>
                            <input id="address" class="form-control form-control-sm" v-model="form.address" type="text"
                                placeholder=" address">

                            <label for="city" class="form-label">city</label>
                            <input id="city" class="form-control form-control-sm" v-model="form.city" type="text"
                                placeholder=" city">

                            <label for="security_pay" class="form-label">security_pay</label>
                            <input id="security_pay" class="form-control form-control-sm" v-model="form.security_pay" type="text"
                                placeholder=" security_pay">

                            <label for="dob" class="form-label">dob</label>
                            <input id="dob" class="form-control form-control-sm" v-model="form.dob" type="date"
                                placeholder="dob">

                            <label for="blood_group" class="form-label">blood_group</label>
                            <input id="blood_group" class="form-control form-control-sm" v-model="form.blood_group" type="text"
                                placeholder="blood_group">

                            <label for="image" class="form-label">Image</label>
                            <input id="image" type="file" class="form-control form-control-sm"
                                @input="form.image = $event.target.files[0]" accept="image/*">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal" @click="updateUser">Update</button>
                    </div>

            </div>
        </div>
    </div>
</template>


<script setup> 
import { ref } from 'vue';
import { multiAlert, simpleAlert } from "@/notify";
let form = ref({})

eventBus.on('ROOM_EDIT', function (data) {
    form.value = data;
    let myModal = new bootstrap.Modal(document.getElementById('ROOM_EDIT'), {
        keyboard: false
    });
    myModal.show()
});

let updateUser = () => {
    axios.post(route('update.user'), form.value, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
    .then(res => {
        simpleAlert(res.data.message);
        eventBus.emit('USER_UPDATED', res.data.data);
    }).catch((err) => {
        if (err.response.status == 422) {
            multiAlert('error', 'Validation error', err.response.data.errors)
        } else {
            simpleAlert('server error','error');
        }

    })
}


</script>
