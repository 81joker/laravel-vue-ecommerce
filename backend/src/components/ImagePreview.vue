<template>
    <div>
        <div class="flex flex-wrap gap-1">
            <div
                v-for="(image) in imageUrl"
                :key="image"
                class="relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed overflow-hidden hover:border-purple-500 hover:bg-gray-100 cursor-pointer"
            >
                <img :src="image.url" class="w-full h-full object-cover" />
                <!-- @click="deleteImage(index)" -->
                <button
                    @click="deleteImage(image)"
                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                    X
                </button>
            </div>
        </div>
        <div
            class="mt-2 relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed overflow-hidden hover:border-purple-500 hover:bg-gray-100 cursor-pointer"
        >
            <span> Upload </span>
            <input
                type="file"
                @change="onFileChange"
                accept="image/*"
                class="absolute left-0 top-0 bottom-0 right-0 w-full h-full"
            />
        </div>
    </div>
</template>
<script setup>
// Import
import { ref, onMounted } from "vue";
import { v4 as uuidv4 } from "uuid";

// Users
const props = defineProps(["modelValue"]);
// Props
// const props = defineProps({
//     modelValue: {
//         type: Array,
//         default: () => []
//     }
// });

// Emits
const emit = defineEmits(["update:modelValue"]);
// Data
// const props =defineProps({
//     images: {
//         type: Array,
//         default: () => []
//     }
// });
// Refe
const files = ref([]);
const imageUrl = ref([]);

// Methods
function onFileChange(e) {
    files.value = [...files.value, ...e.target.files];
    for (let file of e.target.files) {
        file.id = uuidv4();        
        readFile(file).then((url) => {
            imageUrl.value.push({ 
                id: file.id, 
                url 
            });
        });
    }
    emit("update:modelValue", files.value);
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

function deleteImage(image) {
    console.log(image.id ,"image id");
    //    // This is the First(1) way to delete the image
    files.value = files.value.filter((file) => file.id !== image.id);
    imageUrl.value = imageUrl.value.filter((img) => img.id !== image.id);
    emit("update:modelValue", files.value);

   //    // This is the Second(2) way to delete the image
    // const index = imageUrl.value.findIndex((img) => img.id === image.id);
    // if (index !== -1) {
    //     imageUrl.value.splice(index, 1);
    //     files.value.splice(index, 1);
    //     emit("update:modelValue", files.value);
    // }
}

 ////// This is the Third(3) way to delete the image
// /////  This funtion also is very helpful to delete the image /////////////////
//  function deleteImage(index) {
//      imageUrl.value.splice(index, 1);
//      files.value.splice(index, 1);
//      emit('update:modelValue', files.value);
//  }

//  HOOk
onMounted(() => {
    emit("update:modelValue", []);
    //  if (props.modelValue.length > 0) {
    //      imageUrl.value = [...imageUrl.value, ...props.modelValue];
    //  }
});
</script>
