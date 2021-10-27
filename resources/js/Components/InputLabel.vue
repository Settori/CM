<template>

    <div
        class="flex flex-col"
    >
        <label
            v-if="label"
            :for="id"
            class="mb-2 dark:text-white"
        >{{label}}</label>

        <textarea
            :ref='ev=>{input=ev}'
            v-if="type == 'textarea'"
            :id="id"
            class="bg-white dark:bg-gray-300 dark:border-gray-600 border-gray-400 dark:hover:border-gray-700 hover:border-gray-500 focus:border-green-500 dark:focus:border-green-600 rounded-none border-0 px-4 py-2 outline-none focus:outline-none focus:ring-0"
            :class="{['h-'+height]:true, ['border-b-2']:border}"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-on:blur="$emit('update:unfocus')"
            :placeholder="placeholder"
            :name="name"
        ></textarea>

        <input
            :ref='ev=>{input=ev}'
            v-else
            :type="type"
            :id="id"
            class="bg-white dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 border-gray-400 dark:hover:border-gray-700 hover:border-gray-500 focus:border-green-500 dark:focus:border-green-600 rounded-none border-0 px-4 py-2 outline-none focus:outline-none focus:ring-0"
            :class="{['border-b-2']:border, ['border-red-500 focus:border-red-600 focus:ring-offset-red-200 is-invalid'] : errorMessage,
                ['border-gray-300 focus:border-gray-400 focus:ring-offset-gray-300'] : !errorMessage}"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :autofocus="autofocus"
            :name="name"
            :autocomplete="autocomplete ? 'on':'off'"
            v-on:blur="$emit('update:unfocus')"
        >
    </div>
    <div class="text-red-500 text-xs font-bold" v-if="errorMessage">{{ Array.isArray(errorMessage) ? errorMessage[0] : errorMessage }}</div>
</template>

<script>
    import { ref } from '@vue/reactivity';
    import { computed, nextTick, onMounted, watch } from '@vue/runtime-core';
    import { usePage } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            type: {
                type: String,
                default: 'text'
            },
            modelValue: [String, Number],
            id: {
                type: String,
                default: null
            },
            label: {
                type: String,
                default: null
            },
            placeholder: {
                type: String,
                default: null
            },
            name: {
                type: String,
                default: null
            },
            height: {
                type: String,
                default: '56'
            },
            errors: {
                type: [Object, Array],
                default: null
            },
            autofocus: {
                type: String,
                default: null
            },
            border: {
                type: Boolean,
                default: true
            },
            autocomplete: {
                type: Boolean,
                default: true
            },
            error: [String, Array, Boolean],
        },

        emits: ['update:modelValue', 'update:unfocus', 'update', 'change'],

        // methods: {
        //     focus() {
        //         this.$refs.input.focus()
        //     }
        // },
        setup(props){
            const input = ref(null);
            const errorMessage = ref(props.error);
            watch( () => props.errors, (error, oldError) => {
                if(props.errors[props.name]) errorMessage.value = props.errors[props.name];//error[props.name ? props.name : props.id];
            })

            return {
                errorMessage,
                input
            }
        }
    }
</script>

