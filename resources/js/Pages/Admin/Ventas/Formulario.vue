<script setup>
import { usePage } from "@inertiajs/vue3";
import { watch, ref, computed, defineEmits, onMounted, nextTick } from "vue";
const props = defineProps({
    form: {
        type: Object,
    },
    open_dialog: {
        type: Boolean,
        default: false,
    },
});

const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
const form = props.form;

watch(
    () => props.accion_dialog,
    (newValue) => {
        accion.value = newValue;
    },
);

const { flash } = usePage().props;

const listTerrenos = ref([]);
const listPreventas = ref([]);

const tituloDialog = computed(() => {
    return form.id == 0
        ? `<i class="fa fa-plus"></i> Nueva Venta`
        : `<i class="fa fa-edit"></i> Editar Venta`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("ventas.store")
            : route("ventas.update", form.id);

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
    cargarTerrenos();
};

const cargarTerrenos = () => {
    axios
        .get(route("terrenos.listado"), {
            params: { sin_vender: true, venta_id: form.id != 0 ? form.id : 0 },
        })
        .then((response) => {
            listTerrenos.value = response.data.terrenos;
        });
};

const cargarPreventas = () => {
    axios
        .get(route("preventas.listadoPorTerreno"), {
            params: { terreno_id: form.terreno_id },
        })
        .then((response) => {
            listPreventas.value = response.data.preventas;
        });
};

onMounted(() => {
    if (dialog.value) {
        document.getElementsByTagName("body")[0].classList.add("modal-open");
    }
    cargarListas();
    if (form.terreno_id != 0) cargarPreventas();
});
</script>

<template>
    <div
        class="modal fade"
        :class="{
            show: open_dialog,
        }"
        id="modal-dialog-form"
        :style="{
            display: open_dialog ? 'block' : 'none',
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
                            <div class="col-md-4">
                                <label>Seleccionar Terreno*</label>
                                <el-select
                                    :class="{
                                        'parsley-error':
                                            form.errors?.terreno_id,
                                    }"
                                    v-model="form.terreno_id"
                                    no-data-text="Sin datos"
                                    no-match-text="Sin resultados"
                                    placeholder="- Seleccione -"
                                    filterable
                                    @change="cargarPreventas"
                                >
                                    <el-option
                                        v-for="item in listTerrenos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    ></el-option>
                                </el-select>
                                <ul
                                    v-if="form.errors?.terreno_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.terreno_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Seleccionar Cliente*</label>
                                <el-select
                                    :class="{
                                        'parsley-error':
                                            form.errors?.preventa_id,
                                    }"
                                    v-model="form.preventa_id"
                                    no-data-text="Sin datos"
                                    no-match-text="Sin resultados"
                                    placeholder="- Seleccione -"
                                    filterable
                                >
                                    <el-option
                                        v-for="item in listPreventas"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="`${item.cliente.full_name} - ${item.cliente.full_ci}`"
                                    ></el-option>
                                </el-select>
                                <ul
                                    v-if="form.errors?.preventa_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.preventa_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Descripción*</label>
                                <el-input
                                    type="textarea"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.descripcion,
                                    }"
                                    v-model="form.descripcion"
                                    autosize
                                ></el-input>
                                <ul
                                    v-if="form.errors?.descripcion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.descripcion }}
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
