
<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
</script>


<template>
  <div class="max-w-2xl mx-auto py-16 text-center">
    <h1 class="text-4xl font-bold mb-6">Welcome to Donation Hub!</h1>
    <p class="text-lg mb-8">
      Build impactful projects and support others through donations.
    </p>
    <div class="flex justify-center gap-4">
      <Link 
        v-if="!props.auth" 
        href="/login" 
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Login
      </Link>
      <Link 
        v-if="!props.auth" 
        href="/register" 
        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
      >
        Register
      </Link>
      <Link 
        v-else 
        href="/projects" 
        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
      >
        View Projects
      </Link>
    </div>
  </div>
</template>
