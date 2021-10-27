<template>
    <div class="grid grid-cols-3 bg-gray-800 text-white h-screen gap-4 px-4 py-6">
        <div class="mt-6">
            <div class="grid grid-cols-2 gap-4">
                <div
                class="bg-gray-200 rounded-md text-gray-900 p-4 border-b-4 border-gray-900 text-center flex flex-col justify-between"
                >
                <div class="text-4xl">{{time}}</div>
                <div class="text-lg"> {{getDay()}}</div>
                </div>
                <div
                class="bg-gray-200 rounded-md text-gray-900 p-4 border-b-4 border-gray-900 text-center flex flex-col justify-between"
                >
                <div class="flex justify-between items-center">
                    <div class=""><img class="w-12 max-h-12 max-w-12 filter brightness-0" :src="icon"></div>
                    <div class="text-4xl">{{temp}}&#8451;</div>
                </div>
                <div class="">Odczuwalna: {{feels_like}}&#8451;</div>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center bg-gray-200 rounded-md text-gray-900 px-4 py-2 border-b-4 border-gray-900">
                <div>
                    <div>W ten weekend sprząta:</div>
                    <div class="uppercase font-semibold mt-1">{{week.user.name}}</div>
                </div>
                <div class="w-16 h-16 rounded-full flex items-center justify-center p-1 bg-gray-700">
                    <img
                    :src="week.user.avatar ? '/storage/avatars/'+week.user.id+'.jpg' : '/storage/avatars/noavatar.jpg'"
                    class="max-w-16 max-h-16 rounded-full"
                    >
                </div>
            </div>

            <div
            class="mt-4 flex justify-between items-center bg-gray-200 rounded-md text-gray-900 px-4 py-2 border-b-4 border-gray-900"
            v-if="refEvent"
            >
                <div>
                    <div>Najbliższe wydarzenie:</div>
                    <div class="font-semibold mt-1">{{refEvent.name}}</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="font-semibold text-lg">{{formatDate(refEvent.date, 'HH:mm')}}</div>
                    <div>{{formatDate(refEvent.date, 'fancy')}}</div>
                </div>
            </div>

            <div id="chat-container" class="overflow-x-hidden text-gray-800">
                <div
                v-for="(message, key) in messages"
                :key="key"
                >
                    <div
                    class="col-start-1 col-end-8 px-3 rounded-lg"
                    :class="messages[key - 1] && messages[key - 1].user_id == message.user_id ? 'pt-1':'pt-4'"
                    >
                        <div class="flex flex-row items-center">
                        <img
                        v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                        :src="message.user.avatar ? '/storage/avatars/'+message.user.id+'.jpg' : '/storage/avatars/noavatar.jpg'"
                        class="h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                        <div v-else class="w-10"></div>

                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                            <div
                            class="" v-html="formatDate(message.created_at, 'DD.MM.YYYY HH:mm')"
                            v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                            ></div>
                            <div>
                            {{message.content}}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-full overflow-hidden flex flex-col col-span-2">
            <div class="max-h-full relative">
                <img class="w-full" :src="'/storage/images/'+imageRef+'.jpg'">
                <div class="absolute top-3 right-3 border-2 border-pink-700 rounded-full text-pink-900 bg-white font-bold w-8 h-8 flex items-center justify-center">{{timeCounter}}</div>
            </div>
        </div>
    </div>
</template>


<script>
import MainLayout from '@/Layouts/Main';
import SvgIcon from '@/Components/SvgIcon';
import Pagination from '@/Components/Pagination';
import {onMounted, ref} from 'vue';
import { iconPath } from '@/common/helper';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';


export default {
    components: {
        MainLayout,
        SvgIcon,
        Pagination,
        Link
    },
    props: {
        week: [Object, Array],
        messages: [Object, Array],
        event: [Object, Array],
        image: [String],
    },
    methods: {
        iconPath
    },
    setup(props) {
        const timeCounter = ref(10);
        const weather = ref(null);
        const temp = ref(null);
        const refEvent = ref(props.event);
        const icon = ref(null);
        const feels_like = ref(null);
        const imageRef = ref(props.image);
        const time = ref(new Date().getHours() + ':' + new Date().getMinutes());
        const getDate = () => {
            const date = new Date();
            let minutes = date.getMinutes() > 9 ? date.getMinutes() : '0' + date.getMinutes()
            // let seconds = date.getSeconds() > 9 ? date.getSeconds() : '0' + date.getSeconds()
            time.value = date.getHours() + ':' + minutes
        };

        const getWeather = () => {
            axios.post(route('get.weather'), {

            }).then(response => {
                // console.log(response)
                temp.value = Math.round(response.data.main.temp*2)/2;
                icon.value = '/img/icons/'+response.data.weather[0].icon+'.png';
                feels_like.value = Math.round(response.data.main.feels_like*2)/2;
                weather.value = response.data.weather[0].description;
            })
        }

        const getDay = () => {
            moment.locale('pl')
            return moment().format('dddd')
        }

        const getImage = () => {
            axios.post(route('get.image')).then(response => {
                console.log(response.data)
                imageRef.value = response.data
            })
        }

        const formatDate = (date, format) => {
            moment.locale('pl')
            if (format == 'fancy') {
                if (moment(date).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')) return 'dzisiaj';
                else if (moment(date).format('YYYY-MM-DD') == moment().add(1, 'd').format('YYYY-MM-DD')) return 'jutro';
                else if (moment(date).format('YYYY-MM-DD') <= moment().add(6, 'd').format('YYYY-MM-DD')) return moment(date).format('dddd');
                else return moment(date).format('YYYY-MM-DD')
            }
            else return moment(date).format(format)
        }

        const getEvent = () => {
            axios.post(route('get.event'), {
            }).then(response => {
                refEvent.value = response.data
            })
        }

        onMounted(() => {
            setInterval(() => {
                if (timeCounter.value <= 1) {
                    getImage()
                    timeCounter.value = 10;

                }
                else timeCounter.value -= 1;
            }, 1000);

            // Pogoda
            setInterval(() => {
                getWeather();
            }, 1000*120);

            // Wydarzenia
            setInterval(() => {
                getEvent();
            }, 1000);

            getWeather();
            setInterval(() => {getDate()}, 1000);
            Echo.channel('test')
            .listen('.message.created', (e) => {
                props.messages.shift();
                props.messages.push({
                    content: e.content,
                    user: e.user,
                    created_at: moment().format(),
                    updated_at: moment().format(),
                    user_id: e.user.id
                });
            }).listen('.reload.page', (e) => {
                location.reload();
            });;
        })

        return {
            getDate,
            formatDate,
            getImage,
            getWeather,
            weather,
            imageRef,
            temp,
            getDay,
            timeCounter,
            feels_like,
            icon,
            refEvent,
            time
        }
    }
}
</script>
