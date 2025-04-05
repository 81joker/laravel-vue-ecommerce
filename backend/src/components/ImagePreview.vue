<template>
   <div>
<div class="flex flex-wrap gap-1">
    <div v-for="(image, index) in imageUrl" :key="index" class="relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed  overflow-hidden
        hover:border-purple-500 hover:bg-gray-100 cursor-pointer">
            <img :src="image" class="w-full h-full object-cover" />
            <!-- <button @click="deleteImage(index)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                X
            </button> -->

        </div>
</div>
        <div class="mt-2 relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed  overflow-hidden
        hover:border-purple-500 hover:bg-gray-100 cursor-pointer">
            <span>
                Upload
            </span>
            <input type="file" @change="onFileChange" accept="image/*" class="absolute left-0 top-0 bottom-0 right-0 w-full h-full" />
        </div>
   </div>
</template>
<script setup>
// Import
import {ref} from 'vue'
// Users


// Refe
const files = ref([]);
const imageUrl = ref([]);

// Methods
function onFileChange(e) {
    files.value = [...files.value,...e.target.files];
    for (let file of e.target.files) {
        readFile(file)
        .then((url) => {
            imageUrl.value.push(url);
        })

    }
    }

function readFile(file) {
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = (e) => {
            resolve(e.target.result);
        };
        fileReader.onerror = (e) => {
            reject(e);
        };
    });
}
</script>
