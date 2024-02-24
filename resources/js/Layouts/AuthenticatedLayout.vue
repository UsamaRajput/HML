<script setup>
import { ref } from 'vue';


import '../../css/bootstrap-icon.css';
import '../../css/admin/style.css';
import '../../css/admin/template.css';
import Sidebar from '@/components/Admin/Sidebar.vue';
import Navbar from '@/components/Admin/Navbar.vue';
import FooterBottom from '@/components/Admin/Footer.vue';

import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div class="container-fluid position-relative  d-flex p-0" :style="{ backgroundColor: '#fbf6f0' }">
        <!-- Sidebar Start -->
        <Sidebar />
        <!-- Sidebar End -->
        <!-- Content Start -->
      <div class="main">
        <div class="container"  :style="{ backgroundColor: '#fbf6f0' }">
            <div class="content"  :style="{ backgroundColor: '#fbf6f0' }">
            <Navbar />
            <!-- Navbar Start -->
            <!-- Navbar End -->
            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4"  :style="{ backgroundColor: '#fbf6f0' }">
                <!-- <slot /> -->
            </div>
            <!-- Form End -->
            <!-- Footer Start -->
            <FooterBottom />
            <!-- Footer End -->
        </div>
       </div>
      </div>
        <!-- Content End -->

    </div>
</template>
