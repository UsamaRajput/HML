<template>
    <div>
        <div class="form-group">
          <label for="roomNumber">Room Name</label>
          <select class="form-control" id="roomNumber" v-for="(room, ind ) in props.data" :key="ind" v-model="form.room_id">
            <option value="1">{{ room.room_number }}</option>
            <!-- Add more options as needed -->
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
    </div>
  </template>
  
  <script setup>
  import { reactive } from 'vue';

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


  