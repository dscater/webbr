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
                <div class="col-12 text-center">
                    <h1 class="mb-2 h2">{{ oConfiguracion.nombre_sistema }}</h1>
                    <div>
                        <i class="fa fa-map-marker-alt"></i>
                        {{ oConfiguracion.dir }}
                    </div>
                    <div>
                        <i class="fa fa-phone"></i>
                        {{ oConfiguracion.telefono }}
                    </div>
                    <div>
                        <i class="fa fa-envelope"></i>
                        {{ oConfiguracion.correo }}
                    </div>

                    <img
                        :src="oConfiguracion.url_logo"
                        alt=""
                        class="img_logo mt-2"
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
    max-width: 200px;
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
