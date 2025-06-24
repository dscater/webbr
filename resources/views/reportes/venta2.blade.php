div
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden de ventas</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 2cm;
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
            font-size: 7pt;
            word-wrap: break-word;
        }

        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            height: 60px;
            top: -20px;
            left: -20px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 0px;
            margin-bottom: 0px;
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

        table thead tr th {
            padding: 3px;
            font-size: 0.85em;
        }

        table tbody tr td {
            padding: 3px;
            font-size: 0.75em;
        }

        table tbody tr td.franco {
            background: red;
            color: white;
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

        .p_cump {
            color: red;
            font-size: 1.2em;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(236, 236, 236)
        }

        .green {
            background: #ffc107;
            color: black;
        }

        .derecha {
            text-align: right;
            padding-right: 3px;
        }

        .izquierda {
            text-align: left;
            padding-left: 3px;
            font-weight: normal
        }

        .img_celda img {
            width: 45px;
        }

        .bold {
            font-weight: bold;
        }

        .descrip {
            width: 100%;
            text-align: center;
            font-size: 8pt;
        }

        .tabla_info {
            border-collapse: separate;
            border-spacing: 0px 7px;
        }

        .tabla_info {
            font-size: 11pt;
        }

        .punteado {
            border-bottom: dotted 1px black;
        }

        .borderbottom {
            border-bottom: solid 1px;
        }

        .nro_recibo {
            font-weight: bold;
            position: absolute;
            height: 60px;
            top: -20px;
            right: -20px;
            color: #21BBEF;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .derecha {
            text-align: right;
            padding-right: 8px;
        }

        .font12 {
            font-size: 11pt;
        }

        .cancelado {
            margin-top: 10px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 12;
            color: #15aadb;
        }

        .texto2 {
            font-size: 11pt;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ $configuracion->first()->logo_b64 }}">
        </div>
        <div class="nro_recibo">
            N° 0009134
        </div>
        <h2 class="titulo">
            EMSYT S.R.L
        </h2>
        <p class="descrip">La Paz – Bolivia, Calle Figueroa esq.<br /> Graneros Edificio San Juan N°692 4to Piso N°402.
        <p class="descrip">Teléfono(s): +591 65773211 - +591 73594451<br />
        </p>
        <h4 class="texto mb-0" style="margin-bottom: 0px;">RECIBO</h4>
        <p class="descrip" style="margin-top: 0px;">(Expresado en Bolivianos)
    </div>
    <table class="tabla_info">
        <tbody>
            <tr class="pb5">
                <th class="derecha" width="16%">Fecha:</th>
                <th class="izquierda punteado" colspan="3">23/06/2025</th>
            </tr>
            <tr>
                <th class="derecha">A nombre de:</th>
                <th class="izquierda punteado" colspan="3">Labeet srl</th>
            </tr>
            <tr>
                <th class="derecha">C.I./NIT:</th>
                <th class="izquierda punteado" colspan="3">483184022</th>
            </tr>
        </tbody>

    </table>
    <table>
        <thead>
            <tr class="">
                <th class="borderbottom bold centreado" width="4%">N°</th>
                <th class="borderbottom bold centreado">Detalle</th>
                <th class="borderbottom bold centreado" width="10%">Cantidad</th>
                <th class="borderbottom bold centreado" width="10%">P/U</th>
                <th class="borderbottom bold centreado" width="14%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr class="borderbottom">
                <td class="centreado">1</td>
                <td>Cable de red categoría 5e</td>
                <td class="centreado">15</td>
                <td class="centreado">4.50</td>
                <td class="derecha">67.50</td>
            </tr>
            <tr class="borderbottom">
                <td class="centreado">2</td>
                <td>RJ 45</td>
                <td class="centreado">2</td>
                <td class="centreado">0.75</td>
                <td class="derecha">1.50</td>
            </tr>
            <tr class="borderbottom gray">
                <td class="derecha bold font11" colspan="4">TOTAL</td>
                <td class="bold centreado derecha font11">69.00</td>
            </tr>
        </tbody>
    </table>
    <h4 class="texto2 mb-0" style="margin-bottom: 0px;">Son: Sesenta y nueve 00/100 Bolivianos"</h4>
    <div class="cancelado">
        <img src="{{ $configuracion->first()->firma_b64 }}" style="display: block; height:120px;"><br/>
        CANCELADO
    </div>
</body>

</html>
