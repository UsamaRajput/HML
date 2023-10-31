<template>
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative ml-3 mt-3">
                    <h1>HMS</h1>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <Link :href="route('admin.dashboard')" class="nav-item nav-link">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                </Link>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="fa fa-laptop me-2"></i>Room</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <Link :href="route('room.index')" class="dropdown-item">
                        List
                        </Link>
                        <Link :href="route('requested.index')" class="dropdown-item">
                        Requested Room
                        </Link>
                        <Link :href="route('rating.index')" class="dropdown-item">
                        Rating List
                        </Link>
                    </div>
                </div>
                <Link :href="route('complain.index')" class="nav-item nav-link">
                <i class="fa fa-tachometer-alt me-2"></i>Complains
                </Link>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="fa fa-laptop me-2"></i>Ratings</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <Link :href="route('room.index')" class="dropdown-item">
                        List
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';
</script>
