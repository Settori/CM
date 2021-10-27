<template>
    <div v-if="img" class="">
        <Cropper
            class="cropper"
            :src="img"
            :stencil-props="{
            aspectRatio: ratio
            }"
            @change="change"
            :default-size="defaultSize"
        ></Cropper>
    </div>
</template>

<script>
    import { Cropper } from 'vue-advanced-cropper'
    import 'vue-advanced-cropper/dist/style.css';
    import { Inertia } from '@inertiajs/inertia'
    import { useForm } from '@inertiajs/inertia-vue3'
    import { ref, watch, onMounted } from 'vue';


	export default {
        data(){
            return{
                // To trzeba jakoś przesłać do backendu po wgraniu obrazka
                image: null
            }
        },
        props:{
            img:{
                type: String,
                default: null
            },
            ratio: {
                type: Number,
                default: 10/7
            }
        },
        methods: {

            change({coordinates, canvas}) {
                // przeskalowany obrazek:
                this.image = canvas.toDataURL()
                this.$emit('imagesUploaded', canvas.toDataURL())

            },
            defaultSize(imageSize, visibleArea) {
                return {
                    width: imageSize.imageSize.width,
                    height: imageSize.imageSize.height,
                };
		}

        },
        components: {
            Cropper
        },
        emits: ['imagesUploaded'],

	}
</script>
<style>
.cropper {
    height: 100%!important;
}
</style>
