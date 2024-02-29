<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <section class="vh-150" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
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

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <!-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                                            <span class="h1 fw-bold mb-0">HMS</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account
                                        </h5>

                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" class="form-control form-control-lg"
                                                v-model="form.email" required autofocus autocomplete="username" />
                                            <label class="form-label" for="email">Email Address</label>
                                            <InputError class="mt-2" :message="form.errors.email" />

                                        </div>

                                        <div class="form-outline mb-4">
                                            <input id="password" type="password" v-model="form.password" required
                                                autocomplete="current-password" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <InputError class="mt-2" :message="form.errors.password" />
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg d-block btn-block"
                                                :disabled="form.processing" type="submit">Login</button>
                                        </div>


                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account?
                                            <Link :href="route('register')" style="color: #393f81;">Register here</Link>
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
