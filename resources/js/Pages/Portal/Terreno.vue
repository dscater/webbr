<script>
import Portal from "@/Layouts/Portal.vue";
import SliderImagenes from "@/Components/SliderImagenes.vue";
import Terreno from "@/Components/Terreno.vue";
export default {
    layout: Portal,
};
</script>
<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { onMounted, ref, inject } from "vue";
const { props: props_page } = usePage();
const props = defineProps({
    terreno: {
        type: Object,
        default: null,
    },
});

const oTerreno = ref(props.terreno);
onMounted(() => {});
</script>
<template>
    <div id="product" class="section-container pt-20px">
        <div class="container">
            <h4 class="section-title clearfix">
                <span class="flex-1 h3 mt-2 w-100 text-center"
                    >Ver terreno</span
                >
            </h4>
            <Terreno :terreno="oTerreno" :key="oTerreno.id"></Terreno>

            <div class="row">
                <div class="col-12 text-center">
                    <Link
                        :href="route('portal.index')"
                        class="btn btn-outline-primary mt-2 btn-lg"
                        ><i class="fa fa-arrow-left"></i> Seguir viendo
                        terrenos</Link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.section-container {
    min-height: 70vh !important;
}
</style>
