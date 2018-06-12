<?php
require_once AS_PATH . '/html2pdf/vendor/autoload.php';
date_default_timezone_set('America/Costa_Rica');
class PDF {
    public static function generateHtml($data){
        $fechaCotizacion	        = $data['fechaCotizacion'];
        $fechaVencimiento	        = $data['fechaVencimiento'];
        $noSolicitud 		        = $data['noSolicitud'];
        $noCotizacion 	 	        = $data['noCotizacion'];
        $company_id 		        = $data['company_id'] ;
        $contact_id 		        = $data['contact_id'];
        $tiempoEntrega 	            = $data['tiempoEntrega'];
        $lugarEntrega		        = $data['lugarEntrega'];
        $formaPago 		            = $data['formaPago'];
        $marca 				        = $data['marca'];
        $fase 				        = $data['fase'];
        $notasCotizacion 	        = $data['notasCotizacion'];
        $notasCRM 			        = $data['notasCRM'];
        $subtotalFormated 			= $data['subtotalFormated'];
        $totalDescuentoFormated 	= $data['totalDescuentoFormated'];
        $totalDescuentoFormated 	= $data['totalDescuentoFormated'];
        $totalIvaFormated 			= $data['totalIvaFormated'];
        $totalFormated				= $data['totalFormated'];
        $tasaCambio		            = $data['tasaCambio'];
        $lineas				        = $data['lineas'];
        $company_info               = $data['company_info'];
        $contacto_info              = empty( $data['contacto_info'] ) ? array(): $data['contacto_info'];
        $salesperson_info           = $data['salesperson_info'];
        $usersignature              = isset( $data['usersignature'] ) ? $data['usersignature']: '';
        $telefonos_contacto         = array();
        $showObservations           = isset( $data['showObservations'] );
        
        if( isset( $contacto_info['officephone'] ) ){
            $telefonos_contacto[] = $contacto_info['officephone'];
        }

        if( isset( $contacto_info['mobilephone'] ) ){
            $telefonos_contacto[] = $contacto_info['mobilephone'];
        }

        $telefonos_contacto = join( ' / ',  $telefonos_contacto);


        ob_start();
        ?>
        <style type="text/Css">
        body {
            font-size: 12px;
        }

        h2{
            font-size: 18px;
            margin: 10px 0;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table p, p.section_content{
            padding: 2px 0;
            margin: 0;
        }

        .txt_to_right{
            text-align: right;
        }

        .text_center{
            text-align: center;
        }

        .cot_header td{
            width: 50%;
        }

        .cot_subheader{
            padding-top: 0;
            padding-bottom: 40px;
        }

        .cot_subheader td{
            border: solid 1px #d0d0d0;
            padding: 6px;
            width: 50%;
            vertical-align: top;
        }

        .border--left{
            border-left: solid 1px #d0d0d0;
            
        }

        .border--right{
            border-right: solid 1px #d0d0d0;
            
        }

        .cot_lines{
            padding-top: 12px;
            font-size: 12px;
        }

        .cot_lines th{
            background: #eaeaea;
            padding: 4px 0;
            text-align: center;
        }

        .cot_hline_no, .cot_line_no{
            width: 6%;
            text-align: center;
        }

        .cot_hline_desc, .cot_line_desc{
            width: 54%;
            padding-right: 8px;
        }

        .cot_line_desc{
            font-weight: 400;
        }

        .cot_hline_amount, .cot_hline_measure, .cot_line_amount, .cot_line_measure{
            width: 6%;
        }

        .cot_hline_uprice, .cot_hline_tprice, .cot_line_uprice, .cot_line_tprice{
            font-size: 12px;
            width: 14%;
        }

        .cot_line_tprice{
            text-align: right;
            padding-right: 2px;
        }        

        .cot_line_content td{
            padding: 6px 2px;
            /*height: 158px;*/
            vertical-align: top;
            font-size: 12px;  
        }

        .no_padding{
            padding: 0;
            margin: 0;
        }

        .no_padding td, .no_padding .cot_line_desc{ 
            padding: 0 2px;
            margin: 0;
            line-height: 12px;
        }
    
        .cot_line_codigo{
            padding-bottom: 10px;
        }

        h2.section_content{
            border-top: 2px solid #808080;
            margin-top: 15px;
        }

        p.section_content{
            line-height: 18px;
        }

        .no-border{
            border: none;
        }

        .border_bottom, .border_bottom td{
            border-bottom: 1px solid #d0d0d0;
        }

        .txt_center{
            text-align: center;
        }

        .txt_right{
            text-align: right;
        }

        .salesperson{
            font-size: 16px;
            text-align: center;
            padding: 10px 0;
        } 

        img.signature{
            max-width: 240px;
            max-height: 80px;
        }

        .mrg-top{
            margin-top: 15px;
        }

        .table_content, .table_content td, .table_content tr{
            width: 100%;
        }
        </style>
        <page style="font-size: 13px" backleft="8mm" backtop="5mm" backright="8mm" backbottom="5mm">
            <page_header></page_header>
            <table class="cot_header">
                <tr>
                    <td>
                        <img src="<?php echo AS_PATH ?>/css/images/logo.png">
                    </td>
                    <td class="txt_to_right">
                        <h2>Cotización</h2>
                        <p>Vigente hasta: <?php echo $fechaVencimiento; ?></p>
                        <p>Número de cotización: <?php echo ( isset( $company_info['cuentascstm'] ) ? $company_info['cuentascstm'] . '-' : '' ) . $noCotizacion; ?></p>
                    </td>
                </tr>
            </table>
            <table class="cot_subheader">
                <tr>
                    <td>
                        <p>Empresa: <?php echo $company_info['name']; ?></p>
                        <p>Cédula jurídica: <?php echo $company_info['cedula_juridcstm']; ?></p>
                        <p>Contacto: <?php echo $contacto_info['completename']; ?></p>
                        <p>Solicitud Nº: <?php echo $noSolicitud; ?></p>
                    </td>
                    <td>
                        <p>Fecha: <?php echo $fechaCotizacion; ?></p>
                        <p>Teléfono: <?php echo $telefonos_contacto; ?></p>
                        <p>Fax: <?php echo $company_info['officefax']; ?></p>
                        <p>Correo: <?php echo $contacto_info['emailaddress']; ?></p>
                    </td>
                </tr>
            </table>
            <p>En atención a su solicitud, es un gusto presentarle la siguiente oferta:</p>
            <table class="cot_lines">
                <thead>
                    <tr>
                        <th class="cot_hline_no">Línea</th>
                        <th class="cot_hline_desc">Descripción</th>
                        <th class="cot_hline_amount">Cant.</th>
                        <th class="cot_hline_measure">U.M</th>
                        <th class="cot_hline_uprice">Precio <br>unitario</th>
                        <th class="cot_hline_tprice">Precio <br>total</th>
                    </tr>
                </thead>
            <?php for($i = 0, $count = count($lineas);  $i < $count ;$i++ ): ?>
                <?php 
                    $str = preg_replace( "/\n|\r/", " <br> ", $lineas[$i]['descripcionArticulo'] ); 
                    $matches = array();
                    preg_match_all('/[^ ]+/', $str, $matches);
                    $paragraph_lines = array();
                    $current_line = 0;
                    $MAX_LENGTH = 70;

                    if( !empty($matches[0]) ){
                        foreach( $matches[0] as $word ){
                            if(empty($paragraph_lines[$current_line])){
                                $paragraph_lines[$current_line] = '';
                            }

                            $paragraph_line_length = strlen( $paragraph_lines[$current_line] );
                            $word_length = strlen( $word );

                            if( $word == "<br>" ){
                                $paragraph_lines[$current_line] .= $word;
                                $current_line++;
                            }
                            else if( $paragraph_line_length + $word_length < $MAX_LENGTH ){
                                $paragraph_lines[$current_line] .= $word . ' ';
                            }
                            else{
                                $current_line++;
                                $paragraph_lines[$current_line] = $word . ' ';

                                if( $word_length >= $MAX_LENGTH ){
                                    $current_line++;
                                }
                            }
                        }
                    }
                    else{
                        $paragraph_lines[0] = '';
                    }
               ?>


                <tr class="cot_line_content">
                    <td class="text_center border--left">
                        <b><?php  echo $i +1; ?></b>
                    </td>
                    <td class="cot_line_desc">
                        <p class="cot_line_codigo"><b>Código: <?php echo $lineas[$i]['codigoArticulo']; ?></b></p>
                        <b><?php echo $lineas[$i]['nombreArticulo']; ?></b>
                        <br>
                        <br>
                    </td>
                    <td class="text_center">
                        <p><?php echo $lineas[$i]['cantidad']; ?></p>
                    </td>
                    <td class="text_center">
                        <p><?php echo $lineas[$i]['unidadMedida']; ?></p>
                    </td>
                     <td class="txt_right">
                        <p><?php echo $lineas[$i]['precioUnitarioFormated']; ?></p>
                    </td>
                     <td class="border--right txt_right">
                        <p><?php echo $lineas[$i]['montoFormated']; ?></p>
                    </td>
                </tr>

                <?php for( $p = 0, $p_length = count( $paragraph_lines ); $p < $p_length; $p++ ): ?>
                    <?php $last_p_line = ( $p == $p_length -1 );  ?>
                    <tr class="cot_line_content no_padding <?php echo ( $last_p_line ? "border_bottom" : ""); ?>">
                        <td class="border--left"></td>
                        <td class="cot_line_desc">
                            <?php echo $paragraph_lines[$p]; ?>
                            <?php if ( $last_p_line  )  echo "<br><br>"; ?>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border--right"></td>
                    </tr>
                <?php endfor; ?>

            <?php endfor; ?>
            </table>
            <div style="page-break-inside: avoid;">
            <table style="width: 100%;">
                    <tr>
                        <td class="cot_line_no border--left"> </td>
                        <td class="cot_line_desc"> </td>
                        <td class="cot_line_amount"> </td>
                        <td class="cot_line_measure"> </td>
                        <td class="cot_line_uprice"><p>Sub-total</p></td>
                        <td class="cot_line_tprice border--right"><?php echo $subtotalFormated; ?></td>
                    </tr>
                    <tr>
                        <td class="cot_line_no border--left"></td>
                        <td class="cot_line_desc"></td>
                        <td class="cot_line_amount"></td>
                        <td class="cot_line_measure"></td>
                        <td class="cot_line_uprice"><p>Descuento</p></td>
                        <td class="cot_line_tprice border--right"><p><?php echo $totalDescuentoFormated; ?></p></td>
                    </tr>
                    <tr>
                        <td class="cot_line_no border--left"></td>
                        <td class="cot_line_desc"></td>
                        <td class="cot_line_amount"></td>
                        <td class="cot_line_measure"></td>
                        <td class="cot_line_uprice"><p>I.V.</p></td>
                        <td class="cot_line_tprice border_bottom border--right"><p><?php echo $totalIvaFormated; ?></p></td>
                    </tr>
                    <tr class="border_bottom">
                        <td class="cot_line_no border--left"></td>
                        <td class="cot_line_desc"></td>
                        <td class="cot_line_amount"></td>
                        <td class="cot_line_measure"></td>
                        <td class="cot_line_uprice"><p>Total</p></td>
                        <td class="cot_line_tprice border--right"><p><?php echo $totalFormated; ?></p></td>
                    </tr>
            </table> <!-- lines end  -->
            </div>
            <?php if( !empty($notasCotizacion) ) :?>
                <h2 class="section_content">Notas</h2>
                <?php $notasCotizacion = preg_replace( "/\r|\n/", "<br>", $notasCotizacion ); ?>
                <?php foreach( explode("<br>", $notasCotizacion)  as $nota ): ?>
                    <p class="section_content"><?php echo $nota; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if( $showObservations ): ?>
                <h2 class="section_content">Observaciones</h2>
                <p class="section_content">1. Toda anulación de pedido con trámite de importación directa, tiene un cargo de 25% sobre el valor total de la orden de compra si el pedido ya se encuentra procesado en fábrica o está listo para despacharse.</p>
                <p class="section_content">2. Cantidades sujetas a las existencias en bodega al momento de realizar la compra.</p>
                <p class="section_content">3. Precios válidos por las cantidades e ítems indicados en esta cotización.</p>
                <p class="section_content">4. Los precios cotizados son calculados por paquete, a no ser que se indique lo contrario.</p>
                <p class="section_content">5. Los tiempos de entrega cotizados no contemplan feriados y periodos vacacionales de las Fábricas ni de TecnoSagot.</p>
                <p class="section_content">
                    6. Toda visita técnica para diagnóstico y reparación de equipos tienen un recargo de $75/hr; en caso de que la falla se atienda como garantía, no tiene costo adicional. No proceden como garantía fallas ocasionadas por el incorrecto uso o mala instalación de los equipos.
                </p>
            <?php endif; ?>

            <h2 class="section_content">Términos y condiciones</h2>
            <p class="section_content"><b>Tiempo de entrega:</b> <?php echo $tiempoEntrega; ?></p>
            <p class="section_content"><b>Lugar de entrega:</b> <?php echo $lugarEntrega; ?></p>
            <p class="section_content"><b>Forma de pago:</b> <?php echo $formaPago; ?></p>
            <p class="section_content"><b>Cuentas bancarias:</b> Banco Nacional COLONES No. 100-01-000-195665-5 / CLIENTE 15100010011956657; DÓLARES No. 100-02-000-613588-3 / CLIENTE 15100010026135883. Banco Costa Rica COLONES No. 001-0223717-2 / CLIENTE 15201001022371722. DaVivienda COLONES No. 91423031919 / CLIENTE 10400003472040113. Scotiabank COLONES No. 013000662300 / CLIENTE 12300130006623006; DÓLARES No. 013000662301 / CLIENTE 12300130006623012 . BAC San José COLONES No. 900554270 / CLIENTE 10200009005542707.</p>
            <p class="section_content"><b>Pagos desde el exterior:</b> Para pagos realizados desde el exterior favor agregar comisión bancaria local según indicaciones de nuestros asesores e indicar a su Banco que a TecnoSagot S.A. le debe llegar el monto asegurado, cancelando por su parte la comisión correspondiente. El producto será despachado una vez se confirme la transacción con el banco.</p>


            <table class="table_content">
                <tr>
                    <td>
                        <p class="mrg-top section_content">Esperamos que esta propuesta sea de su agrado. No dude en contactarnos para cualquier consulta adicional</p>
                        <p class="txt_center mrg-top section_content">Cordialmente,</p>
                        <?php if( $salesperson_info['signature_img_path'] && file_exists( AS_PATH . $salesperson_info['signature_img_path'] ) ): ?>
                            <p class="txt_center section_content"><img class="signature" src="<?php echo AS_PATH . $salesperson_info['signature_img_path']; ?>"></p>
                        <?php endif; ?>
                        <p class="salesperson section_content"><b><?php echo $salesperson_info['completename'];?> <?php echo ( !empty( $salesperson_info['jobtitle'] ) ? ' - '. $salesperson_info['jobtitle'] : '' ); ?> </b></p>
                        <p class="txt_center section_content">Teléfono: <?php echo $salesperson_info['officephone'];?> - Celular: <?php echo $salesperson_info['mobilephone'];?> </p>
                        <p class="txt_center section_content">Correo: <?php echo $salesperson_info['emailaddress'];?> - Visítenos en <a href="http://www.tecnosagot.com">www.tecnosagot.com</a></p>
                        <p class="txt_center section_content">TecnoSagot S.A. - Cédula jurídica: 3-101-077573</p>
                        <p class="txt_center section_content">La Uruca. San José. Costado sur de la rotonda Juan Pablo II. Autopista General Cañas.</p>
                    </td>
                </tr>
            </table>
        </page>
        <?php
        return ob_get_clean();
    }

    public static function printPDF($data, $filename = 'cotizacion.pdf', $orientation = "P", $format = "A4", $lang = "es"){
        
        $content = self::generateHtml($data);
        try
        {
            $html2pdf = new HTML2PDF($orientation, array(216, 279), $lang);
            $html2pdf->setDefaultFont('tahoma');
            $html2pdf->WriteHTML($content);
            $html2pdf->Output( $filename, 'D');
        }
        catch(HTML2PDF_exception $e){
            echo 'error';
        }

    }
}
