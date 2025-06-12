<script>
import Portal from "@/Layouts/Portal.vue";
export default {
    layout: Portal,
};
</script>
<script setup>
import { onMounted, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useAxios } from "@/composables/axios/useAxios";
import { useConfiguracion } from "@/composables/configuracion/useConfiguracion";
import MiPaginacion from "@/Components/MiPaginacion.vue";
import { useFormater } from "@/composables/useFormater";
const { getFormatoMoneda } = useFormater();

const { oConfiguracion } = useConfiguracion();
const { props: props_page } = usePage();
const user = ref(props_page.auth?.user);
const url_asset = ref(props_page.url_assets);

const listTerrenos = ref([]);
const registrosFila1 = ref([]);
const registrosFila2 = ref([]);
const registrosFila3 = ref([]);
const muestraDescResultados = ref(false);
const { axiosGet } = useAxios();

const paramsTerrenos = ref({
    page: 1,
    perPage: 9,
    search: "",
    precioDesde: "",
    precioHasta: "",
    categoria_id: "",
    orderByCol: "",
    desc: "",
});

const dataPaginacion = ref({
    totalData: 0,
    perPage: paramsTerrenos.value.perPage,
    currentPage: paramsTerrenos.value.page,
    lastPage: 0,
});

const obtenerTerrenos = async () => {
    muestraDescResultados.value = false;
    const data = await axiosGet(
        route("terrenos.listadoPaginado", paramsTerrenos.value)
    );
    registrosFila1.value = data.terrenos.splice(0, 3);
    registrosFila2.value = data.terrenos.splice(0, 3);
    registrosFila3.value = data.terrenos.splice(0, 3);
    dataPaginacion.value.totalData = data.total;
    dataPaginacion.value.currentPage = paramsTerrenos.value.page;
    dataPaginacion.value.lastPage = data.lastPage;
    if (paramsTerrenos.value.search.trim() != "") {
        muestraDescResultados.value = true;
    }
};

const updatePage = (value) => {
    paramsTerrenos.value.page = value;
    if (paramsTerrenos.value.page < 0) paramsTerrenos.value.page = 1;
    if (paramsTerrenos.value.page > dataPaginacion.value.totalData)
        paramsTerrenos.value.page = dataPaginacion.value.lastPage;
    obtenerTerrenos();
};

const filtrarCategoria = (categoria_id) => {
    if (paramsTerrenos.value.categoria_id != categoria_id) {
        paramsTerrenos.value.categoria_id = categoria_id;
    } else {
        paramsTerrenos.value.categoria_id = "";
    }
    obtenerTerrenos();
};

const filtrarOrderBy = (orderCol) => {
    if (
        paramsTerrenos.value.desc != "asc" ||
        paramsTerrenos.value.orderByCol != orderCol
    ) {
        paramsTerrenos.value.desc = "desc";
        if (paramsTerrenos.value.orderByCol == orderCol) {
            paramsTerrenos.value.desc = "asc";
        }
        paramsTerrenos.value.orderByCol = orderCol;
    } else {
        paramsTerrenos.value.orderByCol = "";
        paramsTerrenos.value.desc = "";
    }
    obtenerTerrenos();
};

const cargarListas = () => {
    obtenerTerrenos();
};

onMounted(() => {
    cargarListas();
});
</script>
<template>
    <!-- BEGIN #vehiculos -->
    <div id="vehiculos" class="seccion_categoria vehiculos">
        <!-- BEGIN container -->
        <div class="container mb-0">
            <div class="row">
                <div class="col-12 pt-3 mb-3">
                    <h3 class="w-100 text-center">Venta de terrenos</h3>
                </div>
            </div>
            <!-- BEGIN section-title -->
            <!-- END section-title -->
            <!-- BEGIN row -->
            <div class="row gx-2">
                <div class="col-12">
                    <div class="search-container">
                        <!-- BEGIN search-sidebar -->
                        <div class="search-sidebar">
                            <h4 class="title">Buscar por:</h4>
                            <form @submit.prevent="obtenerTerrenos">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Nombre</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control input-sm"
                                        name="keyword"
                                        v-model="paramsTerrenos.search"
                                        placeholder="Nombre"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Precio</label>
                                    <div class="row row-space-0">
                                        <div class="col-md-5">
                                            <input
                                                type="number"
                                                class="form-control input-sm"
                                                name="price_from"
                                                min="0"
                                                placeholder="Desde"
                                                v-model="
                                                    paramsTerrenos.precioDesde
                                                "
                                            />
                                        </div>
                                        <div
                                            class="col-md-2 text-center pt-5px fs-12px text-muted"
                                        >
                                            -
                                        </div>
                                        <div class="col-md-5">
                                            <input
                                                type="number"
                                                class="form-control input-sm"
                                                name="price_to"
                                                min="0"
                                                placeholder="Hasta"
                                                v-model="
                                                    paramsTerrenos.precioHasta
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-30px">
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-theme btn-dark w-100"
                                    >
                                        <i
                                            class="fa fa-search fa-fw me-1 ms-n3"
                                        ></i>
                                        BUSCAR
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- END search-sidebar -->
                        <!-- BEGIN search-content -->
                        <div class="search-content">
                            <!-- BEGIN search-toolbar -->
                            <div class="search-toolbar">
                                <!-- BEGIN row -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4
                                            v-show="muestraDescResultados != ''"
                                        >
                                            Encontramos
                                            {{ dataPaginacion.totalData }}
                                            registro(s) para "{{
                                                paramsTerrenos.search
                                            }}"
                                        </h4>
                                    </div>
                                    <!-- END col-6 -->
                                    <!-- BEGIN col-6 -->
                                    <div class="col-lg-6 text-end">
                                        <ul class="sort-list">
                                            <li class="text">
                                                <i
                                                    class="fa"
                                                    :class="
                                                        paramsTerrenos.desc ==
                                                        'desc'
                                                            ? 'fa-sort-amount-up'
                                                            : paramsTerrenos.desc ==
                                                              'asc'
                                                            ? 'fa-sort-amount-down-alt'
                                                            : 'fa-filter'
                                                    "
                                                ></i>
                                                Ordenar por:
                                            </li>
                                            <li
                                                :class="
                                                    paramsTerrenos.orderByCol ==
                                                    'id'
                                                        ? 'active'
                                                        : ''
                                                "
                                            >
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        filtrarOrderBy('id')
                                                    "
                                                    >Nuevos</a
                                                >
                                            </li>
                                            <li
                                                :class="
                                                    paramsTerrenos.orderByCol ==
                                                    'costo_contado'
                                                        ? 'active'
                                                        : ''
                                                "
                                            >
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        filtrarOrderBy(
                                                            'costo_contado'
                                                        )
                                                    "
                                                    >Precio</a
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END col-6 -->
                                </div>
                                <!-- END row -->
                            </div>
                            <!-- END search-toolbar -->
                            <!-- BEGIN search-item-container -->
                            <div class="search-item-container">
                                <!-- BEGIN item-row -->
                                <div
                                    class="item-row"
                                    v-if="
                                        registrosFila1 &&
                                        registrosFila1.length > 0
                                    "
                                >
                                    <!-- BEGIN item -->
                                    <div
                                        class="item item-thumbnail"
                                        v-for="item in registrosFila1"
                                    >
                                        <Link
                                            :href="
                                                route('portal.terreno', item.id)
                                            "
                                            class="item-image"
                                        >
                                            <img
                                                :src="
                                                    item.imagens[0].url_imagen
                                                "
                                                alt=""
                                            />
                                        </Link>
                                        <div class="item-info">
                                            <h4 class="item-title">
                                                <a
                                                    :href="
                                                        route(
                                                            'portal.terreno',
                                                            item.id
                                                        )
                                                    "
                                                    >{{ item.nombre }}</a
                                                >
                                            </h4>
                                            <p class="item-desc">
                                                {{ item.descripcion }}
                                            </p>
                                            <div class="item-price">
                                                $us
                                                {{
                                                    getFormatoMoneda(
                                                        item.costo_contado
                                                    )
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END item -->
                                </div>
                                <!-- END item-row -->
                                <!-- BEGIN item-row -->
                                <div
                                    class="item-row"
                                    v-if="
                                        registrosFila2 &&
                                        registrosFila2.length > 0
                                    "
                                >
                                    <!-- BEGIN item -->
                                    <div
                                        class="item item-thumbnail"
                                        v-for="item in registrosFila2"
                                    >
                                        <Link
                                            :href="
                                                route('portal.terreno', item.id)
                                            "
                                            class="item-image"
                                        >
                                            <img
                                                :src="
                                                    item.imagens[0].url_imagen
                                                "
                                                alt=""
                                            />
                                        </Link>
                                        <div class="item-info">
                                            <h4 class="item-title">
                                                <a
                                                    :href="
                                                        route(
                                                            'portal.terreno',
                                                            item.id
                                                        )
                                                    "
                                                    >{{ item.nombre }}</a
                                                >
                                            </h4>
                                            <p class="item-desc">
                                                {{ item.descripcion }}
                                            </p>
                                            <div class="item-price">
                                                {{
                                                    oConfiguracion.conf_moneda
                                                        .abrev
                                                }}
                                                {{ item.costo_contado }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END item -->
                                </div>
                                <!-- END item-row -->
                                <!-- BEGIN item-row -->
                                <div
                                    class="item-row"
                                    v-if="
                                        registrosFila3 &&
                                        registrosFila3.length > 0
                                    "
                                >
                                    <!-- BEGIN item -->
                                    <div
                                        class="item item-thumbnail"
                                        v-for="item in registrosFila3"
                                    >
                                        <Link
                                            :href="
                                                route('portal.terreno', item.id)
                                            "
                                            class="item-image"
                                        >
                                            <img
                                                :src="
                                                    item.imagens[0].url_imagen
                                                "
                                                alt=""
                                            />
                                        </Link>
                                        <div class="item-info">
                                            <h4 class="item-title">
                                                <a
                                                    :href="
                                                        route(
                                                            'portal.terreno',
                                                            item.id
                                                        )
                                                    "
                                                    >{{ item.nombre }}</a
                                                >
                                            </h4>
                                            <p class="item-desc">
                                                {{ item.descripcion }}
                                            </p>
                                            <div class="item-price">
                                                {{
                                                    oConfiguracion.conf_moneda
                                                        .abrev
                                                }}
                                                {{ item.costo_contado }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END item -->
                                </div>
                                <!-- END item-row -->
                            </div>
                            <!-- END search-item-container -->
                            <!-- BEGIN pagination -->
                            <MiPaginacion
                                class="justify-content-center"
                                :totalData="dataPaginacion.totalData"
                                :currentPage="dataPaginacion.currentPage"
                                :perPage="dataPaginacion.perPage"
                                @updatePage="updatePage"
                            />
                            <!-- END pagination -->
                        </div>
                        <!-- END search-content -->
                    </div>
                </div>
            </div>
            <!-- END row -->
        </div>
        <!-- END container -->
    </div>
    <!-- END #vehiculos -->
</template>

<style scoped>
.item.item-thumbnail {
    margin: 0px;
    padding: 0px;
    border: none;
}

.item.item-thumbnail .item-image img {
    width: 100% !important;
}

.seccion_categoria .container {
    padding-bottom: 30px;
}
.seccion_categoria .titlesec {
    position: relative;
    margin-bottom: 0px;
    color: var(--principal-portal2);
    font-weight: bold;
}
.seccion_categoria .titlesec span {
    padding: 3px 14px 3px 14px;
    border-radius: 20px;
    border: solid 1px var(--principal-portal);
    font-size: 0.97rem;
}

.seccion_categoria .titlesec img {
    height: 70px;
}

/* vehiculos-ecologicos */
.seccion_categoria.vehiculos,
.seccion_categoria.ecologicos {
    background-color: white;
    margin-bottom: 0px;
}
.seccion_categoria.ecologicos .container,
.seccion_categoria.vehiculos .container {
    background-color: #e8ecee;
    padding-bottom: 40px;
}
/* otros bienes */

.seccion_categoria.otros_bienes {
    background-color: #e8ecee;
}
.seccion_categoria.otros_bienes .container {
    background-color: white;
}

.seccion_categoria.otros_bienes .item {
    border: solid 1px #d0d1d1;
}
</style>
