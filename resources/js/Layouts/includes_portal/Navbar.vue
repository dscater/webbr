<script setup>
import { usePage, Head, router, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { useConfiguracion } from "@/composables/configuracion/useConfiguracion";
const { oConfiguracion } = useConfiguracion();

const { props: props_page } = usePage();
const user = ref(props_page.auth?.user);
const url_asset = ref(props_page.url_assets);

const route_current = ref("");

router.on("navigate", (event) => {
    route_current.value = route().current();
});

const logout = () => {
    axios
        .post(route("logout"))
        .then((response) => {
            window.location.href = route("portal.index");
        })
        .catch((error) => {
            console.log(error.response);
        });

    // router.post(route("logout"), {
    //     onFinish: () => {
    //         window.location.reload();
    //     },
    // });
};

var handleHeaderFixedTop = function () {
    if ($('#header[data-fixed-top="true"]').length !== 0) {
        // var headerScrolltop = $('#top-nav').height();
        var headerScrolltop = $("#header").height();
        var targetPaddingTop = $("#header").height();
        $(window).on("scroll", function () {
            if ($(window).scrollTop() >= headerScrolltop) {
                $("body").css("padding-top", targetPaddingTop);
                $("#header").addClass("header-fixed");
            } else {
                $("#header").removeClass("header-fixed");
                $("body").css("padding-top", "0");
            }
        });
    }
};

const colapse = ref(false);
const toggleNavbar = () => {
    colapse.value = !colapse.value;
};

onMounted(() => {
    handleHeaderFixedTop();
    window.addEventListener("load", () => {
        handleHeaderFixedTop();
    });
});
</script>
<template>
    <Head title="Inicio"></Head>
    <!-- BEGIN #header -->
    <div id="header" class="header" data-fixed-top="true">
        <!-- BEGIN container -->
        <div class="container">
            <!-- BEGIN header-container -->
            <div class="header-container">
                <!-- BEGIN navbar-toggle -->
                <button
                    type="button"
                    class="navbar-toggle collapsed bg-principal-portal"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbar-collapse"
                    @click="toggleNavbar"
                >
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- END navbar-toggle -->
                <!-- BEGIN header-logo -->
                <div class="header-logo">
                    <a :href="route('portal.index')" class="mr-5">
                        <img :src="oConfiguracion.url_logo" alt="Img" />
                    </a>
                </div>
                <!-- END header-logo -->
                <!-- BEGIN header-nav -->
                <div class="header-nav header-menu">
                    <div
                        class="navbar-collapse collapse"
                        :class="{ show: colapse }"
                        ref="navbarCollapse"
                    >
                        <ul class="nav justify-content-center">
                            <li class="h1">{{ oConfiguracion.nombre_sistema }}</li>
                        </ul>
                    </div>
                </div>
                <!-- END header-nav -->
                <!-- BEGIN header-nav -->
                <div class="header-nav header-registro">
                    <ul class="nav">
                        <li v-if="!user">
                            <a :href="route('login')">
                                <span><i class="fa fa-user"></i></span>
                                <span class="d-none d-xl-inline"> Acceder</span>
                            </a>
                        </li>
                        <li class="dropdown dropdown-hover" v-if="user">
                            <a href="#" data-bs-toggle="dropdown">
                                <img
                                    :src="user.url_foto"
                                    alt="Img"
                                    class="img_usuario"
                                />
                                <span class="d-none d-xl-inline">{{
                                    user.usuario_abrev
                                }}</span>
                                <b class="caret"></b>
                                <!-- <span class="arrow top"></span> -->
                            </a>
                            <div class="dropdown-menu">
                                <Link
                                    v-if="user.role_id != 2"
                                    :href="route('profile.edit')"
                                    class="dropdown-item"
                                    href=""
                                    >Perfil</Link
                                >
                                <Link
                                    v-if="user.role_id == 2"
                                    :href="route('profile.profile_cliente')"
                                    class="dropdown-item"
                                    href=""
                                    >Perfil</Link
                                >
                                <a
                                    class="dropdown-item"
                                    href="#"
                                    @click.prevent="logout"
                                    >Cerrar sesión</a
                                >
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- END header-nav -->
            </div>
            <!-- END header-container -->
        </div>
        <!-- END container -->
    </div>
    <!-- END #header -->
</template>
<style scoped>
.header {
    border-bottom: solid 20px var(--principal-portal);
    height: 115px;
    transition: 0.3s all;
    background-color: var(--secundario);
}

.header.header-fixed {
    border-bottom: solid 3px var(--principal-portal);
    height: 79px;
}

.header-container {
    height: 115px;
}

.header.header-fixed .header-container {
    height: 90px;
}

.header .navbar-toggle.collapsed {
    height: 65px;
}

.header.header-fixed .navbar-toggle.collapsed {
    height: 66px;
}

.img_usuario {
    height: 35px;
    width: 35px;
    border-radius: 50%;
    object-fit: cover;
    background: gray;
}

/* LOGO */
.header-logo {
    margin-top: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 200px;
    margin-right: 100px;
}

.header.header-fixed .header-logo {
    margin-top: 0px;
}

.header-logo img {
    max-height: 60px;
}

.header-logo img:nth-child(1) {
    max-height: 160px;
}

/* menu */
.header-menu {
    margin-top: 20px;
}

.header.header-fixed .header-menu {
    margin-top: 0px;
}

.header-menu .nav li {
    border-radius: 13px 13px 0px 0px;
}

.header-menu .nav li a {
    line-height: 23px;
    padding: 8px 25px 0px 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: var(--principal-portal);
    font-weight: bold;
    font-size: 0.8rem;
}

.header-menu .nav li a img {
    height: 30px;
    width: 30px;
}
.header-menu .nav li a img.img_mis_subastas {
    width: 33px;
}

.header-menu .nav li a {
    color: var(--bg6);
}
.header-menu .nav li:hover a {
    color: var(--bg6);
}
.header-menu .nav li.active a:active,
.header-menu .nav li.active a:focus {
    color: white;
}

.header-menu .nav li.active:hover a {
    color: white;
}

.header-menu .nav li.active {
    background-color: var(--principal-portal);
}

.header-menu .nav li.active a {
    color: white;
}

.header-menu .nav li.active a img {
    filter: brightness(0) invert(1);
}

/* REGISTRO */
.header-registro .nav {
}
.header .header-nav.header-registro:last-child {
    width: auto;
}

.header-registro .nav {
    display: flex;
    flex-direction: column;
}

.header .header-nav.header-registro .nav > li > a {
    display: flex;
    justify-items: center;
    align-items: center;
    gap: 4px;
    line-height: 0px;
    color: var(--principal-portal);
    font-weight: bold;
}

.header-registro .nav li {
    display: flex;
    height: 30px;
}

.header-registro .nav li a {
    padding: 3px;
    margin: 3px;
    height: 30px;
}

.icon-1 {
    height: 17px;
}

.header-registro .dropdown.dropdown-hover {
    margin-top: 20px;
    height: 100%;
}

.header-registro .dropdown.dropdown-hover .dropdown-menu {
    border-color: var(--principal-portal);
    margin-top: 40px;
}
@media (max-width: 800px) {
    .header.header-fixed {
        height: 66px;
    }

    .header-logo {
        margin-right: 0px;
    }

    .header-logo img:nth-child(2) {
        display: none;
    }

    .header {
        height: 85px;
    }
    .header-logo {
        margin-top: 0px;
    }

    .header-logo img:nth-child(1) {
        max-width: 180px;
    }

    .header-registro .dropdown.dropdown-hover .dropdown-menu.show {
        margin-top: -20px !important;
    }

    .header-menu .nav li a {
        justify-content: start;
        flex-direction: row;
        font-weight: bold;
        padding: 10px 20px;
        font-size: 1rem;
    }
    .header-menu .nav li a img {
        margin-right: 2px;
    }

    .header-menu .nav li {
        border-radius: 0px;
    }

    .header-registro .nav {
        display: flex;
        flex-direction: row;
    }

    .header-registro .nav img {
        height: 30px;
    }
}
</style>
