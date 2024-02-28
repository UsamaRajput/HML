<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Log in" />
    <section class="vh-150" style="background-color: #9A616D;">
        <div class="container py-2 h-190">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem; ">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <div v-if="status" class="mb-4 text-sm text-danger">
                                        {{ status }}
                                    </div>

                                    <form @submit.prevent="submit">

                                        <div class="d-flex align-items-center mb-2 pb-1">
                                            <!-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                                            <span class="h1 fw-bold mb-0">HMS</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create your account
                                        </h5>

                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" class="form-control form-control-lg"
                                                v-model="form.name" required autofocus autocomplete="name" />
                                            <label class="form-label" for="name">Name</label>
                                            <InputError class="mt-2" :message="form.errors.name" />

                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" class="form-control form-control-lg"
                                                v-model="form.email" required autofocus autocomplete="username" />
                                            <label class="form-label" for="email">Email address</label>
                                            <InputError class="mt-2" :message="form.errors.email" />

                                        </div>

                                        <div class="form-outline mb-4">
                                            <input id="password" type="password" v-model="form.password" required
                                                autocomplete="current-password" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <InputError class="mt-2" :message="form.errors.password" />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input class="form-control form-control-lg" id="password_confirmation"
                                                type="password" v-model="form.password_confirmation" required
                                                autocomplete="new-password" />
                                            <label class="form-label" for="form2Example27">Confirm Password</label>
                                            <InputError class="mt-2" :message="form.errors.password" />
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg d-block btn-block"
                                                :disabled="form.processing" type="submit">Register</button>
                                        </div>

                                        <!-- <Link v-if="canResetPassword" :href="route('password.request')"
                                            class="small text-muted">
                                        Forgot password?
                                        </Link> -->
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account?
                                            <Link :href="route('login')" style="color: #393f81;">Login</Link>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
