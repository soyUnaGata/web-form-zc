<template>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050; right: 0; top: 0;">
        <div class="toast align-items-center text-white bg-primary border-0" :class="{ 'show': visible, 'bg-danger': isError }" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ message }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="hide"></button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onBeforeUnmount } from 'vue';

export default {
    setup() {
        const visible = ref(false);
        const message = ref('');
        const isError = ref(false);

        const log = (msg) => {
            isError.value = false;
            show(msg);
        };

        const error = (msg) => {
            isError.value = true;
            show(msg);
        };

        const show =  (msg) => {
            message.value = msg;
            visible.value = true;

            setTimeout(() => {
                visible.value = false;
            }, 5000);
        };

        const hide = () => {
            visible.value = false;
        };

        onBeforeUnmount(() => {
            visible.value = false;
        });

        return {
            visible,
            message,
            isError,
            log,
            error,
            hide
        };
    }
};
</script>
