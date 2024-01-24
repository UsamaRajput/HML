<template>
    <!-- Modal -->
    <div class="modal fade" id="DEDUCTION_HISTORY" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> {{name}} - Deduction History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" v-model="form.reson" class="form-control form-control-sm"  placeholder="Reason">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <input type="number" v-model="form.deduction" class="form-control form-control-sm" placeholder="Amount">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm" @click="addDeduction">Add</button>
                        </div>
                    </div>
                    <div class="bg-light rounded h-100 p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="5">Reason</th>
                                    <th scope="col" colspan="5">deduction</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(rr, ind) in deductions" :key="ind">
                                    <td colspan="5"> {{ rr.reson }}</td>
                                    <td colspan="5"> {{ rr.deduction }}</td>
                                    <td> {{ rr.created_at }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { okAlert, simpleAlert } from '@/notify';
import { ref } from 'vue';
let deductions = ref([]);
let user_id = ref(null);
let form = ref({user_id});

let name = ref('name');


let addDeduction = ()=>{
    axios.post(route('deduction.add'),form.value)
    .then((res) => {  
        deductions.value = res.data.data ;
        notify.simpleAlert(res.data.message);
    }).catch((err) => {
        notify.okAlert('error', 'server error');
    })
}

eventBus.on('DEDUCTION_HISTORY', function (data) {
    console.log('data.rooms', data);
    deductions.value = data.data;
    name.value = data.name;
    user_id.value = data.user_id;
    let myModal = new bootstrap.Modal(document.getElementById('DEDUCTION_HISTORY'), {
        keyboard: false
    })
    myModal.show();
});

</script>
