<?php
require_once AS_PATH . '/html2pdf/vendor/autoload.php';

class PDF {
    public static function generateHtml($data){
        $fechaCotizacion	 = $data['fechaCotizacion'];
        $fechaVencimiento	 = $data['fechaVencimiento'];
        $noSolicitud 		 = $data['noSolicitud'];
        $noCotizacion 	 	 = $data['noCotizacion'];
        $company_id 		 = $data['company_id'] ;
        $contact_id 		 = $data['contact_id'];
        $tiempoEntrega 	 = $data['tiempoEntrega'];
        $lugarEntrega		 = $data['lugarEntrega'];
        $formaPago 		 = $data['formaPago'];
        $marca 				 = $data['marca'];
        $fase 				 = $data['fase'];
        $notasCotizacion 				 = $data['notasCotizacion'];
        $notasCRM 			 = $data['notasCRM'];
        $subtotalFormated 			 = $data['subtotalFormated'];
        $totalDescuentoFormated 		     = $data['totalDescuentoFormated'];
        $totalDescuentoFormated 		     = $data['totalDescuentoFormated'];
        $totalIvaFormated 			 = $data['totalIvaFormated'];
        $totalFormated				 = $data['totalFormated'];
        $tasaCambio		 = $data['tasaCambio'];
        $lineas				 = $data['lineas'];
        $company_info = $data['company_info'];
        $contacto_info = $data['contacto_info'];
        $salesperson_info = $data['salesperson_info'];
        $incluirFirma = isset( $data['incluirFirma'] )? $data['incluirFirma']: '';
        $usersignature = isset( $data['usersignature'] ) ? $data['usersignature']: '';

        ob_start();
        ?>
        <style type="text/Css">
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
        }

        .cot_hline_no{
            width: 6%;
        }

        .cot_hline_desc, .cot_line_desc{
            width: 64%;
            padding-right: 8px;
        }

        .cot_hline_amount{
            width: 6%;
        }

        .cot_hline_uprice{
            width: 12%;
        }

        .cot_hline_tprice{
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

        .section_content{
            margin-top: 40px;
            border-top: 2px solid #808080;
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
                        <p>Número de cotización: <?php echo $noCotizacion; ?></p>
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
                        <p>Teléfono: <?php echo $contacto_info['officephone']; ?></p>
                        <p>Fax: <?php echo $contacto_info['officefax']; ?></p>
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
                        <th class="cot_hline_uprice">Precio <br>unitario</th>
                        <th class="cot_hline_tprice">Precio total</th>
                    </tr>
                </thead>
            <?php for($i = 0, $count = count($lineas);  $i < $count ;$i++ ): ?>

                <tr class="cot_line_content">
                    <td>
                        <b><?php  echo $i +1; ?></b>
                    </td>
                    <td class="cot_line_desc">
                        <p class="cot_line_codigo"><b>Código:<br><?php echo $lineas[$i]['codigoArticulo']; ?></b></p>
                        <?php echo $lineas[$i]['nombreArticulo']; ?>
                        <br>
                        <br>
                        <?php echo preg_replace( "/\r|\n/", "<br>", $lineas[$i]['descripcionArticulo'] ); ?>
                    </td>
                    <td>
                        <p><?php echo $lineas[$i]['cantidad']; ?></p>
                    </td>
                     <td>
                        <p><?php echo $lineas[$i]['precioUnitarioFormated']; ?></p>
                    </td>
                     <td>
                        <p><?php echo $lineas[$i]['montoFormated']; ?></p>
                    </td>
                </tr>

            <? endfor; ?>

                
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>Sub-total</p>
                        </td>
                        <td>
                            <p><b><?php echo $subtotalFormated; ?></b></p>
                        </td>
                    </tr>
                    <tr>
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
                        <td>
                            <p>I.V</p>
                        </td>
                        <td class="border_bottom">
                            <p><?php echo $totalIvaFormated; ?></p>
                        </td>
                    </tr>
                    <tr class="border_bottom">
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
                

            </table>
            <!-- lines end  -->
            <div class="section_content">
                <h2>Términos y condiciones</h2>
                <p><b>Tiempo de entrega:</b> <?php echo $tiempoEntrega; ?></p>
                <p><b>Lugar de entrega:</b> <?php echo $lugarEntrega; ?></p>
                <p><b>Forma de pago:</b> <?php echo $formaPago; ?></p>
            </div>

            <div class="section_content">
                <br>
                <br>
                <p>Esperamos que esta propuesta sea de su agrado. No dude en contactarnos para cualquier consulta adicional</p>
                <br>
                <br>
                <p class="txt_center">Cordialmente</p>
                <?php if( $incluirFirma ): ?>
                    <p class="txt_center"><img src="<?php echo $usersignature; ?>"></p>
                <?php endif; ?>
                <p class="salesperson"><b><?php echo $salesperson_info['completename'];?> <? echo ( !empty( $salesperson_info['jobtitle'] ) ? ' - '. $salesperson_info['jobtitle'] : '' ); ?> </b></p>
                <p class="txt_center">Teleforno: <?php echo $salesperson_info['officephone'];?> - Fax:  <?php echo $salesperson_info['officefax'];?>  - Celular: <?php echo $salesperson_info['mobilephone'];?> </p>
                <p class="txt_center">Correo: <?php echo $salesperson_info['emailaddress'];?>  - Visitenos en <a href="http://www.tecnosagot.com">www.tecnosagot.com</a></p>
                <p class="txt_center">TecnoSagot S.A - Cédula jurídica: 3-101-077573</p>
                <p class="txt_center">La Uruca, frente al Centro Cormercial San José 2000, Autopista General Cañas</p>
            </div>
        </page>
        <?php
        return ob_get_clean();
    }

    public static function printPDF($data, $orientation = "P", $format = "A4", $lang = "es"){
        
        $content = self::generateHtml($data);
        $dt = new DateTime();
        $fileName = 'cotizacion_' . $data['userid'] . '_' . $dt->format('Y-m-d His') . '.pdf';
        $filePath = '/archive_pdfs/' . $fileName;
        try
        {
            
            $html2pdf = new HTML2PDF($orientation, $format, $lang);
            $html2pdf->WriteHTML($content);
            $html2pdf->Output( AS_PATH . $filePath, 'F');
        }
        catch(HTML2PDF_exception $e){
            return 'error';
        }

        return '/cotz/' . $filePath;

    }
}