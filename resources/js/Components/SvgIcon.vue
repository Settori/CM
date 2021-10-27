<template>
    <svg xmlns="http://www.w3.org/2000/svg"
        :fill="color ? color : 'currentColor'"
        :width="width ? width : (width === null ? null : (size ? size : 26))"
        :height="height ? height : (height === null ? null : (size ? size : 26))"
        ref="svgIcon"
        v-html="iconPath(name)"
        @click="$emit('even-click', $event)"
        :viewBox="viewBox ? viewBox : '0 0 20 20'"
    >
    </svg>
</template>

<script>
// Strona do prawidłowych ikonek !! Prosze ich używac !! ===> https://heroicons.com/
import { iconPath } from '@/common/helper';
export default {
    props: ['color', 'path', 'width', 'height', 'name', 'extraClass', 'arrowSize', 'viewBox', 'stroke', 'size'],

    methods: {
        iconPath,
    },
}
</script>

