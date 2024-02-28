<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    data: {
        type: Object,
    },

});

</script>


<template>
    <AdminLayout>
        <div class="row g-4" :style="{ backgroundColor: '#fbf6f0' }">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-info rounded h-100 p-4">
                    <div class=" text-center">
                        <h2 class="mb-4">Total User </h2>
                        <h4 class="text-light">{{ props.data.user_count }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-success rounded h-100 p-4">
                    <div class=" text-center">
                        <h2 class="mb-4">Total Room</h2>
                        <h4 class="text-light">{{ props.data.room_count }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-warning rounded h-100 p-4">
                    <div class=" text-center">
                        <h2 class="mb-4">Open Complains</h2>
                        <h4 class="text-light">{{ props.data.complain_count }}</h4>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-danger rounded h-100 p-4">
                    <div class=" text-center">
                        <h2 class="mb-4">Today Visitor</h2>
                        <h4 class="text-light">{{ props.data.visitor_count }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
