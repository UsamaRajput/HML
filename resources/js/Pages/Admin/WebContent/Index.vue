<script setup>
import { Link } from '@inertiajs/vue3'
import { VueToggles } from "vue-toggles";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from 'axios';
import { reactive } from 'vue';


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

let content = reactive({
    title:props.data.title,
    content:props.data.content,
    superintendent_name:props.data.superintendent_name,
    superintendent_desc:props.data.superintendent_desc,
    id:props.data.id,
});

function updateContent() {
    axios.post(route('webcontent.update'),  content )
    .then((res) => {
        notify.simpleAlert(res.data.message);
    }).catch((err) => {
        notify.okAlert('error', 'server error');
    })
}

</script>


<template>
    <AdminLayout>
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Web Content</h6>
                    <div>
                        <form method="post">
                            <div class="form-group">
                                <label for="banner">Banner</label>
                                <input type="file" class="form-control" id="banner" name="banner">
                                <input type="hidden" class="form-control" id="id" name="id" :value="content.id">

                            </div>
                            <div class="form-group">
                                <label for="title">title</label>
                                <input type="text" class="form-control" id="title" name="title" v-model="content.title" placeholder="title">
                            </div>
                            <div class="form-group">
                                <label for="content">content</label>
                                <textarea  class="form-control" id="content" name="content"  v-model="content.content" rows="3" placeholder="content"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="superintendent_name">superintendent name</label>
                                <input type="text" class="form-control" id="superintendent_name" v-model="content.superintendent_name" name="superintendent_name" placeholder="superintendent name">
                            </div>
                            <div class="form-group">
                                <label for="superintendent_desc">superintendent Description</label>
                                <textarea  class="form-control" id="superintendent_desc" name="superintendent_desc"  v-model="content.superintendent_desc" rows="3" placeholder="superintendent desc"></textarea>
                            </div>

                            <button  @click.prevent="updateContent" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>


