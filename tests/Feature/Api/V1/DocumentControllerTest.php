<?php

namespace GenesysLite\GenesysFact\Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->json('POST', 'api/v1/documents',
            [
                "serie_documento" => "F001",
                "numero_documento" => "#",
                "fecha_de_emision" => "2018-10-09",
                "hora_de_emision" => "10:11:11",
                "codigo_tipo_operacion" => "0101",
                "codigo_tipo_documento" => "01",
                "codigo_tipo_moneda" => "PEN",
                "fecha_de_vencimiento" => "2018-10-09",
                "numero_orden_de_compra" => "0045467898",
                "datos_del_cliente_o_receptor" => [
                    "codigo_tipo_documento_identidad" => "6",
                    "numero_documento" => "10414711225",
                    "apellidos_y_nombres_o_razon_social" => "EMPRESA XYZ S.A.",
                    "codigo_pais" => "PE",
                    "ubigeo" => "150101",
                    "direccion" => "Av. 2 de Mayo",
                    "correo_electronico" => "demo@gmail.com",
                    "telefono" => "427-1148"
                ],
                "cargos" => [
                    [
                        "codigo" => "46",
                        "descripcion" => "Regarco por servicios",
                        "factor" => 0.10,
                        "monto" => 10.00,
                        "base" => 100.00
                    ]
                ],
                "totales" => [
                    "total_cargos" => 10.00,
                    "total_exportacion" => 0.00,
                    "total_operaciones_gravadas" => 100.00,
                    "total_operaciones_inafectas" => 0.00,
                    "total_operaciones_exoneradas" => 0.00,
                    "total_operaciones_gratuitas" => 0.00,
                    "total_igv" => 18.00,
                    "total_impuestos" => 18.00,
                    "total_valor" => 100,
                    "total_venta" => 110.00
                ],
                "items" => [
                    [
                        "codigo_interno" => "P0121",
                        "descripcion" => "Inca Kola 250 ml",
                        "codigo_producto_sunat" => "",
                        "codigo_producto_gsl" => "",
                        "unidad_de_medida" => "NIU",
                        "cantidad" => 2,
                        "valor_unitario" => 50,
                        "codigo_tipo_precio" => "01",
                        "precio_unitario" => 59,
                        "codigo_tipo_afectacion_igv" => "10",
                        "total_base_igv" => 100.00,
                        "porcentaje_igv" => 18,
                        "total_igv" => 18,
                        "total_impuestos" => 18,
                        "total_valor_item" => 100,
                        "total_item" => 118
                    ]
                ]
            ]);

        $response->assertStatus(200);
    }
}
