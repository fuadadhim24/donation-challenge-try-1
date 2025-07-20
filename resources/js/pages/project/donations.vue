<script setup>
import { Head } from "@inertiajs/vue3";
import { Link, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

function loadScript(src) {
    return new Promise((resolve, reject) => {
        if (document.querySelector(`script[src="${src}"]`)) {
            resolve();
            return;
        }

        const script = document.createElement("script");
        script.src = src;
        script.async = true;
        script.onload = resolve;
        script.onerror = () => reject(new Error(`Gagal memuat script: ${src}`));
        document.head.appendChild(script);
    });
}

async function initView() {
    await loadScript(
        "https://www.googletagmanager.com/gtag/js?id=G-B73TDMXKF5"
    );

    loadScript("https://cdn.jsdelivr.net/npm/preline/dist/index.js");

    window.scrollTo(0, 0);

    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());
    gtag("config", "G-B73TDMXKF5");
}

const { props } = usePage();

onMounted(() => {
    initView();
});
</script>
<template>
    <Head>
        <meta charset="utf-8" />
        <meta
            name="robots"
            content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"
        />
        <link rel="canonical" href="https://preline.co/" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <meta name="twitter:site" content="@preline" />
        <meta name="twitter:creator" content="@preline" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta
            name="description"
            content="DonationHub menghubungkan donatur dengan ribuan keluarga terdampak bencana. Donasi mudah, transparan, dan tepat sasaran."
        />
        <meta
            name="twitter:title"
            content="DonationHub – Bantu Korban Bencana dengan Donasi Mudah & Transparan"
        />
        <meta
            name="twitter:description"
            content="Ribuan keluarga di Sulawesi kehilangan rumah akibat bencana. Ulurkan tangan Anda, bantu mereka bertahan dan bangkit kembali."
        />
        <meta name="twitter:image" content="/img/welcome/hero-bg.jpg" />

        <meta property="og:url" content="https://preline.co/" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="Preline" />
        <meta
            property="og:title"
            content="Coffee Shop Tailwind CSS Template | Preline UI, crafted with Tailwind CSS"
        />
        <meta
            property="og:description"
            content="Explore the Coffee Shop demo with a clean product detail page and flexible checkout options for modern, clean, and minimal e-commerce experiences."
        />
        <meta
            property="og:image"
            content="https://preline.co/assets/img/og-image.png"
        />

        <!-- Title -->
        <title>Donation Hub | Platform Donasi</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="../../favicon.ico" />

        <!-- Font -->
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- Theme Check and Update -->

        <!-- CSS HS -->
        <link
            rel="stylesheet"
            href="https://preline.co/assets/css/main.css?v=3.1.0"
        />
    </Head>
    <div class="py-2 text-center bg-black dark:bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <p class="text-sm text-white dark:text-black">
                🔥 Bantuan Darurat untuk Korban Bencana di Sulawesi Tengah –
                Mari Berdonasi Sekarang!
            </p>
        </div>
    </div>
    <!-- End Announcement Banner -->

    <!-- ========== HEADER ========== -->
    <header
        class="z-50 flex flex-wrap w-full lg:justify-start lg:flex-nowrap py-7"
    >
        <nav
            class="relative flex flex-wrap items-center w-full px-4 mx-auto max-w-7xl lg:grid lg:grid-cols-12 basis-full md:px-6 lg:px-8"
        >
            <div class="flex items-center lg:col-span-3">
                <!-- Logo -->
                <a
                    class="flex-none inline-block text-xl font-semibold rounded-xl focus:outline-hidden focus:opacity-80"
                    href="https://preline.co/templates/creative-agency/index.html"
                    aria-label="Preline"
                >
                    <img
                        src="../../../public/img/logo.png"
                        width="50"
                        height="50"
                        alt="Logo"
                    />
                </a>
                <!-- End Logo -->
            </div>

            <!-- Button Group -->
            <div
                class="flex items-center py-1 gap-x-1 lg:gap-x-2 ms-auto lg:ps-6 lg:order-3 lg:col-span-3"
            >
                <button
                    type="button"
                    class="size-9.5 relative flex justify-center items-center rounded-xl bg-white border border-gray-200 text-black hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-white/10 dark:text-white dark:hover:text-white dark:focus:text-white"
                >
                    <span class="sr-only">Search</span>
                    <svg
                        class="shrink-0 size-4"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                </button>
                <a href="/login">
                    <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-black transition bg-blue-400 border border-transparent gap-x-2 text-nowrap rounded-xl hover:bg-blue-600 focus:outline-hidden focus:bg-blue-600 disabled:opacity-50 disabled:pointer-events-none"
                    >
                        Masuk
                    </button>
                </a>

                <div class="lg:hidden">
                    <button
                        type="button"
                        class="hs-collapse-toggle size-9.5 flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-black hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        id="hs-pro-hcail-collapse"
                        aria-expanded="false"
                        aria-controls="hs-pro-hcail"
                        aria-label="Toggle navigation"
                        data-hs-collapse="#hs-pro-hcail"
                    >
                        <svg
                            class="hs-collapse-open:hidden shrink-0 size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <line x1="3" x2="21" y1="6" y2="6" />
                            <line x1="3" x2="21" y1="12" y2="12" />
                            <line x1="3" x2="21" y1="18" y2="18" />
                        </svg>
                        <svg
                            class="hidden hs-collapse-open:block shrink-0 size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Button Group -->

            <!-- Collapse -->
            <div
                id="hs-pro-hcail"
                class="hidden overflow-hidden transition-all duration-300 hs-collapse basis-full grow lg:block lg:w-auto lg:basis-auto lg:order-2 lg:col-span-6"
                aria-labelledby="hs-pro-hcail-collapse"
            >
                <div
                    class="flex flex-col mt-5 gap-y-4 gap-x-0 lg:flex-row lg:justify-center lg:items-center lg:gap-y-0 lg:gap-x-7 lg:mt-0"
                >
                    <div>
                        <a
                            class="inline-block text-black hover:text-gray-600 focus:outline-hidden focus:text-gray-600 dark:text-white dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            href="../"
                            >Beranda</a
                        >
                    </div>
                    <div>
                        <a
                            class="relative inline-block text-black focus:outline-hidden before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-blue-400 dark:text-white"
                            href="/daftar-donasi"
                            aria-current="page"
                            >Donasi</a
                        >
                    </div>
                    <div>
                        <a
                            class="inline-block text-black hover:text-gray-600 focus:outline-hidden focus:text-gray-600 dark:text-white dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            href="#"
                            >Tentang Kami</a
                        >
                    </div>
                </div>
            </div>
            <!-- End Collapse -->
        </nav>
    </header>

    <main id="content">
        <!-- Works -->
        <section class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-24">
            <div class="max-w-2xl mx-auto mb-6 text-center sm:mb-10">
                <p class="text-sm text-gray-500">Kebaikan mulai dari anda</p>
                <h1
                    class="text-3xl font-medium text-black sm:text-4xl dark:text-white"
                >
                    Campaign Donasi
                </h1>
            </div>

            <!-- Card Grid -->
            <div
                class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-12"
            >
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Gempa Sulawesi"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Bantuan Gempa Sulawesi
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Gempa 6.5 SR melanda Sulawesi, ratusan keluarga
                            kehilangan rumah dan butuh bantuan darurat.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 18%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 87.520.000 terkumpul dari Rp 500.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="/detail-donasi"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Banjir Jakarta"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Banjir Jakarta
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Ribuan warga Jakarta terdampak banjir, membutuhkan
                            makanan, air bersih, dan obat-obatan.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 42%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 125.000.000 terkumpul dari Rp 300.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="#"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Kebakaran Kalimantan"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Kebakaran Hutan Kalimantan
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Asap pekat akibat kebakaran hutan mengancam
                            kesehatan warga sekitar. Mari bantu mereka.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 29%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 220.000.000 terkumpul dari Rp 750.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="#"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Gempa Sulawesi"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Bantuan Gempa Sulawesi
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Gempa 6.5 SR melanda Sulawesi, ratusan keluarga
                            kehilangan rumah dan butuh bantuan darurat.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 18%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 87.520.000 terkumpul dari Rp 500.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="#"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Banjir Jakarta"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Banjir Jakarta
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Ribuan warga Jakarta terdampak banjir, membutuhkan
                            makanan, air bersih, dan obat-obatan.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 42%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 125.000.000 terkumpul dari Rp 300.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="#"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="flex flex-col transition bg-white shadow group rounded-2xl hover:shadow-lg"
                >
                    <div class="aspect-[4/3] overflow-hidden rounded-t-2xl">
                        <img
                            class="object-cover w-full h-full transition group-hover:scale-105"
                            src="https://images.unsplash.com/photo-1508921340878-ba53e1f016ec?q=80&w=800"
                            alt="Kebakaran Kalimantan"
                        />
                    </div>
                    <div class="flex flex-col flex-grow p-4">
                        <h3
                            class="text-lg font-semibold text-gray-900 truncate"
                        >
                            Kebakaran Hutan Kalimantan
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            Asap pekat akibat kebakaran hutan mengancam
                            kesehatan warga sekitar. Mari bantu mereka.
                        </p>
                        <!-- Progress -->
                        <div class="mt-3">
                            <div class="w-full h-2 bg-gray-200 rounded-full">
                                <div
                                    class="h-2 bg-green-500 rounded-full"
                                    style="width: 29%"
                                ></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Rp 220.000.000 terkumpul dari Rp 750.000.000
                            </p>
                        </div>
                        <!-- Tombol -->
                        <div class="pt-4 mt-auto">
                            <a
                                href="#"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-500 rounded-xl hover:bg-blue-600"
                            >
                                Lihat Detail & Donasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card Grid -->

            <!-- <div class="mt-10 text-center lg:mt-20">
                <a
                    class="relative inline-block font-medium md:text-lg text-black before:absolute before:bottom-0.5 before:start-0 before:-z-1 before:w-full before:h-1 before:bg-blue-400 hover:before:bg-black focus:outline-hidden focus:before:bg-black dark:text-white dark:hover:before:bg-white dark:focus:before:bg-white"
                    href="#"
                >
                    View all Products
                </a>
            </div> -->
        </section>
        <!-- End Works -->
    </main>
    <footer
        class="mt-auto border-t border-gray-200 md:border-t-0 dark:border-neutral-700"
    >
        <div
            class="w-full px-4 py-10 mx-auto max-w-7xl md:pt-0 sm:px-6 lg:px-8"
        >
            <!-- Grid -->
            <div class="grid items-center grid-cols-1 gap-5 md:grid-cols-3">
                <div class="text-center md:text-start">
                    <!-- Logo -->
                    <img
                        src="../../../public/img/logo.png"
                        width="50"
                        height="50"
                        alt="Logo"
                    />

                    <!-- End Logo -->
                </div>
                <!-- End Col -->

                <ul class="text-center">
                    <li
                        class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:content-['/'] before:text-black dark:before:text-white"
                    >
                        <a
                            class="inline-flex text-sm text-black gap-x-2 hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                            href="#"
                        >
                            Donasi
                        </a>
                    </li>
                    <li
                        class="inline-block relative pe-8 last:pe-0 last-of-type:before:hidden before:absolute before:top-1/2 before:end-3 before:-translate-y-1/2 before:content-['/'] before:text-black dark:before:text-white"
                    >
                        <a
                            class="inline-flex text-sm text-black gap-x-2 hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                            href="#"
                        >
                            Tentang Kami
                        </a>
                    </li>
                </ul>
                <!-- End Col -->

                <!-- Social Brands -->
                <div class="space-x-2 text-center md:text-end">
                    <a
                        class="inline-flex items-center justify-center text-sm font-semibold text-black border border-transparent rounded-full size-8 gap-x-2 hover:text-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-neutral-400"
                        href="#"
                    >
                        <svg
                            class="shrink-0 size-3.5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"
                            />
                        </svg>
                    </a>
                    <a
                        class="inline-flex items-center justify-center text-sm font-semibold text-black border border-transparent rounded-full size-8 gap-x-2 hover:text-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-neutral-400"
                        href="#"
                    >
                        <svg
                            class="shrink-0 size-3.5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                            />
                        </svg>
                    </a>
                    <a
                        class="inline-flex items-center justify-center text-sm font-semibold text-black border border-transparent rounded-full size-8 gap-x-2 hover:text-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-neutral-400"
                        href="#"
                    >
                        <svg
                            class="shrink-0 size-3.5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"
                            />
                        </svg>
                    </a>
                    <a
                        class="inline-flex items-center justify-center text-sm font-semibold text-black border border-transparent rounded-full size-8 gap-x-2 hover:text-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:text-neutral-400"
                        href="#"
                    >
                        <svg
                            class="shrink-0 size-3.5"
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M3.362 10.11c0 .926-.756 1.681-1.681 1.681S0 11.036 0 10.111C0 9.186.756 8.43 1.68 8.43h1.682v1.68zm.846 0c0-.924.756-1.68 1.681-1.68s1.681.756 1.681 1.68v4.21c0 .924-.756 1.68-1.68 1.68a1.685 1.685 0 0 1-1.682-1.68v-4.21zM5.89 3.362c-.926 0-1.682-.756-1.682-1.681S4.964 0 5.89 0s1.68.756 1.68 1.68v1.682H5.89zm0 .846c.924 0 1.68.756 1.68 1.681S6.814 7.57 5.89 7.57H1.68C.757 7.57 0 6.814 0 5.89c0-.926.756-1.682 1.68-1.682h4.21zm6.749 1.682c0-.926.755-1.682 1.68-1.682.925 0 1.681.756 1.681 1.681s-.756 1.681-1.68 1.681h-1.681V5.89zm-.848 0c0 .924-.755 1.68-1.68 1.68A1.685 1.685 0 0 1 8.43 5.89V1.68C8.43.757 9.186 0 10.11 0c.926 0 1.681.756 1.681 1.68v4.21zm-1.681 6.748c.926 0 1.682.756 1.682 1.681S11.036 16 10.11 16s-1.681-.756-1.681-1.68v-1.682h1.68zm0-.847c-.924 0-1.68-.755-1.68-1.68 0-.925.756-1.681 1.68-1.681h4.21c.924 0 1.68.756 1.68 1.68 0 .926-.756 1.681-1.68 1.681h-4.21z"
                            />
                        </svg>
                    </a>
                </div>
                <!-- End Social Brands -->
            </div>
            <!-- End Grid -->
        </div>
    </footer>
</template>
