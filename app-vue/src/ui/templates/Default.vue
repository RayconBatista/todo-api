<template>
    <Navbar />

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <Sidebar />
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="rounded-lg mt-14">
            <RouterView />
        </div>
    </div>
</template>
<script>
import Navbar from '@/ui/components/Navbar.vue';
import Sidebar from '@/ui/components/Sidebar.vue';

export default {
    name: 'Default',
    components: {
        Navbar,
        Sidebar
    },
    setup() {}
};
</script>
