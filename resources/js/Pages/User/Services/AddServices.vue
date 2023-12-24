<template>
    <!-- <div>
        <div class="form-group">
          <label for="roomNumber">Room Name</label>
          <select class="form-control" id="roomNumber" v-for="(room, ind ) in props.data" :key="ind" v-model="form.room_id">
            <option value="1">{{ room.room_number }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="requestedTime">Requested Time</label>
          <input type="time" class="form-control" id="requestedTime" v-model="form.requested_time">
        </div>
        <div class="form-group">
          <label for="leavingTime">Leaving Time</label>
          <input type="time" class="form-control" id="leavingTime" v-model="form.leaving_time">
        </div>
        <button class="btn btn-primary" data-bs-dismiss="modal" @click="addRequest">Add</button>
    </div> -->

    <UserLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-4">Services List</h6>
                        <!-- Button trigger modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#adRoomModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Images</th>
                                    <th>Capacity</th>
                                    <th>Current</th>
                                    <th>Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(room, ind ) in props.data" :key="ind">
                                    <th>{{ room.room_number }}</th>
                                    <td>

                                        <img v-for="(img, im) in room.images_room" style="width: 50px; height: 50px; border-radius: 50%;" class="img-fliud" :key="im" :src="base_url+'room_images/'+img.image" alt="">
                                    </td>
                                    <td>{{ room.capacity }}</td>
                                    <td>{{ room.current }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info " @click="requestRoom(room.id)">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
  </template>

  <script setup>
  import { reactive } from 'vue';
  import UserLayout from '@/Layouts/UserLayout.vue';

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

  let form = reactive({
    room_id: '',
    requested_time: '',
    leaving_time: '',
})

function addRequest(){
    axios.post(route('user.added'),form)

        .then(res => {
            notify.simpleAlert(res.data.message);
            eventBus.emit('Service Request Added', res.data.data);
        }).catch((err) => {
            if (err.response.status == 422) {
                notify.multiAlert('error', 'Validation error', err.response.data.errors)
            } else {
                notify.simpleAlert('server error','error');
            }

        })
}
  </script>


