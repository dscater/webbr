import { onMounted, ref } from "vue";

const oPreventa = ref({
    id: 0,
    terreno_id: "",
    cliente_id: "",
    descripcion: "",
    estado: "",
    _method: "POST",
});

export const usePreventas = () => {
    const setPreventa = (item = null) => {
        if (item) {
            oPreventa.value.id = item.id;
            oPreventa.value.terreno_id = item.terreno_id;
            oPreventa.value.cliente_id = item.cliente_id;
            oPreventa.value.descripcion = item.descripcion;
            oPreventa.value.estado = item.estado;
            oPreventa.value._method = "PUT";
            return oPreventa;
        }
        return false;
    };

    const limpiarPreventa = () => {
        oPreventa.value.id = 0;
        oPreventa.value.terreno_id = "";
        oPreventa.value.cliente_id = "";
        oPreventa.value.descripcion = "";
        oPreventa.value.estado = "";
        oPreventa.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oPreventa,
        setPreventa,
        limpiarPreventa,
    };
};
