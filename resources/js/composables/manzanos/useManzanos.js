import { onMounted, ref } from "vue";

const oManzano = ref({
    id: 0,
    municipio_id: "",
    urbanizacion_id: "",
    nombre: "",
    fecha_registro: "",
    _method: "POST",
});

export const useManzanos = () => {
    const setManzano = (item = null) => {
        if (item) {
            oManzano.value.id = item.id;
            oManzano.value.municipio_id = item.municipio_id;
            oManzano.value.urbanizacion_id = item.urbanizacion_id;
            oManzano.value.nombre = item.nombre;
            oManzano.value.fecha_registro = item.fecha_registro;
            oManzano.value._method = "PUT";
            return oManzano;
        }
        return false;
    };

    const limpiarManzano = () => {
        oManzano.value.id = 0;
        oManzano.value.municipio_id = "";
        oManzano.value.urbanizacion_id = "";
        oManzano.value.nombre = "";
        oManzano.value.fecha_registro = "";
        oManzano.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oManzano,
        setManzano,
        limpiarManzano,
    };
};
