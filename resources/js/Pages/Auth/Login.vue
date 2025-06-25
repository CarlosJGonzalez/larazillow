<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">E-mail (username)</label>
                <input id="email" type="text" class="input" v-model="form.email" />
                <span class="input-error" v-if="form.errors.email">
                    {{form.errors.email}}
                </span>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input v-model="form.password"  id="password" autocomplte="true" type="password" class="input"/>
                <span class="input-error" v-if="form.errors.password">
                    {{form.errors.password}}
                </span>                
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Login</button>
            </div>
        </div>
    </form>
</template>

<script setup>
    import { router, useForm } from '@inertiajs/vue3'
    const form = useForm({
        email: null,
        password: null
    })

    const login = () => {
        form.post(route('login.store'), {
            onSuccess: () => router.replace('/'),
            onError: (errors) => {
                form.errors
            }
        })
    }
</script>