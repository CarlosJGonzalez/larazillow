<template>
  <form @submit.prevent='update'>
    <div class="grid grid-cols-6 gap-4">
      <div class="col-span-2">
        <label class="label">Beds</label>
        <input type="text" v-model.number="form.beds" class="input" />
        <div v-if="form.errors.beds" class="input-error">
            {{ form.errors.beds }}
        </div>
      </div>

      <div class="col-span-2">
        <label class="label">Baths</label>
        <input v-model.number="form.baths" type="text" class="input" />
        <div v-if="form.errors.baths" class="input-error">
            {{ form.errors.baths }}
        </div>        
      </div>

      <div class="col-span-2">
        <label class="label">Area</label>
        <input v-model.number="form.area" type="text" class="input" />
        <div v-if="form.errors.area" class="input-error">
            {{ form.errors.area }}
        </div>        
      </div>

      <div class="col-span-4">
        <label class="label">City</label>
        <input v-model="form.city" type="text" class="input" />
        <div v-if="form.errors.city" class="input-error">
            {{ form.errors.city }}
        </div>
      </div>

      <div class="col-span-3">
        <label class="label">Post Code</label>
        <input v-model="form.code" type="text" class="input" />
        <div v-if="form.errors.code" class="input-error">
            {{ form.errors.code }}
        </div>        
      </div>

      <div class="col-span-6">
        <label class="label">Street</label>
        <input v-model="form.street" type="text" class="input" />
        <div v-if="form.errors.street" class="input-error">
            {{ form.errors.street }}
        </div>        
      </div>

      <div class="col-span-2">
        <label class="label">Street Nr</label>
        <input v-model="form.street_nr" type="text" class="input" />
        <div v-if="form.errors.street_nr" class="input-error">
            {{ form.errors.street_nr }}
        </div>        
      </div>

      <div class="col-span-3">
        <label class="label">Price</label>
        <input v-model.number="form.price" type="text" class="input" />
        <div v-if="form.errors.price" class="input-error">
            {{ form.errors.price }}
        </div>        
      </div>

      <div class="col-span-6">
        <button type="submit" class="btn-primary">Update</button>
      </div>
    </div>
  </form>
</template>
<script setup>
    import { router, useForm } from '@inertiajs/vue3'

    const data = defineProps({
      listing: Object,
    });

    const form = useForm({
        beds: data.listing.beds,
        baths: data.listing.baths,
        area: data.listing.area,
        city: data.listing.city,
        code: data.listing.code,
        street: data.listing.street,
        street_nr: data.listing.street_nr,
        price: data.listing.price,
    })
    const update = () => {
        form.put( route('realtor.listing.update', data.listing.id), {
            onSuccess: () => router.replace('/listing'),
            onError: (errors) => {
                form.errors = errors
            }
        } )
    }
</script>
