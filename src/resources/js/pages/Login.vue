<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
        >
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                    >
                        Sign in to your account
                    </h1>

                    <fwb-alert border type="danger" v-if="errorLogin.isError">
                        {{ errorLogin.errorMessage }}
                    </fwb-alert>

                    <form class="space-y-4 md:space-y-6">
                        <fwb-input
                            v-model="email"
                            required
                            placeholder="enter your email address"
                            label="Email"
                            validation-status=""
                        />
                        <fwb-input
                            v-model="password"
                            required
                            placeholder="enter your password"
                            label="Password"
                            type="password"
                            validation-status=""
                        >
                            <template #validationMessage> </template>
                        </fwb-input>
                        <fwb-button
                            class="w-full"
                            color="default"
                            size="lg"
                            type="button"
                            @click="doLogin"
                        >
                            Login
                        </fwb-button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="js" setup>
import { onMounted, reactive, ref } from "vue";
import { useRouter } from 'vue-router';
import { FwbInput, FwbButton, FwbAlert } from "flowbite-vue";

const email = ref("");
const password = ref("");
const errorLogin = reactive({
    isError: "",
    errorMessage: "",
});

const router = useRouter();

import { apiLogin } from "../api/auth";
import { setCookie, getCookie } from "../lib/cookie";

onMounted(() => {
    if (getCookie('refresh_token')) {
        router.push({ name: "reminders" });
    }
});

const doLogin = () => {
    apiLogin(email.value, password.value)
        .then((response) => {
            const data = response.data.data;
            const sevenDaysInSeconds = 7 * 24 * 60 * 60;

            setCookie('refresh_token', data.refresh_token, sevenDaysInSeconds);
            setCookie('access_token', data.access_token, 20);

            router.push({ name: "reminders" });
        })
        .catch((error) => {
            showAlertLogin(error.response.data.msg);
        });
}

const showAlertLogin = (message) => {
    errorLogin.isError = true;
    errorLogin.errorMessage = message;

    setTimeout(() => {
        errorLogin.isError = false;
        errorLogin.errorMessage = "";
    }, 3000);
}
</script>
