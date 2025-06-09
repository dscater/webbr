import { onMounted, ref } from "vue";

const oMunicipio = ref({
    id: 0,
    nombre: "",
    fecha_registro: "",
    _method: "POST",
});

export const useMunicipios = () => {
    const setMunicipio = (item = null) => {
        if (item) {
            oMunicipio.value.id = item.id;
            oMunicipio.value.nombre = item.nombre;
            oMunicipio.value.fecha_registro = item.fecha_registro;
            oMunicipio.value._method = "PUT";
            return oMunicipio;
        }
        return false;
    };

    const limpiarMunicipio = () => {
        oMunicipio.value.id = 0;
        oMunicipio.value.nombre = "";
        oMunicipio.value.fecha_registro = "";
        oMunicipio.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oMunicipio,
        setMunicipio,
        limpiarMunicipio,
    };
};
