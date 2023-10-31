<script setup>
import '../../css/bootstrap-icon.css';
import '../../css/admin/style.css';
import '../../css/admin/template.css';
import UserNavbar from '@/components/User/UserNavbar.vue';
import FooterBottom from '@/components/Admin/Footer.vue';

</script>
<template>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Content Start -->
        <div class="content open">
            <!-- Navbar Start -->
            <UserNavbar />
            <!-- Navbar End -->
            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <slot />
            </div>
            <!-- Form End -->
            <!-- Footer Start -->
            <FooterBottom />
            <!-- Footer End -->
        </div>
        <!-- Content End -->

    </div>
</template>
