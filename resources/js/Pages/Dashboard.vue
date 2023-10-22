<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
        <div class="Box">
    <button class="button2"> 
    <div class="ba">   <i class="fa fa-bar-chart" aria-hidden="true"></i> </div> DASHBOARD
    </button>
    <button class="button"> 
        <div class="ba">       
<i class="fa fa-users" aria-hidden="true"></i>    </div> TOTAL CANDIDATE
    </button>
    <br> <br><br>
    <Button class="button1">
    <div class="ba">    <i class="fa fa-desktop" aria-hidden="true"></i>   </div> TOTAL ROOMS <br>
    
    </Button>
</div>
    </AuthenticatedLayout>
</template>
