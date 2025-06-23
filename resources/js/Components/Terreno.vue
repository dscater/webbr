<script>
import SliderImagenes from "@/Components/SliderImagenes.vue";
</script>
<script setup>
import { usePage, Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref, inject, computed, onBeforeUnmount, watch } from "vue";
import { useFormater } from "@/composables/useFormater";
import axios from "axios";
import { useClientes } from "@/composables/clientes/useClientes";
import { useConfiguracion } from "@/composables/configuracion/useConfiguracion";
const { oConfiguracion } = useConfiguracion();
const { getFormatoMoneda } = useFormater();
const { props: props_page } = usePage();
const props = defineProps({
    terreno: {
        type: Object,
        default: null,
    },
});

const { oCliente, limpiarCliente } = useClientes();
let form = useForm(oCliente.value);
const clienteCi = ref(null);
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
const open_modal = ref(false);
const abrirModal = () => {
    form = useForm(oCliente.value);
    open_modal.value = true;
};
const cerrarDialog = () => {
    open_modal.value = false;
};
watch(
    () => props.terreno,
    (newValue) => {
        oPublicacion.value = newValue;
    }
);

const enviarFormulario = () => {
    form["_method"] = "POST";
    let url = route("preventas.registrarPreventaPortal", props.terreno.id);

    form.post(url, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            open_modal.value = false;
            const flash = usePage().props.flash;
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: `${flash.bien ? flash.bien : "Proceso realizado"}`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
            limpiarCliente();
            emits("envio-formulario");
        },
        onError: (err) => {
            const flash = usePage().props.flash;
            if (err.error) {
                Swal.fire({
                    icon: "info",
                    title: "Error",
                    text: `${err.error}`,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: `Aceptar`,
                });
            } else {
                Swal.fire({
                    icon: "info",
                    title: "Error",
                    text: `${
                        flash.bien ? flash.bien : "Hay errores en el formulario"
                    }`,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: `Aceptar`,
                });
            }
        },
    });
};

const verificarCliente = () => {
    clienteCi.value = null;
    axios
        .get(route("clientes.buscarPorCi"), { params: { ci: form.ci } })
        .then((response) => {
            const cliente = response.data;
            if (cliente && cliente.id && cliente.id != 0) {
                clienteCi.value = response.data;
                form.id = clienteCi.value.id;
                form.ci = clienteCi.value.ci;
                form.ci_exp = clienteCi.value.ci_exp;
                form.nombre = clienteCi.value.nombre;
                form.paterno = clienteCi.value.paterno;
                form.materno = clienteCi.value.materno;
                form.fono = clienteCi.value.fono;
                form.correo = clienteCi.value.correo;
                form.dir = clienteCi.value.dir;
            } else {
                limpiarForm();
            }
        });
};

const limpiarForm = () => {
    form.id = "";
    form.ci_exp = "";
    form.nombre = "";
    form.paterno = "";
    form.materno = "";
    form.fono = "";
    form.correo = "";
    form.dir = "";
};
onMounted(() => {});

onBeforeUnmount(() => {});
</script>
<template>
    <div class="product-detail row">
        <!-- BEGIN product-image -->
        <div class="product-image col-md-6">
            <SliderImagenes
                :imagenes="terreno?.imagens"
                class="slider-imagenes"
            ></SliderImagenes>
        </div>
        <!-- END product-image -->
        <!-- BEGIN product-info -->
        <div class="product-info col-md-6 pt-4 pb-4 px-4">
            <div class="product-info-detail pb-3">
                <h4 class="product-title">{{ terreno.nombre }}</h4>
                <span class="text-muted">{{ terreno.nombre }}</span>
                <p class="pull-right mb-0 mt-2">{{ terreno.descripcion }}</p>
            </div>
            <div class="pt-4 pb-3">
                <div class="product-price mb-3">
                    <div class="price">
                        $us
                        {{ getFormatoMoneda(terreno.costo_contado) }}
                    </div>
                </div>
                <button
                    class="btn btn-dark btn-theme btn-lg"
                    @click.prevent="abrirModal()"
                >
                    <i class="fa fa-check-circle"></i> Realizar Pre-venta
                </button>
            </div>
        </div>
        <!-- END product-info -->
    </div>

    <div
        class="modal fade"
        :class="{
            show: open_modal,
        }"
        id="modal-dialog-form"
        :style="{
            display: open_modal ? 'block' : 'none',
        }"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h4 class="modal-title">
                        <i class="fa fa-edit"></i> Realizar Pre-venta
                    </h4>
                    <button
                        type="button"
                        class="btn-close"
                        @click="cerrarDialog()"
                    ></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="enviarFormulario()">
                        <p class="mb-0">
                            <small
                                >Todos los campos con * son obligatorios</small
                            >
                        </p>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label>Número de C.I.*</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.ci,
                                    }"
                                    v-model="form.ci"
                                    @blur="verificarCliente"
                                />

                                <ul
                                    v-if="form.errors?.ci"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.ci }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Expedido*</label>
                                <select
                                    class="form-select"
                                    :class="{
                                        'parsley-error': form.errors?.ci_exp,
                                    }"
                                    v-model="form.ci_exp"
                                >
                                    <option value="">- Seleccione -</option>
                                    <option
                                        v-for="item in listExpedido"
                                        :value="item.value"
                                    >
                                        {{ item.label }}
                                    </option>
                                </select>
                                <ul
                                    v-if="form.errors?.ci_exp"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.ci_exp }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Nombre(s)*</label>
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
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.nombre }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Apellido Paterno*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.paterno,
                                    }"
                                    v-model="form.paterno"
                                />
                                <ul
                                    v-if="form.errors?.paterno"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.paterno }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Apellido Materno</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.materno,
                                    }"
                                    v-model="form.materno"
                                />
                                <ul
                                    v-if="form.errors?.materno"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.materno }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Teléfono/Celular*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.fono,
                                    }"
                                    v-model="form.fono"
                                />
                                <ul
                                    v-if="form.errors?.fono"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.fono }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Correo Electrónico*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.correo,
                                    }"
                                    v-model="form.correo"
                                />
                                <ul
                                    v-if="form.errors?.correo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.correo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Dirección*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.dir,
                                    }"
                                    v-model="form.dir"
                                />
                                <ul
                                    v-if="form.errors?.dir"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required text-danger">
                                        {{ form.errors?.dir }}
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
                        class="btn btn-dark"
                    >
                        <i class="fa fa-check"></i>
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.slider-imagenes {
    height: 100%;
}
.product-detail {
    padding: 0;
    background-color: white;
}

.product-detail .product-image {
    padding: 0;
}

.product-info-detail {
    border-bottom: 1px solid var(--bs-component-border-color);
}

.price {
    font-weight: 600;
    font-size: 2rem;
}
.modal {
    background-color: rgba(0, 0, 0, 0.541);
}
</style>
