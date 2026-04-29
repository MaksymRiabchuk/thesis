import {watch, onMounted} from 'vue';
import {usePage} from '@inertiajs/vue3';
import {PageProps} from '@/types';
import {useToast} from "vue-toast-notification";

export function useFlashMessages() {
    const page = usePage<PageProps>();
    const toast = useToast({
        position: "top-right",
        duration:3000,
        pauseOnHover:true,
        dismissible:true,
    });
    const showMessages = () => {
        const flash = page.props.flash;

        if (flash.success) {
            toast.success(flash.success);
        }

        if (flash.error) {
            toast.error(flash.error);
        }
    };

    watch(
        () => page.props.flash,
        () => showMessages(),
        {deep: true}
    );

    onMounted(() => showMessages());
}