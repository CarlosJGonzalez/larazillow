<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Your name</label>
                <input id="name" type="text" class="input" v-model="form.name" />
                <span class="input-error" v-if="form.errors.name">
                    {{form.errors.name}}
                </span>
            </div>            
            <div class="mt-4">
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
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input v-model="form.password_confirmation"  id="password_confirmation" autocomplte="true" type="password" class="input"/>              
                <span class="input-error" v-if="form.errors.password_confirmation">
                    {{form.errors.password_confirmation}}
                </span>                  
            </div>            
            <div class="mt-4 text-center">
                <button class="btn-primary w-full" type="submit">Register</button>
                <div class="text-sm text-gray-500">
                    <Link :href="route('login')"> Already have an account? Click here</Link>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
    import { router, useForm, Link } from '@inertiajs/vue3'
    const form = useForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
    })

    const register = () => {
        form.post(route('user-account.store'), {
            onSuccess: () => router.replace('/'),
            onError: (errors) => {
                form.errors
            }
        })
    }
</script>