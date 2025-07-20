<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <h1>Donor Dahsboard!</h1>
    <Link
        :href="route('logout')"
        method="post"
        as="button"
        class="mt-4 px-4 py-2 bg-red-500 text-white rounded"
    >
        Logout
    </Link>
</template>
