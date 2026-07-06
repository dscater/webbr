<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Reporte Especificación de Terrenos",
        disabled: false,
        url: "",
        name_url: "",
    },
];
</script>

<script setup>
import { useApp } from "@/composables/useApp";
import { computed, onMounted, ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";

const { setLoading } = useApp();

const cargarListas = () => {
    cargarTerrenos();
    cargarMunicipios();
    cargarUrbanizaciones();
};
const listTerrenos = ref([]);
const listMunicipios = ref([]);
const listUrbanizaciones = ref([]);

const cargarTerrenos = () => {
    axios.get(route("terrenos.listado")).then((response) => {
        listTerrenos.value = response.data.terrenos;
        listTerrenos.value.unshift({ id: "todos", nombre: "TODOS" });
    });
};

const cargarMunicipios = () => {
    axios.get(route("municipios.listado")).then((response) => {
        listMunicipios.value = response.data.municipios;
        listMunicipios.value.unshift({ id: "todos", nombre: "TODOS" });
    });
};

const cargarUrbanizaciones = () => {
    axios.get(route("urbanizacions.listado")).then((response) => {
        listUrbanizaciones.value = response.data.urbanizacions;
        listUrbanizaciones.value.unshift({ id: "todos", nombre: "TODOS" });
    });
};

onMounted(() => {
    cargarListas();
    setTimeout(() => {
        setLoading(false);
    }, 300);
});

const form = ref({
    terreno_id: "todos",
    municipio_id: "todos",
    urbanizacion_id: "todos",
});

const generando = ref(false);
const txtBtn = computed(() => {
    if (generando.value) {
        return "Generando Reporte...";
    }
    return "Generar Reporte";
});

const generarReporte = () => {
    generando.value = true;
    const url = route("reportes.r_especificacion_terrenos", form.value);
    window.open(url, "_blank");
    setTimeout(() => {
        generando.value = false;
    }, 500);
};
</script>
<template>
    <Head title="Reporte Especificación de Terrenos"></Head>
    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Inicio</a></li>
        <li class="breadcrumb-item active">
            Reportes > Especificación de Terrenos
        </li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Reportes > Especificación de Terrenos</h1>
    <!-- END page-header -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="generarReporte">
                        <div class="row">
                            <div class="col-12">
                                <label>Seleccionar terreno*</label>
                                <el-select v-model="form.terreno_id" filterable>
                                    <el-option
                                        v-for="item in listTerrenos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-12 mt-2">
                                <label>Seleccionar Municipio*</label>
                                <el-select
                                    v-model="form.municipio_id"
                                    filterable
                                >
                                    <el-option
                                        v-for="item in listMunicipios"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-12 mt-2">
                                <label>Seleccionar Urbanización*</label>
                                <el-select
                                    v-model="form.urbanizacion_id"
                                    filterable
                                >
                                    <el-option
                                        v-for="item in listUrbanizaciones"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button
                                    class="btn btn-primary"
                                    block
                                    @click="generarReporte"
                                    :disabled="generando"
                                    v-text="txtBtn"
                                ></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
