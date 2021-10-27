<template>
    <div class="w-56 px-4 bg-gray-800 text-white relative h-screen overflow-y-auto overscroll-x-none flex flex-col items-center">

        <div class="w-32 h-32 p-1 rounded-full flex justify-center items-center bg-pink-500 mt-8 mb-4">
            <img
            :src="image?image : user.avatar ? '/storage/avatars/'+user.id+'.jpg' : '/storage/avatars/noavatar.jpg'"
            class="max-w-32 max-h-32 rounded-full "
            >
        </div>

        <div class="flex flex-col text-left w-full divide-y divide-gray-600">
            <Link
            v-for="m in menuItems"
            :key="m"
            class="py-2 flex items-center"
            :class="{['text-pink-500']:m.active}"
            :href="m.route"
            >
            <SvgIcon
                :name="m.icon"
                size="24"
                class="mr-2"
            />
            {{m.name}}
            </Link>
        </div>
    </div>
</template>

<script>
import { onMounted, onUnmounted, ref } from 'vue'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import SvgIcon from '@/Components/SvgIcon';

export default {
    components: {
        Link,
        SvgIcon
    },
    props: {
        image: {
            type: String,
            default: null
        }
    },
    setup() {
        const user = usePage().props.value.user;
        const menuItems = ref([
            // {
            //     icon: '',
            //     name: 'Pulpit',
            //     route: route('main')
            // },
            {
                icon: 'email',
                name: 'Czat',
                route: route('main'),
                active: route().current('main')
            },
            {
                icon: 'image',
                name: 'Zdjęcia',
                route: route('images'),
                active: route().current('images')
            },
            {
                icon: 'calendar',
                name: 'Wydarzenia',
                route: route('events'),
                active: route().current('events')
            },
            {
                icon: 'settings',
                name: 'Ustawienia',
                route: route('settings'),
                active: route().current('settings')
            },
        ])

        return {
            menuItems,
            user
        }
    },
}
</script>
