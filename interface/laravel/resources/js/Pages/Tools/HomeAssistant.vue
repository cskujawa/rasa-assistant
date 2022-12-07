<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Home Assistant">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-lg sm:rounded-lg">
                    <iframe name="home_assistant" src="http://192.168.0.161:8123" id="home_assistant" sandbox="allow-forms allow-popups allow-same-origin allow-scripts" width=100% height=800 class="sm:rounded-lg shadow-lg"></iframe>
                </div>
            </div>
        </div>
    </AppLayout>
</template>