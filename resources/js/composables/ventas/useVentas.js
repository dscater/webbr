import { onMounted, ref } from "vue";

const oVenta = ref({
    id: 0,
    terreno_id: "",
    preventa_id: "",
    descripcion: "",
    _method: "POST",
});

export const useVentas = () => {
    const setVenta = (item = null) => {
        if (item) {
            oVenta.value.id = item.id;
            oVenta.value.terreno_id = item.terreno_id;
            oVenta.value.preventa_id = item.preventa_id;
            oVenta.value.descripcion = item.descripcion;
            oVenta.value._method = "PUT";
            return oVenta;
        }
        return false;
    };

    const limpiarVenta = () => {
        oVenta.value.id = 0;
        oVenta.value.terreno_id = "";
        oVenta.value.preventa_id = "";
        oVenta.value.descripcion = "";
        oVenta.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oVenta,
        setVenta,
        limpiarVenta,
    };
};
