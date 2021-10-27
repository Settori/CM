<template>
    <MainLayout>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 p-4 gap-4">
            <div
            class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg bg-gray-700 text-white border-b-4 border-gray-800 flex items-center justify-between"
            v-for="d in duties"
            :key="d"
            >
                <div class="flex flex-col ">
                    <span class="text-gray-300 ">{{d.name}}</span>
                    <span class="text-xl font-semibold">{{d.points.length}}</span>
                    <div>
                        <span class="inline-block px-2 text-sm text-white bg-pink-700 rounded">{{d.points.length * d.value}}</span>
                        <span class="ml-2">punktów</span>
                    </div>
                </div>
                <div
                class="p-3 bg-gray-200 hover:bg-gray-50 rounded-full group cursor-pointer"
                @click="addPoint(d.id)"
                >
                    <SvgIcon
                    name="plus"
                    width="30"
                    height="30"
                    class="text-pink-800 group-hover:text-pink-600"

                    />
                </div>
            </div>
            <div
            class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg bg-gray-700 text-white border-b-4 border-gray-800 flex items-center justify-between"
            >
                <div class="flex flex-col ">
                    <span class="text-gray-400 ">Łącznie</span>
                    <span class="text-xl font-semibold select-none"> </span>
                    <div>
                        <span class="inline-block px-2 text-sm text-white bg-pink-700 rounded">{{sumPoints()}}</span>
                        <span class="ml-2">punktów</span>
                    </div>
                </div>
                <div
                class="p-3 bg-gray-200 rounded-full"
                @click="addPoint(d.id)"
                >
                    <SvgIcon
                    name="chart-bar"
                    width="30"
                    height="30"
                    class="text-pink-800"

                    />
                </div>
            </div>
        </div>

        <div class="mt-4 mx-4">
            <div class="bg-gray-700 px-4 py-1.5 text-white rounded-t-md">Ostatnie punkty</div>
            <div class="bg-white overflow-hidden rounded-b-md border border-t-0 border-gray-400 rounded-t-none">
                <div
                v-for="p in points.data"
                :key="p"
                class="border-b border-gray-200 py-2 px-4 flex justify-between"
                >
                <div>{{p.duty.name}}</div>
                <div
                class="hover:bg-gray-500 bg-gray-700  text-white rounded-md py-0.5 px-3 text-xs uppercase flex items-center cursor-pointer"
                @click="removePoint(p.id)"
                >Usuń</div>
                </div>
                <div class="px-4 py-1 flex justify-center">
                    <Pagination class="mt-2" :links="points.links"/>
                </div>
            </div>

        </div>
    </MainLayout>
</template>


<script>
import MainLayout from '@/Layouts/Main';
import SvgIcon from '@/Components/SvgIcon';
import Pagination from '@/Components/Pagination';
import {onMounted} from 'vue';
import { iconPath } from '@/common/helper';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        MainLayout,
        SvgIcon,
        Pagination,
        Link
    },
    props: {
        duties: [Array, Object],
        points: [Array, Object],
    },
    methods: {
        iconPath
    },
    setup(props) {
        const sumPoints = () => {
            let sum = 0;
            props.duties.forEach((d) => {
                sum += d.value * d.points.length
            })
            return sum
        }
        const addPoint = (id) => {
            Inertia.post(route('add.point', id))
        }

        const removePoint = (id) => {
            Inertia.post(route('remove.point', id))
        }


        onMounted(() => {
            console.log("yea")
            Echo.channel('testchannel')
            .listen('.message.created', (e) => {

            });
        })

        return {
            addPoint,
            sumPoints,
            removePoint
        }
    }
}
</script>
