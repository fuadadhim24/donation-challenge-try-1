<template>
  <div class="p-6">
    <h1>✅ Requester Dashboard!</h1>

    <div class="mt-4">
      <Link
        href="/logout"
        method="post"
        as="button"
        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
      >
        Logout
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
