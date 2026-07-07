import { useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

export const useVentas = () => {
    const initialState = {
        id: 0,
        terreno_id: "",
        preventa_id: "",
        cliente_id: "",
        descripcion: "",
        sw_preventa: 1,
        _method: "POST",
    };

    const form = useForm({ ...initialState });

    const setVenta = (item = null) => {
        form.clearErrors();
        form.reset();
        Object.assign(form, item);
        form._method = "PUT";
    };

    const limpiarVenta = () => {
        form.clearErrors();
        form.reset();
        form.defaults({ ...initialState });
    };

    onMounted(() => {});

    return {
        form,
        setVenta,
        limpiarVenta,
    };
};
