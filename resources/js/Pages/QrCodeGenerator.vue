<template>
    <Head title="QrCode" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Qr-Code
            </h2>
        </template>

        <div class="py-12 flex flex-wrap">
            <div class="flex-auto lg:w-1/2 w-11/12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tigjt">
                            Generate with JS:
                        </h3>
                        <hr>
                        <div class="my-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="url">
                                Url
                            </label>
                            <input
                                id="url"
                                type="text"
                                v-model="jsUrl"
                                placeholder="http://example-url.com/"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            >
                        </div>
                        <button @click="onSubmit('JS')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Generate
                        </button>
                        <div class="mx-auto w-8/12 mt-4">
                            <div ref="qrcodeJs"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-auto lg:w-1/2 w-11/12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                            Generate with PHP:
                        </h3>
                        <hr>
                        <div class="my-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="url">
                                Url
                            </label>
                            <input
                                id="url"
                                type="text"
                                v-model="phpUrl"
                                placeholder="http://example-url.com/"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            >
                        </div>
                        <button @click="onSubmit('PHP')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Generate
                        </button>

                        <div class="mx-auto w-8/12 mt-4">
                            <div ref="qrcodePhp"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    data() {
        return {
            jsUrl: null,
            phpUrl: null
        };
    },
    methods: {
        onSubmit(type) {
            if (type === 'JS') {
                return this.generateJs(this.jsUrl);
            }

            return this.generatePhp(this.phpUrl);
        },
        generateJs(url) {
            const qrCodeJS = new QRCode(this.$refs.qrcodeJs, {
                width: 220,
                height: 220,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H,
            });

            qrCodeJS.makeCode(url);
        },
        generatePhp(url) {
            return this.sendRequest(url);
        },
        sendRequest(url) {
            axios.post('/generate', { url }).then(res => {
                this.$refs.qrcodePhp.innerHTML = res.data.qrcode;
            });
        }
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>

<style>

</style>
