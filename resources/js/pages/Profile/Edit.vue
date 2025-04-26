<template>
    <Head title="Edit Profile" />
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Profile</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="shadow-xs overflow-hidden bg-white sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <form @submit.prevent="update">
                            <div class="group relative z-0 mb-6 w-full">
                                <input
                                    type="text"
                                    name="name"
                                    id="floating_name"
                                    class="focus:outline-hidden peer block w-full appearance-none border-0 border-b-2 border-slate-400 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                    placeholder=" "
                                    required=""
                                    v-model="form.name"
                                />
                                <label
                                    for="floating_name"
                                    class="absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:left-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500"
                                    >Full Name</label
                                >
                            </div>
                            <div class="group relative z-0 mb-6 w-full">
                                <input
                                    type="email"
                                    name="email"
                                    id="floating_email"
                                    class="focus:outline-hidden peer block w-full appearance-none border-0 border-b-2 border-slate-400 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                    placeholder=" "
                                    required=""
                                    v-model="form.email"
                                />
                                <label
                                    for="floating_email"
                                    class="absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:left-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500"
                                    >Email</label
                                >
                            </div>
                            <div class="grid xl:grid-cols-2 xl:gap-6">
                                <div class="group relative z-0 mb-6 w-full">
                                    <input
                                        type="password"
                                        name="floating_password"
                                        id="floating_password"
                                        class="focus:outline-hidden peer block w-full appearance-none border-0 border-b-2 border-slate-400 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                        placeholder=" "
                                        v-model="form.password"
                                    />
                                    <label
                                        for="floating_password"
                                        class="absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:left-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500"
                                        >Password</label
                                    >
                                </div>
                                <div class="group relative z-0 mb-6 w-full">
                                    <input
                                        type="password"
                                        name="floating_confirm_password"
                                        id="floating_confirm_password"
                                        class="focus:outline-hidden peer block w-full appearance-none border-0 border-b-2 border-slate-400 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                        placeholder=" "
                                        v-model="form.confirm_password"
                                    />
                                    <label
                                        for="floating_confirm_password"
                                        class="absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:left-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 dark:text-gray-400 dark:peer-focus:text-blue-500"
                                        >Confirm Password</label
                                    >
                                </div>
                            </div>
                            <div class="grid xl:grid-cols-2 xl:gap-6">
                                <div class="group relative z-0 mb-6 flex w-full items-center space-x-6">
                                    <div class="shrink-0">
                                        <img
                                            class="h-16 w-16 rounded-full object-cover"
                                            :src="props.user.photo ?? '/img/public/avatar.jpg'"
                                            alt="😎"
                                        />
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input
                                            @input="form.photo = $event.target.files[0]"
                                            type="file"
                                            accept="image/png, image/jpeg"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100"
                                        />
                                    </label>
                                    <div v-if="form.errors?.photo" class="text-xs text-red-400">{{ form.errors.photo }}</div>
                                </div>

                                <div class="mb-6 flex w-full items-start justify-end">
                                    <button
                                        type="submit"
                                        class="w-full rounded-md bg-slate-700 px-8 py-2.5 text-center text-sm font-medium text-white hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800 sm:w-auto"
                                    >
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
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
