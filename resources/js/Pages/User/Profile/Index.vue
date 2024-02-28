<script setup>

import { useForm } from '@inertiajs/vue3';

import UserLayout from '@/Layouts/UserLayout.vue';
import { ref } from 'vue';
let base_url = _url;
const props = defineProps({
    data: {
        type: Object,
    },
    error: {
        type: String
    },
    message: {
        type: String
    }
});
let userImg = ref('null');
userImg.value = props.data.user_info?.image;

let form = useForm({
    dob: props.data.user_info?.dob ?? null,
    cnic: props.data.user_info?.cnic ?? null,
    blood_group: props.data.user_info?.blood_group ?? null,
    phone: props.data.user_info?.phone ?? null,
    emergency_phone: props.data.user_info?.emergency_phone ?? null,
    address: props.data.user_info?.address ?? null,
    city: props.data.user_info?.city ?? null
})


function updateUser() {

    form.post(route('profile.updateProfile'), {
        onSuccess: (res) => {
            if (props.message != null) {
                notify.simpleAlert(props.message, 'success',)
            }
        },
        onError: (err) => {
            console.log(err);
            notify.multiAlert('error', 'oops!', err)
        }
    })
}

function imageChange(event) {
    let image = event.target.files[0];
    axios.post(route('profile.changeImage'), { image: image }, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    })
        .then(res => {
            console.log('resssss', res);
            userImg.value = res.data.data.image;
            notify.simpleAlert(res.data.message);
        }).catch((err) => {

            notify.simpleAlert('Something Wrong', 'error');
        });
}

</script>


<template>
    <UserLayout>
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6 ">
                <img class="img-circle" :src="base_url + 'user_images/' + userImg" />
                <div class="m-2 mt-5">
                    <label for="image" class="form-label">Replace file</label>
                    <input class="form-control form-control-lg" id="image" @input="imageChange($event)" accept="image/*"
                        type="file">
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">User Info</h6>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control disabled" :disabled="true" id="name" :value="props.data.name"
                            placeholder="name@example.com" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control disabled" :disabled="true" id="email"
                            :value="props.data.email" placeholder="name@example.com" readonly>
                    </div>
                    <div class=" mb-3">
                        <label for="udate">DOB</label>
                        <input type="date" class="form-control" id="udate" v-model="form.dob">
                    </div>
                    <div class="mb-3">
                        <label for="cnic">CNIC</label>
                        <input id="cnic" type="text" class="form-control" v-model="form.cnic" />
                    </div>
                    <div class=" mb-3">
                        <label for="blood_group">Blood Group</label>
                        <select class="form-select form-control" id="blood_group" v-model="form.blood_group">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class=" mb-3">
                        <label for="phone">phone</label>
                        <input id="phone" type="text" class="form-control" v-model="form.phone" />
                    </div>
                    <div class=" mb-3">
                        <label for="emergency_phone">Emergency Phone</label>
                        <input id="emergency_phone" type="text" class="form-control" v-model="form.emergency_phone" />
                    </div>
                    <div class=" mb-3">
                        <label for="address">Address</label>
                        <input id="address" type="text" class="form-control" v-model="form.address" />
                    </div>
                    <div class=" mb-3">
                        <label for="city">city</label>
                        <input id="city" type="text" class="form-control" v-model="form.city" />
                    </div>
                    <div class=" mb-3">
                        <label for="security_pay">Remaining security</label>
                        <!-- <input id="security_pay" type="text" class="form-control" :value="props.data.security" /> -->
                    </div>
                    <div class=" mb-3">
                        <button class="btn btn-primary" @click="updateUser">Update</button>
                    </div>
<br><br>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
