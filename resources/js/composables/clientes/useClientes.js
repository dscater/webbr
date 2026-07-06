import { onMounted, ref } from "vue";

const oCliente = ref({
    id: 0,
    nombre: "",
    paterno: "",
    materno: "",
    ci: "",
    ci_exp: "",
    fono: "",
    correo: "",
    dir: "",
    calificacion: null,
    _method: "POST",
});

export const useClientes = () => {
    const setCliente = (item = null) => {
        if (item) {
            oCliente.value.id = item.id;
            oCliente.value.nombre = item.nombre;
            oCliente.value.paterno = item.paterno;
            oCliente.value.materno = item.materno;
            oCliente.value.ci = item.ci;
            oCliente.value.ci_exp = item.ci_exp;
            oCliente.value.fono = item.fono;
            oCliente.value.correo = item.correo;
            oCliente.value.dir = item.dir;
            oCliente.value._method = "PUT";
            return oCliente;
        }
        return false;
    };

    const limpiarCliente = () => {
        oCliente.value.id = 0;
        oCliente.value.nombre = "";
        oCliente.value.paterno = "";
        oCliente.value.materno = "";
        oCliente.value.ci = "";
        oCliente.value.ci_exp = "";
        oCliente.value.fono = "";
        oCliente.value.correo = "";
        oCliente.value.dir = "";
        oCliente.value.calificacion = null;
        oCliente.value._method = "POST";
    };

    onMounted(() => {});

    return {
        oCliente,
        setCliente,
        limpiarCliente,
    };
};
