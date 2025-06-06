<script setup>
import { usePage, Head, router, Link } from "@inertiajs/vue3";
import { useConfiguracion } from "@/composables/configuracion/useConfiguracion";
const { oConfiguracion } = useConfiguracion();
</script>
<template>
    <!-- BEGIN #footer -->
    <div id="footer" class="footer">
        <!-- BEGIN container -->
        <div class="container">
            <!-- BEGIN row -->
            <div class="row">
                <!-- BEGIN col-3 -->
                <div class="col-lg-3"></div>
                <!-- END col-3 -->
                <!-- BEGIN col-3 -->
                <div class="col-lg-3"></div>
                <!-- END col-3 -->
                <!-- BEGIN col-3 -->
                <div class="col-lg-3">
                    <h1 class="mb-0">{{ oConfiguracion.nombre_sistema }}</h1>
                    <img
                        :src="oConfiguracion.url_logo"
                        alt=""
                        class="img_logo"
                    />
                </div>
                <!-- END col-3 -->
                <!-- BEGIN col-3 -->
                <div class="col-lg-3"></div>
                <!-- END col-3 -->
            </div>
            <!-- END row -->
        </div>
        <!-- END container -->
    </div>
    <!-- END #footer -->
</template>
<style scoped>
.img_logo {
    margin-left: -130px;
    width: 370px;
}

.footer {
    color: white;
    background-color: var(--principal-portal3);
    box-shadow: none;
}

@media (max-width: 900px) {
    .img_logo {
        margin-left: 0px;
        width: 270px;
    }
}
</style>
