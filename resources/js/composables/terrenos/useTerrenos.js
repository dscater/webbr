import { onMounted, reactive } from "vue";

const oTerreno = reactive({
    id: 0,
    municipio_id: "",
    urbanizacion_id: "",
    manzano_id: "",
    nombre: "",
    tipo_calle: "",
    ancho_calle: "",
    conectividad: "",
    trafico: "",
    tipo_zona: "",
    agua_potable: 0,
    alcantarillado: 0,
    energia_electrica: 0,
    gas_natural: 0,
    alumbrado: 0,
    recoleccion_basura: 0,
    conexion_internet: 0,
    escuelas: 0,
    centros_educativos: 0,
    hospitales: 0,
    centros_salud: 0,
    centros_comerciales: 0,
    mercados: 0,
    tiendas: 0,
    parques: 0,
    plazas: 0,
    espacios_recreativos: 0,
    iglesias: 0,
    oficinas_gubarnamentales: 0,
    oficinas_servicios: 0,
    bancos: 0,
    areas_verdes: "",
    nivel_urbanizacion: "",
    seguro: 0,
    limpio: 0,
    en_desarrollo: 0,
    viviendas: 0,
    negocios: 0,
    bodegas: 0,
    galpones: 0,
    terrenos_baldios: 0,
    topografia_entorno: "",
    superficie_terreno: "",
    costo_contado: "",
    costo_credito: "",
    publicar: "NO",
    imagens: [],
    eliminados: [],
    _method: "POST",
});

export const useTerrenos = () => {
    const setTerreno = (item = null) => {
        if (item) {
            oTerreno.id = item.id;
            oTerreno.municipio_id = item.municipio_id;
            oTerreno.urbanizacion_id = item.urbanizacion_id;
            oTerreno.manzano_id = item.manzano_id;
            oTerreno.nombre = item.nombre;
            oTerreno.tipo_calle = item.tipo_calle;
            oTerreno.ancho_calle = item.ancho_calle;
            oTerreno.conectividad = item.conectividad;
            oTerreno.trafico = item.trafico;
            oTerreno.tipo_zona = item.tipo_zona;
            oTerreno.agua_potable = item.agua_potable;
            oTerreno.alcantarillado = item.alcantarillado;
            oTerreno.energia_electrica = item.energia_electrica;
            oTerreno.gas_natural = item.gas_natural;
            oTerreno.alumbrado = item.alumbrado;
            oTerreno.recoleccion_basura = item.recoleccion_basura;
            oTerreno.conexion_internet = item.conexion_internet;
            oTerreno.escuelas = item.escuelas;
            oTerreno.centros_educativos = item.centros_educativos;
            oTerreno.hospitales = item.hospitales;
            oTerreno.centros_salud = item.centros_salud;
            oTerreno.centros_comerciales = item.centros_comerciales;
            oTerreno.mercados = item.mercados;
            oTerreno.tiendas = item.tiendas;
            oTerreno.parques = item.parques;
            oTerreno.plazas = item.plazas;
            oTerreno.espacios_recreativos = item.espacios_recreativos;
            oTerreno.iglesias = item.iglesias;
            oTerreno.oficinas_gubarnamentales = item.oficinas_gubarnamentales;
            oTerreno.oficinas_servicios = item.oficinas_servicios;
            oTerreno.bancos = item.bancos;
            oTerreno.areas_verdes = item.areas_verdes;
            oTerreno.nivel_urbanizacion = item.nivel_urbanizacion;
            oTerreno.seguro = item.seguro;
            oTerreno.limpio = item.limpio;
            oTerreno.en_desarrollo = item.en_desarrollo;
            oTerreno.viviendas = item.viviendas;
            oTerreno.negocios = item.negocios;
            oTerreno.bodegas = item.bodegas;
            oTerreno.galpones = item.galpones;
            oTerreno.terrenos_baldios = item.terrenos_baldios;
            oTerreno.topografia_entorno = item.topografia_entorno;
            oTerreno.superficie_terreno = item.superficie_terreno;
            oTerreno.costo_contado = item.costo_contado;
            oTerreno.costo_credito = item.costo_credito;
            oTerreno.publicar = item.publicar;
            oTerreno.imagens = item.imagens;
            oTerreno.eliminados = [];
            oTerreno._method = "PUT";
            return oTerreno;
        }
        return false;
    };

    const limpiarTerreno = () => {
        oTerreno.id = 0;
        oTerreno.municipio_id = "";
        oTerreno.urbanizacion_id = "";
        oTerreno.manzano_id = "";
        oTerreno.nombre = "";
        oTerreno.tipo_calle = "";
        oTerreno.ancho_calle = "";
        oTerreno.conectividad = "";
        oTerreno.trafico = "";
        oTerreno.tipo_zona = "";
        oTerreno.agua_potable = 0;
        oTerreno.alcantarillado = 0;
        oTerreno.energia_electrica = 0;
        oTerreno.gas_natural = 0;
        oTerreno.alumbrado = 0;
        oTerreno.recoleccion_basura = 0;
        oTerreno.conexion_internet = 0;
        oTerreno.escuelas = 0;
        oTerreno.centros_educativos = 0;
        oTerreno.hospitales = 0;
        oTerreno.centros_salud = 0;
        oTerreno.centros_comerciales = 0;
        oTerreno.mercados = 0;
        oTerreno.tiendas = 0;
        oTerreno.parques = 0;
        oTerreno.plazas = 0;
        oTerreno.espacios_recreativos = 0;
        oTerreno.iglesias = 0;
        oTerreno.oficinas_gubarnamentales = 0;
        oTerreno.oficinas_servicios = 0;
        oTerreno.bancos = 0;
        oTerreno.areas_verdes = "";
        oTerreno.nivel_urbanizacion = "";
        oTerreno.seguro = 0;
        oTerreno.limpio = 0;
        oTerreno.en_desarrollo = 0;
        oTerreno.viviendas = 0;
        oTerreno.negocios = 0;
        oTerreno.bodegas = 0;
        oTerreno.galpones = 0;
        oTerreno.terrenos_baldios = 0;
        oTerreno.topografia_entorno = "";
        oTerreno.superficie_terreno = "";
        oTerreno.costo_contado = "";
        oTerreno.costo_credito = "";
        oTerreno.publicar = "NO";
        oTerreno.imagens = [];
        oTerreno.eliminados = [];
        oTerreno._method = "POST";
    };

    onMounted(() => {});

    return {
        oTerreno,
        setTerreno,
        limpiarTerreno,
    };
};
