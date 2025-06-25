<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Terrenos</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 1.5cm;
            margin-bottom: 0.3cm;
            margin-left: 0.3cm;
            margin-right: 0.3cm;
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
            font-size: 7pt;
        }

        table tbody tr td {
            font-size: 6pt;
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 100px;
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
            background: rgb(202, 202, 202);
        }

        .bg-principal {
            background: #153f59;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        ul {
            list-style: none;
            padding: 0px;
            padding-left: 5px;
        }

        .txtmd {
            font-size: 9pt;
        }

        .bold {
            font-weight: bold;
        }

        .derecha {
            text-align: right;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ $configuracion->first()->logo_b64 }}">
        </div>
        <h2 class="titulo">
            {{ $configuracion->first()->nombre_sistema }}
        </h2>
        <h4 class="texto">LISTA DE TERRENOS</h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>
    <table border="1">
        <thead class="bg-principal">
            <tr>
                <th>MUNICIPIO</th>
                <th>URBANIZACIÓN</th>
                <th>MANZANO</th>
                <th>NOMBRE</th>
                <th>ESPECIFICACIONES DEL TERRENO</th>
                <th>SERVICIOS BÁSICOS</th>
                <th>EQUIPAMIENTO URBANO CERCANO</th>
                <th>TIPO DE CONSTRUCCIONES CERCANAS</th>
                <th>ESTADO DEL VECINDARIO</th>
                <th width="6%">COSTO AL CONTADO</th>
                <th width="6%">COSTO A CRÉDITO</th>
                <th width="5%">FECHA DE REGISTRO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
                $total_contado = 0;
                $total_credito = 0;
            @endphp
            @foreach ($terrenos as $terreno)
                <tr>
                    <td>{{ $terreno->municipio->nombre }}</td>
                    <td>{{ $terreno->urbanizacion->nombre }}</td>
                    <td>{{ $terreno->manzano->nombre }}</td>
                    <td>{{ $terreno->nombre }}</td>
                    <td>
                        <ul>
                            <li>Tipo de calle: {{ $terreno->tipo_calle }}</li>
                            <li>Ancho de calle: {{ $terreno->ancho_calle }}</li>
                            <li>Conectividad: {{ $terreno->conectividad }}</li>
                            <li>Tráfico y Flujo Vehicular: {{ $terreno->trafico }}</li>
                            <li>Tipo de Zona: {{ $terreno->tipo_zona }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>Agua Potable: {{ $terreno->agua_potable == 1 ? 'SI' : '' }}</li>
                            <li>Alcantarillado: {{ $terreno->alcantarillado == 1 ? 'SI' : '' }}</li>
                            <li>Energía Eléctrica: {{ $terreno->energia_electrica == 1 ? 'SI' : '' }}</li>
                            <li>Gas Natural: {{ $terreno->gas_natural == 1 ? 'SI' : '' }}</li>
                            <li>Alumbrado Público: {{ $terreno->alumbrado == 1 ? 'SI' : '' }}</li>
                            <li>Recolección de Basura: {{ $terreno->recoleccion_basura == 1 ? 'SI' : '' }}</li>
                            <li>Conexión a Internet: {{ $terreno->conexion_internet == 1 ? 'SI' : '' }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>Escuelas: {{ $terreno->escuelas == 1 ? 'SI' : '' }}</li>
                            <li>Centros Educativos: {{ $terreno->centros_educativos == 1 ? 'SI' : '' }}</li>
                            <li>Hospitales: {{ $terreno->hospitales == 1 ? 'SI' : '' }}</li>
                            <li>Centros de Salud: {{ $terreno->centros_salud == 1 ? 'SI' : '' }}</li>
                            <li>Centros Comerciales: {{ $terreno->centros_comerciales == 1 ? 'SI' : '' }}</li>
                            <li>Mercados: {{ $terreno->mercados == 1 ? 'SI' : '' }}</li>
                            <li>Tiendas: {{ $terreno->tiendas == 1 ? 'SI' : '' }}</li>
                            <li>Parques: {{ $terreno->parques == 1 ? 'SI' : '' }}</li>
                            <li>Plazas: {{ $terreno->plazas == 1 ? 'SI' : '' }}</li>
                            <li>Espacios Recreativos: {{ $terreno->espacios_recreativos == 1 ? 'SI' : '' }}</li>
                            <li>Iglesas: {{ $terreno->iglesias == 1 ? 'SI' : '' }}</li>
                            <li>Oficinas Gubernamentales: {{ $terreno->oficinas_gubernamentales == 1 ? 'SI' : '' }}
                            </li>
                            <li>Oficinas de Servicios Básicos: {{ $terreno->oficinas_servicios == 1 ? 'SI' : '' }}</li>
                            <li>Bancos: {{ $terreno->bancos == 1 ? 'SI' : '' }}</li>
                            <li>Presencia de Áreas Verdes: {{ $terreno->areas_verdes }}</li>
                            <li>Nivel de Urbanización: {{ $terreno->nivel_urbanizacion }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>Seguro: {{ $terreno->seguro == 1 ? 'SI' : '' }}</li>
                            <li>Limpio: {{ $terreno->limpio == 1 ? 'SI' : '' }}</li>
                            <li>En Desarrollo: {{ $terreno->en_desarrollo == 1 ? 'SI' : '' }}</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li>Viviendas: {{ $terreno->viviendas == 1 ? 'SI' : '' }}</li>
                            <li>Negocios: {{ $terreno->negocios == 1 ? 'SI' : '' }}</li>
                            <li>Bodegas: {{ $terreno->bodegas == 1 ? 'SI' : '' }}</li>
                            <li>Galpones: {{ $terreno->galpones == 1 ? 'SI' : '' }}</li>
                            <li>Terrenos Baldíos: {{ $terreno->terrenos_baldios == 1 ? 'SI' : '' }}</li>
                            <li>Topografía del Terreno y su Entorno: {{ $terreno->topografia_entorno }}</li>
                            <li>Superficie del Terreno: {{ $terreno->topografia_entorno }}</li>
                        </ul>
                    </td>
                    <td>{{ number_format($terreno->costo_contado, 2, '.', ',') }}</td>
                    <td>{{ number_format($terreno->costo_credito, 2, '.', ',') }}</td>
                    <td>{{ $terreno->fecha_registro_t }}</td>
                    @php
                        $total_contado += (float) $terreno->costo_contado;
                        $total_credito += (float) $terreno->costo_credito;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="9" class="bold txtmd derecha">TOTAL</td>
                <td class="bold txtmd">{{ number_format($total_contado, 2, '.', ',') }}</td>
                <td class="bold txtmd">{{ number_format($total_credito, 2, '.', ',') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
