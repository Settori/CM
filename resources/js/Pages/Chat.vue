<template>
    <MainLayout>
        <div class="h-screen flex flex-col">
            <div id="chat-container" class="h-full overflow-y-auto overflow-x-hidden bg-gray-600 py-4">
                <div
                v-for="(message, key) in messages"
                :key="key"
                >
                    <div
                    class="col-start-1 col-end-8 px-3 rounded-lg"
                    :class="messages[key - 1] && messages[key - 1].user_id == message.user_id ? 'pt-1':'pt-4'"
                    v-if="user.id != message.user_id"
                    >
                        <div class="flex flex-row items-center">
                        <img
                        v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                        :src="message.user.avatar ? '/storage/avatars/'+message.user.id+'.jpg' : '/storage/avatars/noavatar.jpg'"
                        class="h-10 w-10 rounded-full border-2 border-gray-800 flex-shrink-0">
                        <div v-else class="w-10"></div>

                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                            <div
                            class="" v-html="formatDate(message.created_at)"
                            v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                            ></div>
                            <div>
                            {{message.content}}
                            </div>
                        </div>
                        </div>
                    </div>
                    <div
                    class="col-start-6 col-end-13 px-3 rounded-lg"
                    :class="messages[key - 1] && messages[key - 1].user_id == message.user_id ? 'pt-1':'pt-4'"
                    v-else
                    >
                        <div class="flex items-center justify-start flex-row-reverse">
                        <img
                        v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                        :src="message.user.avatar ? '/storage/avatars/'+message.user.id+'.jpg' : '/storage/avatars/noavatar.jpg'"
                        class="flex items-center justify-center border-2 border-gray-800 h-10 w-10 rounded-full flex-shrink-0">
                        <div v-else class="w-10"></div>
                        <div class="relative mr-3 text-sm bg-blue-100 py-2 px-4 shadow rounded-xl">
                            <div
                            class="" v-html="formatDate(message.created_at)"
                            v-if="!(messages[key - 1] && messages[key - 1].user_id == message.user_id)"
                            ></div>
                            <div>{{message.content}}</div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <input
                    name="message"
                    type="text"
                    v-model="content"
                    class="w-full"
                    v-on:keyup.enter="sendMessage()"
                />
                <div
                class="bg-pink-700 text-white px-4 py-1 flex items-center cursor-pointer"
                @click="sendMessage()"
                >
                    Send
                </div>
                <div
                class="bg-indigo-700 text-white px-4 py-1 flex items-center"
                @click="reloadPage()"
                >
                    Reload
                </div>
            </div>
        </div>
    </MainLayout>
</template>


<script>
import MainLayout from '@/Layouts/Main';
import {nextTick, onMounted, ref} from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import TimeAgo from "vue3-timeago";


export default {
    components: {
        MainLayout,
        TimeAgo
    },
    props: {
        messages: [Object, Array]
    },
    setup(props) {
        const content = ref(null);
        const user = usePage().props.value.user;
        const reloadPage = () => {
            axios.post(route('reload.page'))
        }
        const sendMessage = () => {
            if (content.value) {
                let bufContent = content.value;
                content.value = null;
                axios.post(route('send.message'), {
                    'message': bufContent
                })

            }
        }

        const formatDate = (date) => {
            return moment(date).format('DD.MM.YYYY HH:mm')
        }
        onMounted(() => {
            var objDiv = document.getElementById("chat-container");
            objDiv.scrollTop = objDiv.scrollHeight;
            Echo.channel('test')
            .listen('.message.created', (e) => {
                props.messages.push({
                    content: e.content,
                    user: e.user,
                    created_at: moment().format(),
                    updated_at: moment().format(),
                    user_id: e.user.id
                });
                nextTick(() => {
                var objDiv = document.getElementById("chat-container");
                objDiv.scrollTop = objDiv.scrollHeight;
                })
            }).listen('.reload.page', (e) => {
                location.reload();
            });
        })
        return {
            sendMessage,
            content,
            formatDate,
            reloadPage,
            user
        }
    }
}
</script>
