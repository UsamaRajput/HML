<template>
    {{ props.data }}
    {{ props.message }}

    <div>
        <form @submit.prevent="createRoom" enctype="multipart/form-data">
            <input type="text" v-model="form.room_number">
            <input type="text" v-model="form.capacity">
            <input type="file"  @input="form.images = $event.target.files[0]">
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
        {{ form.progress.percentage }}%
        </progress>
            <input type="submit" value="submit">
        </form>
        <form @submit.prevent="deleteRoom">
            <input type="text" v-model="deleteForm.id">
            <input type="submit" value="delete">
        </form>

    </div>


</template>

<script setup>
import {onMounted, onUpdated,reactive} from 'vue';
import { useForm } from '@inertiajs/vue3';
import { okAlert,confirmation,multiAlert ,simpleAlert} from "@/notify";

const props = defineProps({
    data: {
        type: Object,
    },
    error:{
        type: String
    },
    message: {
        type: String
    }
});

// let uploadImages = (event)=>{
//     form.images = event.target.files;
// }

let deleteRoom = ()=>{
    deleteForm.delete(route('room.destroy',props.data.id),{
        onSuccess:(res)=>{
            console.log(res);
            if(props.message!=null){
                simpleAlert('success',props.message)
            }
        },
        onError:(err)=>{
            console.log(err);
            multiAlert('error','oops!',err)
        }
    })
}

let deleteForm = useForm({
    id:props.data.id,
})

let createRoom = ()=>{
    // console.log(props.data.id);
    form.post(route('room.update',props.data.id),{
        onSuccess:(res)=>{
            console.log(res);
            if(props.message!=null){
                simpleAlert('success',props.message)
            }
        },
        onError:(err)=>{
            console.log(err);
            multiAlert('error','oops!',err)
        }
    })
}

// variables
let form = useForm({
    id:props.data.id,
    room_number:props.data.room_number,
    capacity:props.data.capacity,
    images:null
},{forceFormData: true})
// onUpdated(()=>{

// })
onMounted(()=>{
    // console.log(props.message);

    if(props.error!=null){
        simpleAlert('error',props.error)
    }
})
</script>
