<?php
require_once AS_PATH . '/html2pdf/vendor/autoload.php';

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
        $contacto_info              = $data['contacto_info'];
        $salesperson_info           = $data['salesperson_info'];
        $incluirFirma               = isset( $data['incluirFirma'] )? $data['incluirFirma']: '';
        $usersignature              = isset( $data['usersignature'] ) ? $data['usersignature']: '';
        $telefonos_contacto = array();
        
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
            font-family: Tahoma, Geneva, sans-serif;
        }

        h2{
            font-size: 18px;
            margin: 10px 0;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table p, .section_content p{
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

        .cot_lines{
            padding-top: 12px;
            font-size: 12px;
        }

        .cot_lines th{
            background: #eaeaea;
            padding: 4px 0;
            text-align: center;
        }

        .cot_hline_no{
            width: 6%;
            text-align: center;
        }

        .cot_hline_desc, .cot_line_desc{
            width: 58%;
            padding-right: 8px;
        }

        .cot_line_desc{
            font-weight: 400;
        }

        .cot_hline_amount, .cot_hline_measure{
            width: 6%;
        }

        .cot_hline_uprice, .cot_hline_tprice{
            width: 12%;
        }

        .cot_line_content td{
            padding: 6px 2px;
            border-bottom: 1px solid #d0d0d0;
            height: 158px;
            vertical-align: top;
            font-size: 12px;  
        }

        .cot_line_codigo{
            padding-bottom: 10px;
        }

        .table_content{
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .section_content{
            width: 100%;
            border-top: 2px solid #808080;
        }

        .section_content h2{
            margin-top: 20px;
        }

        .section_content p{
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

        .salesperson{
            font-size: 16px;
            text-align: center;
            padding: 10px 0;
        } 
        </style>
        <page style="font-size: 13px" backleft="8mm" backtop="5mm" backright="8mm" backbottom="5mm">
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
                <tr class="cot_line_content">
                    <td class="text_center">
                        <b><?php  echo $i +1; ?></b>
                    </td>
                    <td class="cot_line_desc">
                        <p class="cot_line_codigo"><b>Código: <?php echo $lineas[$i]['codigoArticulo']; ?></b></p>
                        <b><?php echo $lineas[$i]['nombreArticulo']; ?></b>
                        <br>
                        <br>
                        <?php echo preg_replace( "/\r|\n/", "<br>", $lineas[$i]['descripcionArticulo'] ); ?>
                    </td>
                    <td class="text_center">
                        <p><?php echo $lineas[$i]['cantidad']; ?></p>
                    </td>
                    <td class="text_center">
                        <p><?php echo $lineas[$i]['unidadMedida']; ?></p>
                    </td>
                     <td>
                        <p><?php echo $lineas[$i]['precioUnitarioFormated']; ?></p>
                    </td>
                     <td>
                        <p><?php echo $lineas[$i]['montoFormated']; ?></p>
                    </td>
                </tr>
            <?php endfor; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>Sub-total</p>
                        </td>
                        <td>
                            <p><?php echo $subtotalFormated; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>Descuento</p>
                        </td>
                        <td>
                            <p><?php echo $totalDescuentoFormated; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>I.V.</p>
                        </td>
                        <td class="border_bottom">
                            <p><?php echo $totalIvaFormated; ?></p>
                        </td>
                    </tr>
                    <tr class="border_bottom">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>Total</p>
                        </td>
                        <td>
                            <p><?php echo $totalFormated; ?></p>
                        </td>
                    </tr>
            </table> <!-- lines end  -->
            <?php if( !empty($notasCotizacion) ) :?>
                <table class="table_content">
                    <tr>
                        <td class="section_content no-border">
                            <h2>Observaciones</h2>
                            <p><?php echo preg_replace( "/\r|\n/", "<br>", $notasCotizacion ); ?></p>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
            <!--<br>
            <br>
            <br>-->
            <table class="table_content">
                <tr>
                    <td class="section_content">
                        <h2>Observaciones</h2>
                        <p>1. Toda anulación de pedido con trámite de importación directa, tiene un cargo de 25% sobre el valor total de la orden de compra si el pedido ya se encuentra procesado en fábrica o está listo para despacharse.</p>
                        <p>2. Cantidades sujetas a las existencias en bodega al momento de realizar la compra.</p>
                        <p>3. Precios válidos por las cantidades e ítems indicados en esta cotización.</p>
                    </td>
                </tr>
            </table>
            <!--<br>
            <br>
            <br>-->
            <table class="table_content">
                <tr>
                    <td class="section_content">
                        <h2>Términos y condiciones</h2>
                        <p><b>Tiempo de entrega:</b> <?php echo $tiempoEntrega; ?></p>
                        <p><b>Lugar de entrega:</b> <?php echo $lugarEntrega; ?></p>
                        <p><b>Forma de pago:</b> <?php echo $formaPago; ?></p>
                        <p><b>Cuentas bancarias:</b> Banco Nacional COLONES No. 100-01-000-195665-5 / CLIENTE 15100010011956657; DÓLARES No. 100-02-000-613588-3 / CLIENTE 15100010026135883. Banco Costa Rica COLONES No. 001-0223717-2 / CLIENTE 15201001022371722. DaVivienda COLONES No. 91423031919 / CLIENTE 10400003472040113. Scotiabank COLONES No. 013000662300 / CLIENTE 12300130006623006; DÓLARES No. 013000662301 / CLIENTE 12300130006623012 . BAC San José COLONES No. 900554270 / CLIENTE 10200009005542707.</p>
                        <p><b>Pagos desde el exterior:</b> Para pagos realizados desde el exterior favor agregar comisión bancaria local según indicaciones de nuestros asesores e indicar a su Banco que a TecnoSagot S.A. le debe llegar el monto asegurado, cancelando por su parte la comisión correspondiente. El producto será despachado una vez se confirme la transacción con el banco.</p>
                    </td>
                </tr>
            </table>
            <!--<br>
            <br>
            <br>-->
            <table class="table_content">
                <tr>
                    <td class="section_content">
                        <br>
                        <br>
                        <p>Esperamos que esta propuesta sea de su agrado. No dude en contactarnos para cualquier consulta adicional</p>
                        <br>
                        <br>
                        <p class="txt_center">Cordialmente</p>
                        <?php if( $incluirFirma && $usersignature ): ?>
                            <p class="txt_center"><img src="<?php echo $usersignature; ?>"></p>
                        <?php endif; ?>
                        <p class="salesperson"><b><?php echo $salesperson_info['completename'];?> <?php echo ( !empty( $salesperson_info['jobtitle'] ) ? ' - '. $salesperson_info['jobtitle'] : '' ); ?> </b></p>
                        <p class="txt_center">Teléfono: <?php echo $salesperson_info['officephone'];?> - Celular: <?php echo $salesperson_info['mobilephone'];?> </p>
                        <p class="txt_center">Correo: <?php echo $salesperson_info['emailaddress'];?> - Visítenos en <a href="http://www.tecnosagot.com">www.tecnosagot.com</a></p>
                        <p class="txt_center">TecnoSagot S.A. - Cédula jurídica: 3-101-077573</p>
                        <p class="txt_center">La Uruca. San José. Costado sur de la rotonda Juan Pablo II. Autopista General Cañas.</p>
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
            $html2pdf = new HTML2PDF($orientation, $format, $lang);
            $html2pdf->WriteHTML($content);
            $html2pdf->Output( $filename, 'D');
        }
        catch(HTML2PDF_exception $e){
            echo 'error';
        }

    }
}
