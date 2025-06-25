<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>EspecificacionTerrenos</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
            page-break-before: avoid;
        }

        table thead tr th,
        tbody tr td {
            padding: 3px;
            word-wrap: break-word;
        }

        table thead tr th {
            font-size: 8pt;
        }

        table tbody tr td {
            font-size: 7pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 70px;
            top: -20px;
            left: 0px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 0PX;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(236, 236, 236)
        }

        tr {
            page-break-inside: avoid !important;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(236, 236, 236)
        }

        .bg-principal {
            background: #153f59;
            color: white;
        }

        .img_celda img {
            width: 45px;
        }

        .bold {
            font-weight: bold;
        }

        .page_break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    @php
        $cont = 0;
    @endphp
    @foreach ($terrenos as $terreno)
        <div class="encabezado">
            <div class="logo">
                <img src="{{ $configuracion->first()->logo_b64 }}">
            </div>
            <h2 class="titulo">
                {{ $configuracion->first()->nombre_sistema }}
            </h2>
            <h4 class="texto">ESPECIFICACIONES DE TERRENOS</h4>
            <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
        </div>
        <table border="1">
            <tbody>
                <tr>
                    <td class="bold gray" width="18%">Municipio</td>
                    <td>{{ $terreno->municipio->nombre }}</td>
                    <td class="bold gray" width="18%">Urbanización</td>
                    <td>{{ $terreno->urbanizacion->nombre }}</td>
                </tr>
                <tr>
                    <td class="bold gray">Manzano</td>
                    <td>{{ $terreno->manzano->nombre }}</td>
                    <td class="bold gray">Nombre</td>
                    <td>{{ $terreno->nombre }}</td>
                </tr>
                <tr>
                    <td class="bold gray centreado" colspan="4">ESPECIFICACIONES DEL TERRENO</td>
                </tr>
                <tr>
                    <td class="bold gray">Tipo de calle</td>
                    <td>{{ $terreno->tipo_calle }}</td>
                    <td class="bold gray">Ancho de calle</td>
                    <td>{{ $terreno->ancho_calle }}</td>
                </tr>
                <tr>
                    <td class="bold gray">Conectividad</td>
                    <td>{{ $terreno->conectividad }}</td>
                    <td class="bold gray">Tráfico y Flujo Vehicular</td>
                    <td>{{ $terreno->trafico }}</td>
                </tr>
                <tr>
                    <td class="bold gray">Tipo de Zona</td>
                    <td>{{ $terreno->tipo_zona }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="bold gray" colspan="4">Servicios Básicos:</td>
                </tr>
                <tr>
                    <td class="bold gray">Agua Potable</td>
                    <td>{!! $terreno->agua_potable == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Alcantarillado</td>
                    <td>{!! $terreno->alcantarillado == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Energía Eléctrica</td>
                    <td>{!! $terreno->energia_electrica == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Gas Natural</td>
                    <td>{!! $terreno->gas_natural == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Alumbrado Público</td>
                    <td>{!! $terreno->alumbrado == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Recolección de Basura</td>
                    <td>{!! $terreno->recoleccion_basura == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Conexión a Internet</td>
                    <td>{!! $terreno->conexion_internet == 1 ? 'SI' : '' !!}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="bold gray" colspan="4">Equipamiento Urbano Cercano:</td>
                </tr>
                <tr>
                    <td class="bold gray">Escuelas</td>
                    <td>{!! $terreno->escuelas == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Centros Educativos</td>
                    <td>{!! $terreno->centros_educativos == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Hospitales</td>
                    <td>{!! $terreno->hospitales == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Centros de Salud</td>
                    <td>{!! $terreno->centros_salud == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Centros Comerciales</td>
                    <td>{!! $terreno->centros_comerciales == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Mercados</td>
                    <td>{!! $terreno->mercados == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Tiendas</td>
                    <td>{!! $terreno->tiendas == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Parques</td>
                    <td>{!! $terreno->parques == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Plazas</td>
                    <td>{!! $terreno->plazas == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Espacios Recreativos</td>
                    <td>{!! $terreno->espacios_recreativos == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Iglesias</td>
                    <td>{!! $terreno->iglesias == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Oficinas Gubernamentales</td>
                    <td>{!! $terreno->oficinas_gubernamentales == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Oficinas de Servicios Básicos</td>
                    <td>{!! $terreno->oficinas_servicios == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Bancos</td>
                    <td>{!! $terreno->bancos == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Presencia de Áreas Verdes</td>
                    <td>{{ $terreno->areas_verdes }}</td>
                    <td class="bold gray">Nivel de Urbanización</td>
                    <td>{{ $terreno->nivel_urbanizacion }}</td>
                </tr>
                <tr>
                    <td class="bold gray" colspan="4">Estado del Vecindario:</td>
                </tr>
                <tr>
                    <td class="bold gray">Seguro</td>
                    <td>{!! $terreno->seguro == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Limpio</td>
                    <td>{!! $terreno->limpio == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">En Desarrollo</td>
                    <td>{!! $terreno->en_desarrollo == 1 ? 'SI' : '' !!}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="bold gray" colspan="4">Tipo de Construcciones Cercanas:</td>
                </tr>
                <tr>
                    <td class="bold gray">Viviendas</td>
                    <td>{!! $terreno->viviendas == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Negocios</td>
                    <td>{!! $terreno->negocios == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Bodegas</td>
                    <td>{!! $terreno->bodegas == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Galpones</td>
                    <td>{!! $terreno->galpones == 1 ? 'SI' : '' !!}</td>
                </tr>
                <tr>
                    <td class="bold gray">Terrenos Baldíos</td>
                    <td>{!! $terreno->terrenos_baldios == 1 ? 'SI' : '' !!}</td>
                    <td class="bold gray">Topografía del Terreno y su Entorno</td>
                    <td>{{ $terreno->topografia_entorno }}</td>
                </tr>
                <tr>
                    <td class="bold gray">Superficie del Terreno</td>
                    <td>{{ $terreno->superficie_terreno }}</td>
                    <td class="bold gray">Costo al Contado</td>
                    <td>{{ $terreno->costo_contado }}</td>
                </tr>
                <tr>
                    <td class="bold gray">Costo a Crédito</td>
                    <td>{{ $terreno->costo_credito }}</td>
                    <td class="bold gray">Públicado</td>
                    <td>{{ $terreno->publicar }}</td>
                </tr>
            </tbody>
        </table>
        @php
            $cont++;
        @endphp
        @if ($cont < count($terrenos))
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
