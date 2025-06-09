import { onMounted, ref } from "vue";

const oUrbanizacion = ref({
    id: 0,
    municipio_id: "",
    nombre: "",
    fecha_registro: "",
    _method: "POST",
});

export const useUrbanizacions = () => {
    const setUrbanizacion = (item = null) => {
        if (item) {
            oUrbanizacion.value.id = item.id;
            oUrbanizacion.value.municipio_id = item.municipio_id;
            oUrbanizacion.value.nombre = item.nombre;
            oUrbanizacion.value.fecha_registro = item.fecha_registro;
            oUrbanizacion.value._method = "PUT";
            return oUrbanizacion;
        }
        return false;
    };

    const limpiarUrbanizacion = () => {
        oUrbanizacion.value.id = 0;
        oUrbanizacion.value.municipio_id = "";
        oUrbanizacion.value.nombre = "";
        oUrbanizacion.value.fecha_registro = "";
        oUrbanizacion.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oUrbanizacion,
        setUrbanizacion,
        limpiarUrbanizacion,
    };
};
