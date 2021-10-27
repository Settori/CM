<template>
    <MainLayout :image="croppedImage?croppedImage:null">
        <div class="flex flex-col px-6 pt-6">
            <div class="flex">
            <input
            class="w-full"
            type="text"
            v-model="user.name"
            >
            <div class="bg-green-700 text-white flex items-center px-6 cursor-pointer" @click="saveUser()">Zapisz</div>
            </div>
            <div>
                <div v-if="!mainImage" class="px-8">
                    <label
                    for="files"
                    class="block w-full md: py-3 lg:py-5 border-2 text-lg font-bold my-5 transition-all cursor-pointer text-center text-green-700 border-green-700 dark:border-green-500 dark:text-green-500 hover:text-white hover:bg-green-700"
                    >
                    Zmień avatar</label>

                    <input type="file" class="hidden" name="filess" id='files' @change="onFileChange(mainImage, $event)">
                </div>
                <div v-else class="">
                    <div class="">
                        <CropImg
                        :img="mainImage"
                        @imagesUploaded="cropImage($event)"
                        class="h-full max-h-screen w-full"
                        :ratio="1"
                        />
                    </div>
                    <div class="fixed z-40 top-8">
                    <div class="grid grid-cols-2 gap-4 px-8">
                        <button @click="removeImage(mainImage)"
                        class="w-full md:py-3 lg:py-5 px-4 border-2 text-lg font-bold my-5 transition-all cursor-pointer text-center text-red-700 border-red-700 hover:text-white hover:bg-red-700"
                        >Usuń</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>


<script>
import MainLayout from '@/Layouts/Main';
import SvgIcon from '@/Components/SvgIcon';
import Pagination from '@/Components/Pagination';
import {onMounted, ref} from 'vue';
import { iconPath } from '@/common/helper';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { Cropper } from 'vue-advanced-cropper';
import CropImg from '@/Components/Cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
    components: {
        MainLayout,
        SvgIcon,
        Cropper,
        Pagination,
        Link,
        CropImg
    },
    props: {
        images: [Array, Object],
        user: [Array, Object],
    },
    methods: {
        iconPath
    },
    setup(props) {
        const mainImage = ref(null);
        const croppedImage = ref(null);

        const onFileChange = (item, e) => {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            createImage(item, files[0]);
        }
        const createImage = (item, file) => {
            var image = new Image();
            var reader = new FileReader();

            reader.onload = (e) => {
                mainImage.value = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        const removeImage = (item) => {
            mainImage.value = null;
        }

        const cropImage = (e) => {
            croppedImage.value = e
        }

        const saveUser = () => {
            Inertia.post(route('edit.user'), {
                image: croppedImage.value,
                user: props.user,
            }, {
                onSuccess: function() {
                    mainImage.value = null
                }
            })
        }
        return {
            mainImage,
            onFileChange,
            createImage,
            removeImage,
            croppedImage,
            cropImage,
            saveUser
        }
    }
}
</script>
