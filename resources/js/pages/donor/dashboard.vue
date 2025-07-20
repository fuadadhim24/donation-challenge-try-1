<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <h1>Donor Dahsboard!</h1>
    <Link
        href="/logout"
        method="post"
        as="button"
        class="px-4 py-2 mt-4 text-white bg-red-500 rounded"
    >
        Logout
    </Link>
</template>
