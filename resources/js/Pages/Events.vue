<template>
    <MainLayout>
        <div class="flex flex-col px-6 pt-6">
            <div class="text-xl mb-2">Dodaj nowe wydarzenie</div>
            <div class="grid grid-cols-5 gap-2">
                <div class="col-span-2">
                    <InputLabel
                        type="text"
                        name="name"
                        :errors="errors"
                        v-model="eventForm.name"
                        placeholder="Nazwa wydarzenia"
                    />
                </div>
                <InputLabel
                    type="date"
                    name="date"
                    :errors="errors"
                    v-model="eventForm.date"
                />
                <InputLabel
                    type="time"
                    name="time"
                    :errors="errors"
                    v-model="eventForm.time"
                />
                <div
                class="bg-pink-700 text-white flex items-center justify-center uppercase rounded-full h-10"
                @click="addEvent()"
                >Dodaj</div>
            </div>

            <div class="min-w-max w-full table-auto rounded-md overflow-hidden shadow-sm mt-6">
                <div class="bg-gray-700 text-gray-100 uppercase text-sm leading-normal flex flex-row justify-between items-center">
                    <div class="py-3 pl-6">Wydarzenia</div>
                    <div class="py-3 pr-6">Akcje</div>
                </div>
                <div class="text-gray-600 text-sm font-light">
                    <div
                        v-for="(event, key) in events.data"
                        :key="key"
                        class="border-b border-gray-200 dark:border-gray-500 bg-white dark:bg-gray-600 dark:text-white qwehover:bg-gray-100  cursor-pointer"
                    >
                        <div
                        class="grid grid-cols-5 py-2 px-6"
                        >
                            <div class="font-bold col-span-3">{{event.name}}</div>
                            <div class="">{{event.date}}</div>
                            <div class="text-right flex justify-end">
                                <div @click="removeEvent(event.id)" class="mr-2 bg-red-800 text-white rounded-md px-4 py-0.5 cursor-pointer">Usuń</div>
                            </div>
                        </div>
                    </div>

                    <Pagination :links="events.links" class="flex justify-center py-2 bg-gray-100" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>


<script>
import MainLayout from '@/Layouts/Main';
import SvgIcon from '@/Components/SvgIcon';
import InputLabel from '@/Components/InputLabel';
import Pagination from '@/Components/Pagination';
import {onMounted, ref} from 'vue';
import { iconPath } from '@/common/helper';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import 'vue-advanced-cropper/dist/style.css';
import moment from 'moment';

export default {
    components: {
        MainLayout,
        SvgIcon,
        Link,
        InputLabel,
        Pagination
    },
    props: {
        events: [Array, Object],
        errors: [Array, Object],
    },
    methods: {
        iconPath
    },
    setup(props) {
        const eventForm = useForm({
            name: null,
            date: moment().format('YYYY-MM-DD'),
            time: moment().format('HH:mm')
        });

        const addEvent = () => {
            eventForm.post(route('add.event'))
        }

        const removeEvent = (id) => {
            Inertia.post(route('remove.event', id))
        }
        return {
            eventForm,
            removeEvent,
            addEvent
        }
    }
}
</script>
