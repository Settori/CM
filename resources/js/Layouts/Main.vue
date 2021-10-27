<template>
    <div>
        <main>
            <div class="h-screen bg-gray-200 dark:bg-gray-500 flex">
                <LeftPanel class="sm:flex hidden" :image="image"/>
                <div class="sm:hidden fixed top-4 left-4 rounded-full">
                    Menu
                </div>
                <div class="flex-1 flex flex-col overflow-hidden">
                    <slot  />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import LeftPanel from '@/Components/LeftPanel.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        LeftPanel,
        Link,
    },
    props: {
        image: {
            type: String,
            default: null
        }
    }


}
</script>
