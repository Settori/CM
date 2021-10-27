<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <!-- <div v-if="link.url === null" class="mr-1 mb-1 bg-white px-4 py-3 text-xs leading-4 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-800 text-gray-400 border border-gray-400 rounded"
                    v-html="link.label" /> -->
                <Link v-if="link.url !== null"
                    class="mr-1 mb-1 px-4 py-2 text-xs leading-4 border rounded bg-white dark:bg-gray-700 dark:text-white dark:border-gray-800 focus:border-pink-500 focus:text-pink-500"
                    :class="{ 'bg-pink-700 border-pink-800 text-white ': link.active, 'border-gray-400':!link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    export default {
        components: {
            Link
        },
        props: {
            links: Array
        },
    }

</script>
