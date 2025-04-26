<template>

    <Head title="Edit Profile" />
    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Edit Profile</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="bg-white shadow-xs sm:rounded-lg overflow-hidden">
                    <div class="bg-white p-6 border-gray-200 border-b">
                        <form @submit.prevent="update">
                            <div class="group relative z-0 mb-6 w-full">
                                <input type="text" name="name" id="floating_name"
                                    class="block bg-transparent px-0 py-2.5 border-0 border-slate-400 dark:border-gray-600 border-b-2 focus:border-blue-600 dark:focus:border-blue-500 w-full text-gray-900 text-sm dark:text-white peer appearance-none focus:outline-hidden focus:ring-0"
                                    placeholder=" " required="" v-model="form.name" />
                                <label for="floating_name"
                                    class="top-3 peer-focus:left-0 -z-10 absolute text-gray-500 text-sm dark:text-gray-400 dark:peer-focus:text-blue-500 peer-focus:text-blue-600 transform origin-[0] -translate-y-6 peer-focus:-translate-y-6 peer-placeholder-shown:translate-y-0 duration-300 scale-75 peer-placeholder-shown:scale-100 peer-focus:scale-75">Full
                                    Name</label>
                            </div>
                            <div class="group relative z-0 mb-6 w-full">
                                <input type="email" name="email" id="floating_email"
                                    class="block bg-transparent px-0 py-2.5 border-0 border-slate-400 dark:border-gray-600 border-b-2 focus:border-blue-600 dark:focus:border-blue-500 w-full text-gray-900 text-sm dark:text-white peer appearance-none focus:outline-hidden focus:ring-0"
                                    placeholder=" " required="" v-model="form.email" />
                                <label for="floating_email"
                                    class="top-3 peer-focus:left-0 -z-10 absolute text-gray-500 text-sm dark:text-gray-400 dark:peer-focus:text-blue-500 peer-focus:text-blue-600 transform origin-[0] -translate-y-6 peer-focus:-translate-y-6 peer-placeholder-shown:translate-y-0 duration-300 scale-75 peer-placeholder-shown:scale-100 peer-focus:scale-75">Email</label>
                            </div>
                            <div class="xl:gap-6 grid xl:grid-cols-2">
                                <div class="group relative z-0 mb-6 w-full">
                                    <input type="password" name="floating_password" id="floating_password"
                                        class="block bg-transparent px-0 py-2.5 border-0 border-slate-400 dark:border-gray-600 border-b-2 focus:border-blue-600 dark:focus:border-blue-500 w-full text-gray-900 text-sm dark:text-white peer appearance-none focus:outline-hidden focus:ring-0"
                                        placeholder=" " v-model="form.password" />
                                    <label for="floating_password"
                                        class="top-3 peer-focus:left-0 -z-10 absolute text-gray-500 text-sm dark:text-gray-400 dark:peer-focus:text-blue-500 peer-focus:text-blue-600 transform origin-[0] -translate-y-6 peer-focus:-translate-y-6 peer-placeholder-shown:translate-y-0 duration-300 scale-75 peer-placeholder-shown:scale-100 peer-focus:scale-75">Password</label>
                                </div>
                                <div class="group relative z-0 mb-6 w-full">
                                    <input type="password" name="floating_confirm_password"
                                        id="floating_confirm_password"
                                        class="block bg-transparent px-0 py-2.5 border-0 border-slate-400 dark:border-gray-600 border-b-2 focus:border-blue-600 dark:focus:border-blue-500 w-full text-gray-900 text-sm dark:text-white peer appearance-none focus:outline-hidden focus:ring-0"
                                        placeholder=" " v-model="form.confirm_password" />
                                    <label for="floating_confirm_password"
                                        class="top-3 peer-focus:left-0 -z-10 absolute text-gray-500 text-sm dark:text-gray-400 dark:peer-focus:text-blue-500 peer-focus:text-blue-600 transform origin-[0] -translate-y-6 peer-focus:-translate-y-6 peer-placeholder-shown:translate-y-0 duration-300 scale-75 peer-placeholder-shown:scale-100 peer-focus:scale-75">Confirm
                                        Password</label>
                                </div>
                            </div>
                            <div class="xl:gap-6 grid xl:grid-cols-2">
                                <div class="group relative z-0 flex items-center space-x-6 mb-6 w-full">
                                    <div class="shrink-0">
                                        <img class="rounded-full w-16 h-16 object-cover"
                                            :src="props.user.photo ?? '/img/public/avatar.jpg'" alt="😎" />
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input @input="form.photo = $event.target.files[0]" type="file"
                                            accept="image/png, image/jpeg"
                                            class="block hover:file:bg-violet-100 file:bg-violet-50 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-full w-full file:font-semibold text-slate-500 text-sm file:text-sm file:text-violet-700" />
                                    </label>
                                    <div v-if="form.errors?.photo" class="text-red-400 text-xs">{{ form.errors.photo }}
                                    </div>
                                </div>

                                <div class="flex justify-end items-start mb-6 w-full">
                                    <button type="submit"
                                        class="bg-slate-700 hover:bg-slate-800 dark:bg-slate-600 dark:hover:bg-slate-700 px-8 py-2.5 rounded-md w-full sm:w-auto font-medium text-center text-sm text-white focus:ring-4 focus:ring-slate-300 dark:focus:ring-slate-800">
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';

import TextInput from '@/Shared/TextInput';
import FileInput from '@/Shared/FileInput';
import LoadingButton from '@/Shared/LoadingButton';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'put',
    name: props.user.name,
    email: props.user.email,
    password: '',
    photo: null,
});

const update = () => {
    form.post(`/profile/update`, {
        onSuccess: () => form.reset('password', 'photo'),
    });
};
</script>
