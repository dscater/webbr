<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { usePreventas } from "@/composables/preventas/usePreventas";
import { useAxios } from "@/composables/axios/useAxios";
import { watch, ref, computed, defineEmits, onMounted, nextTick } from "vue";
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

const { oPreventa, limpiarPreventa } = usePreventas();
const { axiosGet } = useAxios();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oPreventa.value);
watch(
    () => props.open_dialog,
    async (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            const accesoCheckbox = $("#acceso");
            if (oPreventa.value.acceso == 1) {
                accesoCheckbox.prop("checked", false).trigger("click");
            } else {
                accesoCheckbox.prop("checked", true).trigger("click");
            }
            document
                .getElementsByTagName("body")[0]
                .classList.add("modal-open");
            form = useForm(oPreventa.value);
        }
    },
);
watch(
    () => props.accion_dialog,
    (newValue) => {
        accion.value = newValue;
    },
);

const { flash } = usePage().props;

const listExpedido = [
    { value: "LP", label: "La Paz" },
    { value: "CB", label: "Cochabamba" },
    { value: "SC", label: "Santa Cruz" },
    { value: "CH", label: "Chuquisaca" },
    { value: "OR", label: "Oruro" },
    { value: "PT", label: "Potosi" },
    { value: "TJ", label: "Tarija" },
    { value: "PD", label: "Pando" },
    { value: "BN", label: "Beni" },
];
const listTerrenos = ref([]);
const listClientes = ref([]);

const tituloDialog = computed(() => {
    return accion.value == 0
        ? `<i class="fa fa-plus"></i> Nueva Pre-venta`
        : `<i class="fa fa-edit"></i> Editar Pre-venta`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("preventas.store")
            : route("preventas.update", form.id);

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
            limpiarPreventa();
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
    cargarClientes();
};

const cargarTerrenos = () => {
    axios.get(route("terrenos.listado")).then((response) => {
        listTerrenos.value = response.data.terrenos;
    });
};

const cargarClientes = () => {
    axios.get(route("clientes.listado")).then((response) => {
        listClientes.value = response.data.clientes;
    });
};

const ratings = [
    {
        value: 1,
        icon: "fa-solid fa-face-angry",
        stars: "★☆☆☆☆",
        color: "#dc3545",
    },
    {
        value: 2,
        icon: "fa-solid fa-face-frown",
        stars: "★★☆☆☆",
        color: "#fd7e14",
    },
    {
        value: 3,
        icon: "fa-solid fa-face-meh",
        stars: "★★★☆☆",
        color: "#ffc107",
    },
    {
        value: 4,
        icon: "fa-solid fa-face-smile",
        stars: "★★★★☆",
        color: "#8bc34a",
    },
    {
        value: 5,
        icon: "fa-solid fa-face-laugh-beam",
        stars: "★★★★★",
        color: "#28a745",
    },
];

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
                            <div class="col-md-4">
                                <label>Seleccionar Terreno*</label>
                                <el-select
                                    :class="{
                                        'parsley-error':
                                            form.errors?.terreno_id,
                                    }"
                                    v-model="form.terreno_id"
                                    placeholder="- Seleccione -"
                                    filterable
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
                                            form.errors?.cliente_id,
                                    }"
                                    v-model="form.cliente_id"
                                    placeholder="- Seleccione -"
                                    filterable
                                >
                                    <el-option
                                        v-for="item in listClientes"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.full_name"
                                    ></el-option>
                                </el-select>
                                <ul
                                    v-if="form.errors?.cliente_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.cliente_id }}
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

                            <div class="col-12 mt-2">
                                <p class="small text-center text-muted mb-1">
                                    Realiza una calificación
                                </p>
                                <div class="text-center">
                                    <div class="emoji-rating">
                                        <div
                                            v-for="item in ratings"
                                            :key="item.value"
                                            class="emoji-item"
                                        >
                                            <input
                                                type="radio"
                                                :id="'rate' + item.value"
                                                name="rating"
                                                :value="item.value"
                                                v-model="form.calificacion"
                                            />

                                            <label
                                                :for="'rate' + item.value"
                                                :style="{
                                                    '--rating-color':
                                                        form.calificacion ==
                                                        item.value
                                                            ? item.color
                                                            : '#bdbdbd',
                                                }"
                                            >
                                                <i
                                                    :class="item.icon"
                                                    class="rating-icon"
                                                ></i>

                                                <small class="rating-stars">
                                                    {{ item.stars }}
                                                </small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <ul
                                    v-if="form.errors?.calificacion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.calificacion }}
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
<style scoped>
.emoji-rating {
    display: flex;
    justify-content: center;
    gap: 22px;
}

.emoji-item input {
    display: none;
}

.emoji-item label {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
}

.rating-icon {
    font-size: 2rem;
    color: var(--rating-color);
    transition:
        transform 0.25s ease,
        color 0.25s ease;
}

.rating-stars {
    margin-top: 6px;
    font-size: 0.8rem;
    color: var(--rating-color);
    transition: color 0.25s ease;
}

.emoji-item label:hover .rating-icon {
    transform: scale(1.15);
}

.emoji-item label:hover .rating-stars {
    transform: scale(1.05);
}

.emoji-item input:checked + label .rating-icon {
    transform: scale(1.3);
    filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.25));
}
</style>
