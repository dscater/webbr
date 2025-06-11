<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useTerrenos } from "@/composables/terrenos/useTerrenos";
import { useAxios } from "@/composables/axios/useAxios";
import { watch, ref, computed, defineEmits, onMounted, nextTick } from "vue";
import MiDropZone from "@/Components/MiDropZone.vue";
const props = defineProps({
    open_dialog: {
        type: Boolean,
        default: false,
    },
    accion_dialog: {
        type: Number,
        default: 0,
    },
});

const { oTerreno, limpiarTerreno } = useTerrenos();
const { axiosGet } = useAxios();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oTerreno);
watch(
    () => props.open_dialog,
    async (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            const accesoCheckbox = $("#acceso");
            document
                .getElementsByTagName("body")[0]
                .classList.add("modal-open");
            form = useForm(oTerreno);
            if (form.id != 0) {
                cargarUrbanizacion();
                cargarManzanos();
            }
        }
    }
);
watch(
    () => props.accion_dialog,
    (newValue) => {
        accion.value = newValue;
    }
);

const { flash } = usePage().props;

const listMunicipios = ref([]);
const listUrbanizacions = ref([]);
const listManzanos = ref([]);
const listTipoCalle = ref([
    { value: "Pavimentada", label: "Pavimentada" },
    { value: "Loseta", label: "Loseta" },
    { value: "Empedrada", label: "Empedrada" },
    { value: "Grava", label: "Grava" },
    { value: "Tierra", label: "Tierra" },
]);
const listAnchoCalle = ref([
    { value: "Autopista", label: "Autopista" },
    { value: "Avenida", label: "Avenida" },
    { value: "Calle Local", label: "Calle Local" },
]);
const listConectividad = ref([
    { value: "Avenidas Principales", label: "Avenidas Principales" },
    { value: "Autopistas", label: "Autopistas" },
    { value: "Transporte Público", label: "Transporte Público" },
]);

const listFlujoVehicular = ref([
    { value: "Bajo", label: "Bajo" },
    { value: "Medio", label: "Medio" },
    { value: "Alto", label: "Alto" },
    { value: "Comercial", label: "Comercial" },
]);

const listTipoZona = ref([
    { value: "Residencial", label: "Residencial" },
    { value: "Comercial", label: "Comercial" },
    { value: "Industrial", label: "Industrial" },
    { value: "Rural", label: "Rural" },
    { value: "Mixta", label: "Mixta" },
]);

const listAreasVerdes = ref([
    { value: "Bajo", label: "Bajo" },
    { value: "Medio", label: "Medio" },
    { value: "Alto", label: "Alto" },
]);
const listNivelUrbanizacion = ref([
    { value: "Consolidado", label: "Consolidado" },
    { value: "En Crecimiento", label: "En Crecimiento" },
]);

const listTopografias = ref([
    { value: "Plano", label: "Plano" },
    { value: "En Pendiente", label: "En Pendiente" },
    { value: "Irregular", label: "Irregular" },
]);

const tituloDialog = computed(() => {
    return accion.value == 0
        ? `<i class="fa fa-plus"></i> Nuevo Terreno`
        : `<i class="fa fa-edit"></i> Editar Terreno`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("terrenos.store")
            : route("terrenos.update", form.id);

    form.post(url, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            dialog.value = false;
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: `${flash.bien ? flash.bien : "Proceso realizado"}`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
            limpiarTerreno();
            emits("envio-formulario");
        },
        onError: (err) => {
            console.log("ERROR");
            Swal.fire({
                icon: "info",
                title: "Error",
                text: `${
                    flash.error
                        ? flash.error
                        : err.error
                        ? err.error
                        : "Hay errores en el formulario"
                }`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
        },
    });
};

const emits = defineEmits(["cerrar-dialog", "envio-formulario"]);

watch(dialog, (newVal) => {
    if (!newVal) {
        emits("cerrar-dialog");
    }
});

const cerrarDialog = () => {
    dialog.value = false;
    document.getElementsByTagName("body")[0].classList.remove("modal-open");
};

const cargarListas = () => {
    cargarMunicipios();
};

const cargarMunicipios = async () => {
    const data = await axiosGet(route("municipios.listado"));
    listMunicipios.value = data.municipios;
};

const cargarUrbanizacion = async () => {
    const data = await axiosGet(route("urbanizacions.listadoPorMunicipio"), {
        id: form.municipio_id ?? 0,
    });
    listUrbanizacions.value = data.urbanizacions;
};

const cargarManzanos = async () => {
    const data = await axiosGet(
        route("manzanos.listadoPorMunicipioUrbanizacion"),
        {
            municipio_id: form.municipio_id ?? 0,
            urbanizacion_id: form.urbanizacion_id ?? 0,
        }
    );
    listManzanos.value = data.manzanos;
};

const detectaArchivos = (files) => {
    form.imagens = files;
};

const detectaEliminados = (eliminados) => {
    form.eliminados = eliminados;
};

onMounted(() => {
    cargarListas();
});
</script>

<template>
    <div
        class="modal fade"
        :class="{
            show: dialog,
        }"
        id="modal-dialog-form"
        :style="{
            display: dialog ? 'block' : 'none',
        }"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" v-html="tituloDialog"></h4>
                    <button
                        type="button"
                        class="btn-close"
                        @click="cerrarDialog()"
                    ></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="enviarFormulario()">
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label>Seleccionar Municipio/Ciudad*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.municipio_id,
                                    }"
                                    v-model="form.municipio_id"
                                    @change="cargarUrbanizacion"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listMunicipios"
                                        :value="item.id"
                                    >
                                        {{ item.nombre }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.municipio_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.municipio_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Seleccionar Urbanización*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.urbanizacion_id,
                                    }"
                                    v-model="form.urbanizacion_id"
                                    @change="cargarManzanos"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listUrbanizacions"
                                        :value="item.id"
                                    >
                                        {{ item.nombre }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.urbanizacion_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.urbanizacion_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Seleccionar Manzano*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.manzano_id,
                                    }"
                                    v-model="form.manzano_id"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listManzanos"
                                        :value="item.id"
                                    >
                                        {{ item.nombre }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.manzano_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.manzano_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Nombre Terreno*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.nombre,
                                    }"
                                    v-model="form.nombre"
                                />
                                <ul
                                    v-if="form.errors?.nombre"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.nombre }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <hr class="mb-1" />
                            <h4 class="w-100 text-center">
                                ESPECIFICACIONES DEL TERRENO
                            </h4>
                            <div class="col-md-4">
                                <label>Tipo de Calle*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.tipo_calle,
                                    }"
                                    v-model="form.tipo_calle"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listTipoCalle"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.tipo_calle"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.tipo_calle }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Ancho de Calle*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.ancho_calle,
                                    }"
                                    v-model="form.ancho_calle"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listAnchoCalle"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.ancho_calle"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.ancho_calle }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Conectividad*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.conectividad,
                                    }"
                                    v-model="form.conectividad"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listConectividad"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.conectividad"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.conectividad }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Tráfico y Flujo Vehicular*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error': form.errors?.trafico,
                                    }"
                                    v-model="form.trafico"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listFlujoVehicular"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.trafico"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.trafico }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Tipo de Zona*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error': form.errors?.tipo_zona,
                                    }"
                                    v-model="form.tipo_zona"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listTipoZona"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.tipo_zona"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.tipo_zona }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Servicios Básicos:</label
                                >
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Agua potable<input
                                                type="checkbox"
                                                v-model="form.agua_potable"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.agua_potable"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.agua_potable }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Alcantarillado<input
                                                type="checkbox"
                                                v-model="form.alcantarillado"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.alcantarillado"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors?.alcantarillado
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Energía Eléctrica<input
                                                type="checkbox"
                                                v-model="form.energia_electrica"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.energia_electrica
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.energia_electrica
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Gas Natural<input
                                                type="checkbox"
                                                v-model="form.gas_natural"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.gas_natural"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.gas_natural }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Alumbrado Público<input
                                                type="checkbox"
                                                v-model="form.alumbrado"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.alumbrado"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.alumbrado }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Recolección de Basura<input
                                                type="checkbox"
                                                v-model="
                                                    form.recoleccion_basura
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.recoleccion_basura
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.recoleccion_basura
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Conexión a Internet<input
                                                type="checkbox"
                                                v-model="form.conexion_internet"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.conexion_internet
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.conexion_internet
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Equipamiento Urbano Cercano:</label
                                >
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Escuelas<input
                                                type="checkbox"
                                                v-model="form.escuelas"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.escuelas"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.escuelas }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Centros Educativos<input
                                                type="checkbox"
                                                v-model="
                                                    form.centros_educativos
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.centros_educativos
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.centros_educativos
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Hospitales<input
                                                type="checkbox"
                                                v-model="form.hospitales"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.hospitales"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.hospitales }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Centros de Salud<input
                                                type="checkbox"
                                                v-model="form.centros_salud"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.centros_salud"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.centros_salud }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Centros Comerciales<input
                                                type="checkbox"
                                                v-model="
                                                    form.centros_comerciales
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.centros_comerciales
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.centros_comerciales
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Mercados<input
                                                type="checkbox"
                                                v-model="form.mercados"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.mercados"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.mercados }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Tiendas<input
                                                type="checkbox"
                                                v-model="form.tiendas"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.tiendas"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.tiendas }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Parques<input
                                                type="checkbox"
                                                v-model="form.parques"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.parques"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.parques }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Plazas<input
                                                type="checkbox"
                                                v-model="form.plazas"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.plazas"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.plazas }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Espacios Recreativos<input
                                                type="checkbox"
                                                v-model="
                                                    form.espacios_recreativos
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors
                                                    ?.espacios_recreativos
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.espacios_recreativos
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Iglesias<input
                                                type="checkbox"
                                                v-model="form.iglesias"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.iglesias"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.iglesias }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Oficinas Gubernamentales<input
                                                type="checkbox"
                                                v-model="
                                                    form.oficinas_gubernamentales
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors
                                                    ?.oficinas_gubernamentales
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.oficinas_gubernamentales
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Oficinas de Servicios Básicos<input
                                                type="checkbox"
                                                v-model="
                                                    form.oficinas_servicios
                                                "
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="
                                                form.errors?.oficinas_servicios
                                            "
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.oficinas_servicios
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Bancos<input
                                                type="checkbox"
                                                v-model="form.bancos"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.bancos"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.bancos }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label>Presencia de Áreas Verdes*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.areas_verdes,
                                    }"
                                    v-model="form.areas_verdes"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listAreasVerdes"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.areas_verdes"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.areas_verdes }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Nivel de Urbanización*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.nivel_urbanizacion,
                                    }"
                                    v-model="form.nivel_urbanizacion"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listNivelUrbanizacion"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.nivel_urbanizacion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.nivel_urbanizacion }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Estado del Vecindario:</label
                                >
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Seguro<input
                                                type="checkbox"
                                                v-model="form.seguro"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.seguro"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.seguro }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Limpio<input
                                                type="checkbox"
                                                v-model="form.limpio"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.limpio"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.limpio }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >En Desarrollo<input
                                                type="checkbox"
                                                v-model="form.en_desarrollo"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.en_desarrollo"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.en_desarrollo }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Tipo de Construcciones Cercanas:</label
                                >
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Viviendas<input
                                                type="checkbox"
                                                v-model="form.viviendas"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.viviendas"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.viviendas }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Negocios<input
                                                type="checkbox"
                                                v-model="form.negocios"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.negocios"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.negocios }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Bodegas<input
                                                type="checkbox"
                                                v-model="form.bodegas"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.bodegas"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.bodegas }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Galpones<input
                                                type="checkbox"
                                                v-model="form.galpones"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.galpones"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{ form.errors?.galpones }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="checkboxFormulario"
                                            >Terrenos baldíos<input
                                                type="checkbox"
                                                v-model="form.terrenos_baldios"
                                                :true-value="1"
                                                :false-value="0"
                                        /></label>
                                        <ul
                                            v-if="form.errors?.terrenos_baldios"
                                            class="parsley-errors-list filled"
                                        >
                                            <li class="parsley-required">
                                                {{
                                                    form.errors
                                                        ?.terrenos_baldios
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label
                                    >Topografía del Terreno y su Entorno*</label
                                >
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.topografia_entorno,
                                    }"
                                    v-model="form.topografia_entorno"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listTopografias"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.topografia_entorno"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.topografia_entorno }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Superficie del Terreno*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.superficie_terreno,
                                    }"
                                    v-model="form.superficie_terreno"
                                />
                                <ul
                                    v-if="form.errors?.superficie_terreno"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.superficie_terreno }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Costo al Contado*</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.costo_contado,
                                    }"
                                    v-model="form.costo_contado"
                                />
                                <ul
                                    v-if="form.errors?.costo_contado"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.costo_contado }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label>Costo a Crédito*</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.costo_credito,
                                    }"
                                    v-model="form.costo_credito"
                                />
                                <ul
                                    v-if="form.errors?.costo_credito"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.costo_credito }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Publicar*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error': form.errors?.publicar,
                                    }"
                                    v-model="form.publicar"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in ['SI', 'NO']"
                                        :value="item"
                                    >
                                        {{ item }}
                                    </option>
                                </select>

                                <ul
                                    v-if="form.errors?.publicar"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.publicar }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Imágenes del Terreno:</label
                                >
                                <MiDropZone
                                    :files="form.imagens"
                                    @UpdateFiles="detectaArchivos"
                                    @addEliminados="detectaEliminados"
                                ></MiDropZone>
                                <ul
                                    v-if="form.errors?.imagens"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.imagens }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a
                        href="javascript:;"
                        class="btn btn-white"
                        @click="cerrarDialog()"
                        ><i class="fa fa-times"></i> Cerrar</a
                    >
                    <button
                        type="button"
                        @click="enviarFormulario()"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
