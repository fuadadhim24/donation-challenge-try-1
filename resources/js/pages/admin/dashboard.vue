<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { useScriptTag } from "@vueuse/core";
import { usePage, router, useForm } from "@inertiajs/vue3";
import axios from "axios";

const page = usePage();
const authUser = page.props.auth.user ?? null;
const userRole = authUser ? authUser.role : null;
const isDark = ref(false);

defineProps({
    projects: Array,
    totalProjects: Number,
    activeProjects: Number,
    pendingProjects: Number,
    rejectedProjects: Number,
    finishedProjects: Number,
    totalCollected: Number,
});

const showModal = ref(false);

const form = useForm({
    title: "",
    short_description: "",
    target_amount: "",
    thumbnail: null,
});

function handleFile(e) {
    form.images = Array.from(e.target.files);
}

function submitProject() {
    let formData = new FormData();
    formData.append("name", form.name);
    formData.append("description", form.description);
    formData.append("target_amount", form.target_amount);
    formData.append("currency", "IDR");
    formData.append("status", "approved");

    // masukkan semua file
    form.images.forEach((file, i) => {
        formData.append(`images[${i}]`, file);
    });
    console.log(formData);

    axios
        .post("/admin/add-project", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
        .then((res) => {
            console.log("Berhasil buat campaign", res.data);
            showModal.value = false;
            form.reset();
            router.reload();
        })
        .catch((err) => console.log(err.response.data));
}
function updateStatus(newStatus) {
    if (!selectedProject.value) return;

    axios
        .put(`/admin/projects/${selectedProject.value.id}/status`, {
            status: newStatus,
        })
        .then((res) => {
            selectedProject.value.status = newStatus;
            if (newStatus === "approved") {
                showDetailModal.value = false;
            }
            alert(`Status berhasil diubah ke ${newStatus}`);
            router.reload();
        })
        .catch((err) => {
            console.error("Gagal update status:", err);
            alert("Terjadi kesalahan saat mengubah status.");
        });
}

function setBodyClass(...classes) {
    document.body.className = "";
    document.body.classList.add(...classes);
}

function loadScript(src) {
    return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src = src;
        script.async = true;
        script.onload = () => resolve(src);
        script.onerror = () => reject(new Error(`Gagal load ${src}`));
        document.body.appendChild(script);
    });
}

async function initCharts() {
    await loadScript("https://cdn.jsdelivr.net/npm/preline/dist/index.js");
    await loadScript("https://cdn.jsdelivr.net/npm/lodash/lodash.min.js");
    await loadScript(
        "https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.min.js"
    );
    await loadScript(
        "https://cdn.jsdelivr.net/npm/preline/dist/helper-apexcharts.js"
    );
    if (typeof window.buildChart !== "function") {
        console.error("Masih gagal, buildChart belum ada!");
        return;
    }
    console.log("✅ buildChart siap! Sekarang gambar chart...");

    window.buildChart(
        "#multiChart",
        (mode) => ({
            chart: {
                type: "bar",
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            series: [
                {
                    name: "Chosen Period",
                    data: [
                        23000, 44000, 55000, 57000, 56000, 61000, 58000, 63000,
                        60000, 66000, 34000, 78000,
                    ],
                },
                {
                    name: "Last Period",
                    data: [
                        17000, 76000, 85000, 101000, 98000, 87000, 105000,
                        91000, 114000, 94000, 67000, 66000,
                    ],
                },
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "16px",
                    borderRadius: 0,
                },
            },
            legend: { show: false },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 8, colors: ["transparent"] },
            xaxis: {
                categories: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                axisBorder: { show: false },
                axisTicks: { show: false },
                crosshairs: { show: false },
                labels: {
                    style: {
                        colors: "#9ca3af",
                        fontSize: "13px",
                        fontFamily: "Inter, ui-sans-serif",
                        fontWeight: 400,
                    },
                    offsetX: -2,
                    formatter: (title) => title.slice(0, 3),
                },
            },
            yaxis: {
                labels: {
                    align: "left",
                    minWidth: 0,
                    maxWidth: 140,
                    style: {
                        colors: "#9ca3af",
                        fontSize: "13px",
                        fontFamily: "Inter, ui-sans-serif",
                        fontWeight: 400,
                    },
                    formatter: (value) =>
                        value >= 1000 ? `${value / 1000}k` : value,
                },
            },
            states: { hover: { filter: { type: "darken", value: 0.9 } } },
            tooltip: {
                y: {
                    formatter: (value) =>
                        `$${value >= 1000 ? `${value / 1000}k` : value}`,
                },
                custom: function (props) {
                    const { categories } = props.ctx.opts.xaxis;
                    const { dataPointIndex } = props;
                    const title = categories[dataPointIndex];
                    const newTitle = `${title}`;
                    return buildTooltip(props, {
                        title: newTitle,
                        mode,
                        hasTextLabel: true,
                        wrapperExtClasses: "min-w-28",
                        labelDivider: ":",
                        labelExtClasses: "ms-2",
                    });
                },
            },
            responsive: [
                {
                    breakpoint: 568,
                    options: {
                        chart: { height: 300 },
                        plotOptions: { bar: { columnWidth: "14px" } },
                        stroke: { width: 8 },
                        labels: {
                            style: {
                                colors: "#9ca3af",
                                fontSize: "11px",
                                fontFamily: "Inter, ui-sans-serif",
                                fontWeight: 400,
                            },
                            offsetX: -2,
                            formatter: (title) => title.slice(0, 3),
                        },
                        yaxis: {
                            labels: {
                                align: "left",
                                minWidth: 0,
                                maxWidth: 140,
                                style: {
                                    colors: "#9ca3af",
                                    fontSize: "11px",
                                    fontFamily: "Inter, ui-sans-serif",
                                    fontWeight: 400,
                                },
                                formatter: (value) =>
                                    value >= 1000 ? `${value / 1000}k` : value,
                            },
                        },
                    },
                },
            ],
        }),
        // Light mode config
        {
            colors: ["#2563eb", "#d1d5db"],
            grid: { borderColor: "#e5e7eb" },
        },
        // Dark mode config
        {
            colors: ["#6b7280", "#2563eb"],
            grid: { borderColor: "#404040" },
        }
    );

    // =========================
    // Chart 2: Single Area Chart
    // =========================
    window.buildChart(
        "#singleAreaChart",
        (mode) => ({
            chart: {
                height: 300,
                type: "area",
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            series: [
                {
                    name: "Visitors",
                    data: [180, 51, 60, 38, 88, 50, 40, 52, 88, 80, 60, 70],
                },
            ],
            legend: { show: false },
            dataLabels: { enabled: false },
            stroke: { curve: "straight", width: 2 },
            grid: { strokeDashArray: 2 },
            fill: {
                type: "gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    opacityFrom: 0.1,
                    opacityTo: 0.8,
                },
            },
            xaxis: {
                type: "category",
                tickPlacement: "on",
                categories: [
                    "25 January 2023",
                    "26 January 2023",
                    "27 January 2023",
                    "28 January 2023",
                    "29 January 2023",
                    "30 January 2023",
                    "31 January 2023",
                    "1 February 2023",
                    "2 February 2023",
                    "3 February 2023",
                    "4 February 2023",
                    "5 February 2023",
                ],
                axisBorder: { show: false },
                axisTicks: { show: false },
                crosshairs: {
                    stroke: { dashArray: 0 },
                    dropShadow: { show: false },
                },
                tooltip: { enabled: false },
                labels: {
                    style: {
                        colors: "#9ca3af",
                        fontSize: "13px",
                        fontFamily: "Inter, ui-sans-serif",
                        fontWeight: 400,
                    },
                    formatter: (title) => {
                        let t = title;
                        if (t) {
                            const newT = t.split(" ");
                            t = `${newT[0]} ${newT[1].slice(0, 3)}`;
                        }
                        return t;
                    },
                },
            },
            yaxis: {
                labels: {
                    align: "left",
                    minWidth: 0,
                    maxWidth: 140,
                    style: {
                        colors: "#9ca3af",
                        fontSize: "13px",
                        fontFamily: "Inter, ui-sans-serif",
                        fontWeight: 400,
                    },
                    formatter: (value) =>
                        value >= 1000 ? `${value / 1000}k` : value,
                },
            },
            tooltip: {
                x: { format: "MMMM yyyy" },
                y: {
                    formatter: (value) =>
                        `${value >= 1000 ? `${value / 1000}k` : value}`,
                },
                custom: function (props) {
                    const { categories } = props.ctx.opts.xaxis;
                    const { dataPointIndex } = props;
                    const title = categories[dataPointIndex].split(" ");
                    const newTitle = `${title[0]} ${title[1]}`;
                    return buildTooltip(props, {
                        title: newTitle,
                        mode,
                        valuePrefix: "",
                        hasTextLabel: true,
                        wrapperExtClasses: "min-w-28",
                    });
                },
            },
            responsive: [
                {
                    breakpoint: 568,
                    options: {
                        chart: { height: 300 },
                        labels: {
                            style: {
                                colors: "#9ca3af",
                                fontSize: "11px",
                                fontFamily: "Inter, ui-sans-serif",
                                fontWeight: 400,
                            },
                            offsetX: -2,
                            formatter: (title) => title.slice(0, 3),
                        },
                        yaxis: {
                            labels: {
                                align: "left",
                                minWidth: 0,
                                maxWidth: 140,
                                style: {
                                    colors: "#9ca3af",
                                    fontSize: "11px",
                                    fontFamily: "Inter, ui-sans-serif",
                                    fontWeight: 400,
                                },
                                formatter: (value) =>
                                    value >= 1000 ? `${value / 1000}k` : value,
                            },
                        },
                    },
                },
            ],
        }),
        // Light mode config
        {
            colors: ["#2563eb", "#9333ea"],
            fill: { gradient: { stops: [0, 90, 100] } },
            grid: { borderColor: "#e5e7eb" },
        },
        // Dark mode config
        {
            colors: ["#3b82f6", "#a855f7"],
            fill: { gradient: { stops: [100, 90, 0] } },
            grid: { borderColor: "#404040" },
        }
    );
}
function logout() {
    router.post(route("logout"));
}

const title = "Dashboard Admin | Donation Hub";
const getProgress = (collected, target) => {
    if (!target || target === 0) return 0;
    return Math.min(Math.round((collected / target) * 100), 100);
};
function cleanImageUrl(url) {
    return url?.replace("requester/requester", "requester/");
}
const getStatusBadge = (status) => {
    switch (status.toLowerCase()) {
        case "approved":
            return "bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-500";
        case "completed":
            return "bg-gray-100 text-green-800 dark:bg-green-500/10 dark:text-green-500";
        case "need_review":
            return "bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500";
        case "rejected":
            return "bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500";
        default:
            return "bg-gray-100 text-gray-800 dark:bg-gray-500/10 dark:text-gray-500";
    }
};
const showDetailModal = ref(false);
const selectedProject = ref(null);

function openProjectDetail(project) {
    selectedProject.value = project;
    showDetailModal.value = true;
}
function deleteProject(id) {
    if (!confirm("Yakin ingin menghapus project ini?")) return;

    axios
        .delete(`/admin/projects/${id}`, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
        .then(() => {
            router.reload();
        })
        .catch((err) => {
            console.error("Gagal hapus project:", err);
        });
}

onMounted(() => {
    setBodyClass("bg-gray-50", "dark:bg-neutral-900");
    initCharts();
});
</script>

<template>
    <Head>
        <title>{{ title }}</title>
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
        <meta
            name="description"
            content="Comprehensive overview with charts, tables, and a streamlined dashboard layout for easy data visualization and analysis."
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css"
        />
    </Head>

    <!-- <div class="p-6 space-y-8">
        <h1 class="text-2xl font-bold">{{ title }}</h1>
        <div ref="multiChart" class="h-80"></div>
        <div ref="singleAreaChart" class="h-80"></div>
    </div> -->
    <header
        class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-48 w-full bg-white border-b border-gray-200 text-sm py-2.5 lg:ps-65 dark:bg-neutral-800 dark:border-neutral-700"
    >
        <nav class="flex items-center w-full px-4 mx-auto sm:px-6 basis-full">
            <div class="flex items-center me-5 lg:me-0 lg:hidden">
                <!-- Logo -->
                <a
                    class="flex-none inline-block text-xl font-semibold rod-md focus:outline-hidden focus:opacity-80"
                    href="#"
                    aria-label="Preline"
                >
                    <img
                        src="../../../../public/img/logo.png"
                        width="50"
                        height="50"
                        alt="Logo"
                    />
                </a>
                <!-- End Logo -->
            </div>

            <div
                class="flex items-center justify-end w-full ms-auto md:justify-between gap-x-1 md:gap-x-3"
            >
                <div class="hidden md:block">
                    <!-- Search Input -->
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5"
                        >
                            <svg
                                class="text-gray-400 shrink-0 size-4 dark:text-white/60"
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
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            class="block w-full py-2 text-sm bg-white border-gray-200 rounded-lg ps-10 pe-16 focus:outline-hidden focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-600"
                            placeholder="Search"
                        />
                        <div
                            class="absolute inset-y-0 z-20 flex items-center hidden end-0 pe-1"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center justify-center text-gray-500 rounded-full shrink-0 size-6 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500"
                                aria-label="Close"
                            >
                                <span class="sr-only">Close</span>
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
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="m15 9-6 6" />
                                    <path d="m9 9 6 6" />
                                </svg>
                            </button>
                        </div>
                        <div
                            class="absolute inset-y-0 z-20 flex items-center text-gray-400 pointer-events-none end-0 pe-3"
                        >
                            <svg
                                class="text-gray-400 shrink-0 size-3 dark:text-white/60"
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
                                <path
                                    d="M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3"
                                />
                            </svg>
                            <span class="mx-1">
                                <svg
                                    class="text-gray-400 shrink-0 size-3 dark:text-white/60"
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
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </span>
                            <span class="text-xs">/</span>
                        </div>
                    </div>
                    <!-- End Search Input -->
                </div>

                <div class="flex flex-row items-center justify-end gap-1">
                    <button
                        type="button"
                        class="md:hidden size-9.5 relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    >
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
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>

                    <button
                        type="button"
                        class="size-9.5 relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    >
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
                            <path
                                d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"
                            />
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                        <span class="sr-only">Notifications</span>
                    </button>

                    <button
                        type="button"
                        class="size-9.5 relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    >
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
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                        <span class="sr-only">Activity</span>
                    </button>

                    <!-- Dropdown -->
                    <div class="relative inline-flex hs-dropdown">
                        <button
                            id="hs-dropdown-account"
                            type="button"
                            class="inline-flex items-center justify-center border rounded-full size-9"
                        >
                            <img
                                class="rounded-full"
                                :src="authUser.avatar_url"
                                alt="Avatar"
                            />
                        </button>

                        <div
                            class="absolute z-50 hidden mt-2 bg-white rounded-lg shadow-md hs-dropdown-menu min-w-56"
                            aria-labelledby="hs-dropdown-account"
                        >
                            <div class="px-4 py-3 bg-gray-100 rounded-t-lg">
                                <p class="text-sm text-gray-500">
                                    Masuk sebagai
                                </p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ authUser.email }}
                                </p>
                            </div>
                            <div class="p-2 space-y-1">
                                <a
                                    :href="
                                        userRole != null
                                            ? `/${userRole}/dashboard`
                                            : '/login'
                                    "
                                    class="block w-full px-4 py-2 text-left text-gray-700 rounded hover:bg-gray-100"
                                >
                                    Beranda
                                </a>
                                <button
                                    @click="logout"
                                    class="flex items-center w-full gap-2 px-4 py-2 text-left text-red-500 rounded hover:bg-gray-100"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="size-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                    >
                                        <path
                                            d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"
                                        />
                                        <polyline points="10 17 15 12 10 7" />
                                        <line x1="15" y1="12" x2="3" y2="12" />
                                    </svg>
                                    Keluar
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Dropdown -->
                </div>
            </div>
        </nav>
    </header>
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <!-- modal -->
    <div v-if="showModal">
        <div class="fixed inset-0 bg-black/50 z-[90]" />
        <div class="fixed inset-0 z-[100] flex items-center justify-center">
            <div
                class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg dark:bg-neutral-800"
            >
                <h3 class="mb-4 text-lg font-semibold">Buat Campaign Donasi</h3>

                <!-- Form -->
                <form @submit.prevent="submitProject" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium"
                            ><span class="text-red-600">*</span>Judul</label
                        >
                        <input
                            v-model="form.name"
                            class="w-full p-2 mt-1 border rounded"
                            type="text"
                            placeholder="contoh: Peduli Bencana Banjir Sulawesi"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Deskripsi Singkat</label
                        >
                        <textarea
                            v-model="form.description"
                            class="w-full p-2 mt-1 border rounded"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            ><span class="text-red-600">*</span>Target
                            Dana</label
                        >
                        <input
                            v-model="form.target_amount"
                            class="w-full p-2 mt-1 border rounded"
                            type="number"
                            placeholder="contoh: 5000000"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            ><span class="text-red-600">*</span>Thumbnail</label
                        >
                        <input
                            class="w-full px-4 py-4 mt-1 text-gray-500 border border-gray-500 rounded-md"
                            type="file"
                            @change="handleFile"
                        />
                    </div>

                    <!-- Action -->
                    <div class="flex justify-end mt-4 gap-x-2">
                        <button
                            type="button"
                            @click="showModal = false"
                            class="px-4 py-2 bg-gray-200 rounded"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 text-white bg-blue-600 rounded"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal detail -->
    <div v-if="showDetailModal">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 z-[90]" />

        <!-- Modal Content -->
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div
                class="relative w-full max-w-xl overflow-hidden bg-white shadow-xl rounded-2xl dark:bg-neutral-800"
            >
                <!-- Gambar -->
                <div class="overflow-hidden max-h-[250px]">
                    <img
                        v-if="selectedProject?.images?.length"
                        :src="`/${cleanImageUrl(
                            selectedProject.images[0]?.url
                        )}`"
                        alt="Project Image"
                        class="object-cover w-full h-full"
                    />
                </div>

                <!-- Konten -->
                <div class="p-6 space-y-3">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ selectedProject.name }}
                    </h3>

                    <p class="text-sm text-gray-600 whitespace-pre-line">
                        {{ selectedProject.description }}
                    </p>

                    <!-- Progress Bar -->
                    <div>
                        <div class="w-full h-2 bg-gray-200 rounded-full">
                            <div
                                class="h-2 bg-green-500 rounded-full"
                                :style="`width: ${
                                    (selectedProject.collection_amount /
                                        selectedProject.target_amount) *
                                    100
                                }%`"
                            ></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-600">
                            Rp
                            {{
                                selectedProject.collection_amount.toLocaleString(
                                    "id-ID"
                                )
                            }}
                            terkumpul dari Rp
                            {{
                                selectedProject.target_amount.toLocaleString(
                                    "id-ID"
                                )
                            }}
                        </p>
                    </div>

                    <!-- Info Lain -->
                    <div class="space-y-1 text-sm text-gray-700">
                        <p>
                            <strong>Status sekarang:</strong>
                            {{ selectedProject.status }}
                        </p>

                        <p>
                            <strong>Dibuat:</strong>
                            {{
                                new Date(
                                    selectedProject.created_at
                                ).toLocaleString("id-ID")
                            }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 mt-2">
                            <button
                                class="px-3 py-1 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
                                @click="updateStatus('approved')"
                                :disabled="
                                    selectedProject.status === 'approved'
                                "
                            >
                                Setujui
                            </button>

                            <button
                                class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600"
                                @click="updateStatus('rejected')"
                                :disabled="
                                    selectedProject.status === 'rejected'
                                "
                            >
                                Tolak
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Tutup -->
                    <div class="flex justify-end pt-4">
                        <button
                            @click="showDetailModal = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div
        class="sticky inset-x-0 top-0 z-20 px-4 bg-white border-gray-200 border-y sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700"
    >
        <div class="flex items-center py-2">
            <!-- Navigation Toggle -->
            <button
                type="button"
                class="flex items-center justify-center text-gray-800 border border-gray-200 rounded-lg size-8 gap-x-2 hover:text-gray-500 focus:outline-hidden focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500"
                aria-haspopup="dialog"
                aria-expanded="false"
                aria-controls="hs-application-sidebar"
                aria-label="Toggle navigation"
                data-hs-overlay="#hs-application-sidebar"
            >
                <span class="sr-only">Toggle Navigation</span>
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
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M15 3v18" />
                    <path d="m8 9 3 3-3 3" />
                </svg>
            </button>
            <!-- End Navigation Toggle -->

            <!-- Breadcrumb -->
            <ol class="flex items-center ms-3 whitespace-nowrap">
                <li
                    class="flex items-center text-sm text-gray-800 dark:text-neutral-400"
                >
                    Application Layout
                    <svg
                        class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>
                </li>
                <li
                    class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400"
                    aria-current="page"
                >
                    Beranda
                </li>
            </ol>
            <!-- End Breadcrumb -->
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Sidebar -->
    <div
        id="hs-application-sidebar"
        class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-65 h-full hidden fixed inset-y-0 start-0 z-60 bg-white border-e border-gray-200 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-neutral-800 dark:border-neutral-700"
        role="dialog"
        tabindex="-1"
        aria-label="Sidebar"
    >
        <div class="relative flex flex-col h-full max-h-full">
            <div class="flex items-center px-6 pt-4">
                <!-- Logo -->
                <a
                    class="flex-none inline-block text-xl font-semibold rounded-xl focus:outline-hidden focus:opacity-80"
                    href="#"
                    aria-label="Preline"
                >
                    <img
                        src="../../../../public/img/logo.png"
                        width="50"
                        height="50"
                        alt="Logo"
                    />
                </a>

                <!-- End Logo -->
            </div>

            <!-- Content -->
            <div
                class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500"
            >
                <nav
                    class="flex flex-col flex-wrap w-full p-3 hs-accordion-group"
                    data-hs-accordion-always-open
                >
                    <ul class="flex flex-col space-y-1">
                        <li>
                            <a
                                class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-white"
                                href="#"
                            >
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
                                    <path
                                        d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                                    />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                                Beranda
                            </a>
                        </li>
                        <!--
                        <li>
                            <a
                                class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200"
                                href="#"
                            >
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
                                    <path
                                        d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"
                                    />
                                    <path
                                        d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"
                                    />
                                </svg>
                                Projek Donasi
                            </a>
                        </li> -->
                        <li class="hs-accordion" id="account-accordion">
                            <button
                                type="button"
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200"
                                aria-expanded="true"
                                aria-controls="account-accordion-child"
                            >
                                <svg
                                    class="shrink-0 mt-0.5 size-4"
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
                                    <circle cx="18" cy="15" r="3" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M10 15H6a4 4 0 0 0-4 4v2" />
                                    <path d="m21.7 16.4-.9-.3" />
                                    <path d="m15.2 13.9-.9-.3" />
                                    <path d="m16.6 18.7.3-.9" />
                                    <path d="m19.1 12.2.3-.9" />
                                    <path d="m19.6 18.7-.4-1" />
                                    <path d="m16.8 12.3-.4-1" />
                                    <path d="m14.3 16.6 1-.4" />
                                    <path d="m20.7 13.8 1-.4" />
                                </svg>
                                Manajemen Akun

                                <svg
                                    class="hidden hs-accordion-active:block ms-auto size-4"
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
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg
                                    class="block hs-accordion-active:hidden ms-auto size-4"
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
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div
                                id="account-accordion-child"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                role="region"
                                aria-labelledby="account-accordion"
                            >
                                <ul class="pt-1 space-y-1 ps-8">
                                    <li>
                                        <a
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200"
                                            href="#"
                                        >
                                            Donatur
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200"
                                            href="#"
                                        >
                                            Campaigner
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- End Content -->
        </div>
    </div>
    <!-- End Sidebar -->

    <!-- Content -->
    <div class="w-full lg:ps-64">
        <div class="p-4 space-y-4 sm:p-6 sm:space-y-6">
            <!-- Grid -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-2 sm:gap-6">
                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p
                                class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                            >
                                Projek Selesai
                            </p>
                        </div>

                        <div class="flex items-center mt-1 gap-x-2">
                            <h3
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                {{ finishedProjects }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p
                                class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                            >
                                Total Projek
                            </p>
                        </div>

                        <div class="flex items-center mt-1 gap-x-2">
                            <h3
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                {{ totalProjects }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
            <!-- Grid -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800"
                >
                    <div class="p-4 md:p-5">
                        <p
                            class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                        >
                            Projek Aktif
                        </p>
                        <h3
                            class="mt-1 text-xl font-medium dark:text-neutral-200"
                        >
                            {{ activeProjects }}
                        </h3>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p
                                class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                            >
                                Terkumpul
                            </p>
                        </div>

                        <div class="flex items-center mt-1 gap-x-2">
                            <h3
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                Rp {{ totalCollected.toLocaleString("id-ID") }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p
                                class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                            >
                                Projek Ditolak
                            </p>
                        </div>

                        <div class="flex items-center mt-1 gap-x-2">
                            <h3
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                {{ rejectedProjects }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <div class="p-4 md:p-5">
                        <div class="flex items-center gap-x-2">
                            <p
                                class="text-xs text-gray-500 uppercase dark:text-neutral-500"
                            >
                                Projek Pending
                            </p>
                        </div>

                        <div class="flex items-center mt-1 gap-x-2">
                            <h3
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                {{ pendingProjects }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Grid -->

            <div class="grid gap-4 lg:grid-cols-2 sm:gap-6">
                <!-- Card -->
                <div
                    class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <!-- Header -->
                    <div
                        class="flex flex-wrap items-center justify-between gap-2"
                    >
                        <div>
                            <h2
                                class="text-sm text-gray-500 dark:text-neutral-500"
                            >
                                Permintaan Projek Donasi
                            </h2>
                            <p
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                $126,238.49
                            </p>
                        </div>

                        <div>
                            <span
                                class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-teal-100 text-teal-800 dark:bg-teal-500/10 dark:text-teal-500"
                            >
                                <svg
                                    class="inline-block size-3.5"
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
                                    <path d="M12 5v14" />
                                    <path d="m19 12-7 7-7-7" />
                                </svg>
                                25%
                            </span>
                        </div>
                    </div>
                    <!-- End Header -->

                    <div id="multiChart"></div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="p-4 md:p-5 min-h-102.5 flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700"
                >
                    <!-- Header -->
                    <div
                        class="flex flex-wrap items-center justify-between gap-2"
                    >
                        <div>
                            <h2
                                class="text-sm text-gray-500 dark:text-neutral-500"
                            >
                                Keaktifan Donatur
                            </h2>
                            <p
                                class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-neutral-200"
                            >
                                80.3k
                            </p>
                        </div>

                        <div>
                            <span
                                class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500"
                            >
                                <svg
                                    class="inline-block size-3.5"
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
                                    <path d="M12 5v14" />
                                    <path d="m19 12-7 7-7-7" />
                                </svg>
                                2%
                            </span>
                        </div>
                    </div>
                    <!-- End Header -->

                    <div id="singleAreaChart"></div>
                </div>
                <!-- End Card -->
            </div>

            <!-- Card -->
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div
                            class="overflow-hidden bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700"
                        >
                            <!-- Header -->
                            <div
                                class="grid gap-3 px-6 py-4 border-b border-gray-200 md:flex md:justify-between md:items-center dark:border-neutral-700"
                            >
                                <div>
                                    <h2
                                        class="text-xl font-semibold text-gray-800 dark:text-neutral-200"
                                    >
                                        Projek Donasi
                                    </h2>
                                    <p
                                        class="text-sm text-gray-600 dark:text-neutral-400"
                                    >
                                        Rekapan Akumulatif
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <a
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg gap-x-2 hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                            @click="showModal = true"
                                        >
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
                                                <path d="M5 12h14" />
                                                <path d="M12 5v14" />
                                            </svg>
                                            Buat Campaign Donasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->

                            <!-- Table -->
                            <table
                                class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
                            >
                                <thead class="bg-gray-50 dark:bg-neutral-800">
                                    <tr>
                                        <!-- Nama Project -->
                                        <th
                                            scope="col"
                                            class="py-4 text-left ps-6 pe-4"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Gambar
                                            </span>
                                        </th>

                                        <!-- Target & Terkumpul -->
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-left"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Nama Project
                                            </span>
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-left"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Target & Terkumpul
                                            </span>
                                        </th>

                                        <!-- Status -->
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-left"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Status
                                            </span>
                                        </th>

                                        <!-- Progress -->
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-left"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Progress
                                            </span>
                                        </th>

                                        <!-- Dibuat -->
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-left"
                                        >
                                            <span
                                                class="text-xs font-semibold text-gray-800 uppercase dark:text-neutral-200"
                                            >
                                                Dibuat
                                            </span>
                                        </th>

                                        <!-- Aksi -->
                                        <th
                                            scope="col"
                                            class="px-6 py-4 text-right"
                                        >
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody
                                    class="divide-y divide-gray-200 dark:divide-neutral-700"
                                >
                                    <tr
                                        v-for="project in projects"
                                        :key="project.id"
                                    >
                                        <!-- Nama Project -->
                                        <td
                                            class="py-4 ps-6 pe-4 whitespace-nowrap"
                                        >
                                            <div
                                                class="flex items-center gap-x-3"
                                            >
                                                <img
                                                    class="inline-block object-cover w-12 h-12 rounded-lg"
                                                    :src="`/${cleanImageUrl(
                                                        project.images[0]?.url
                                                    )}`"
                                                    :alt="gambar"
                                                />
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                                    >
                                                        {{ project.title }}
                                                    </span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-neutral-500"
                                                    >
                                                        {{
                                                            project.short_description?.slice(
                                                                0,
                                                                30
                                                            )
                                                        }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="py-4 ps-6 pe-4 whitespace-nowrap"
                                        >
                                            <div
                                                class="flex items-center gap-x-3"
                                            >
                                                <p>{{ project.name }}</p>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                                    >
                                                        {{ project.title }}
                                                    </span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-neutral-500"
                                                    >
                                                        {{
                                                            project.short_description?.slice(
                                                                0,
                                                                30
                                                            )
                                                        }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Target & Terkumpul -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="block text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                            >
                                                Rp
                                                {{
                                                    new Intl.NumberFormat(
                                                        "id-ID"
                                                    ).format(
                                                        project.target_amount
                                                    )
                                                }}
                                            </span>
                                            <span
                                                class="block text-xs text-gray-500 dark:text-neutral-500"
                                            >
                                                Terkumpul: Rp
                                                {{
                                                    new Intl.NumberFormat(
                                                        "id-ID"
                                                    ).format(
                                                        project.collection_amount
                                                    )
                                                }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full gap-x-1"
                                                :class="
                                                    getStatusBadge(
                                                        project.status
                                                    )
                                                "
                                            >
                                                <!-- icon sesuai status -->
                                                <svg
                                                    v-if="
                                                        project.status ===
                                                            'active' ||
                                                        project.status ===
                                                            'completed'
                                                    "
                                                    class="w-3 h-3"
                                                    viewBox="0 0 16 16"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99z"
                                                    />
                                                </svg>
                                                {{ project.status }}
                                            </span>
                                        </td>

                                        <!-- Progress -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div
                                                class="flex items-center gap-x-3"
                                            >
                                                <span
                                                    class="text-xs text-gray-500 dark:text-neutral-500"
                                                >
                                                    {{
                                                        getProgress(
                                                            project.collection_amount,
                                                            project.target_amount
                                                        )
                                                    }}%
                                                </span>
                                                <div
                                                    class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700"
                                                >
                                                    <div
                                                        class="h-full bg-blue-600 dark:bg-blue-400"
                                                        :style="{
                                                            width:
                                                                getProgress(
                                                                    project.collection_amount,
                                                                    project.target_amount
                                                                ) + '%',
                                                        }"
                                                    />
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Tanggal -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="text-sm text-gray-500 dark:text-neutral-500"
                                            >
                                                {{
                                                    new Date(
                                                        project.created_at
                                                    ).toLocaleDateString(
                                                        "id-ID",
                                                        {
                                                            day: "2-digit",
                                                            month: "short",
                                                            hour: "2-digit",
                                                            minute: "2-digit",
                                                        }
                                                    )
                                                }}
                                            </span>
                                        </td>

                                        <!-- Aksi -->
                                        <td
                                            class="px-6 py-4 text-right whitespace-nowrap"
                                        >
                                            <button
                                                @click="
                                                    openProjectDetail(project)
                                                "
                                                class="inline-flex items-center mx-4 text-sm font-medium text-blue-600 gap-x-1 hover:underline dark:text-blue-400"
                                            >
                                                Lihat Detail
                                            </button>
                                            <button
                                                @click="
                                                    deleteProject(project.id)
                                                "
                                                class="inline-flex items-center text-sm font-medium text-red-600 gap-x-1 hover:underline dark:text-blue-400"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Table -->

                            <!-- Footer -->
                            <div
                                class="grid gap-3 px-6 py-4 border-t border-gray-200 md:flex md:justify-between md:items-center dark:border-neutral-700"
                            >
                                <div>
                                    <p
                                        class="text-sm text-gray-600 dark:text-neutral-400"
                                    >
                                        <span
                                            class="font-semibold text-gray-800 dark:text-neutral-200"
                                            >12</span
                                        >
                                        results
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <button
                                            type="button"
                                            class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                        >
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
                                                <path d="m15 18-6-6 6-6" />
                                            </svg>
                                            Prev
                                        </button>

                                        <button
                                            type="button"
                                            class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                        >
                                            Next
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
                                                <path d="m9 18 6-6-6-6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.apexcharts-tooltip.apexcharts-theme-light {
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
}
</style>

<style>
.chart-container {
    height: 300px;
}
</style>
