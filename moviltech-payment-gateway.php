<?php

/*
Plugin Name: WooCommerce Moviltech Gateway
Description: Acepta tarjetas de credito en tu tienda.
Version: 1.0
Author: Bryam Vargas
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

#Hook que registra la clase moviltech_gateway_class como pasarela de pago de woocommerce.
add_filter( 'woocommerce_payment_gateways', 'moviltech_gateway_class' );

function moviltech_gateway_class( $gateways ) {

    $gateways[] = 'Moviltech_Gateway';
    return $gateways;

}

add_action( 'plugins_loaded', 'moviltech_init_gateway_class' );

function moviltech_init_gateway_class() {
    
    class Moviltech_Gateway extends WC_Payment_Gateway {

        /*Constructor*/
        public function __construct() {

            $this->id = 'moviltech_gateway'; //ID global para la pasarela de pago.
            $this->icon = null; //imagen opcional que aparece con el nombre de la puerta de enlace en el front-end.
            $this->has_fields = true; //opción booleana que establece que se muestren los campos de pagos en el proceso de pago.
            $this->method_title = 'Moviltech Payment Gateway';//título que aparece en la parte superior de la página de las pasarelas de pago.
            $this->method_description = 'Pasarela de pago';//descripción de la pasarela de pago.
	
	    //formulario predeterminado de soporte con tarjeta de crédito.
            $this->supports = array( 'products' );
        
	    //Define los campos de opciones.
            $this->init_form_fields();

	    //configuración variable de tiempo de carga.
            $this->init_settings();
        
	    //Convierte estos ajustes en variables utilizables.
            foreach ( $this->settings as $setting_key => $value ){
                $this->$setting_key = $value;
            }

	    //Guardar configuracion.	
            if ( is_admin() ) {

                add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            }
            
        }
    
        /*Campos de administracion de la pasarela de pago*/
        public function init_form_fields() {
	    
            $this->form_fields = array(
            
                'enabled' => array(
                    'title'       => 'Enable / Disable',
                    'label'       => 'Enable Moviltech Payment Gateway',
                    'type'        => 'checkbox',
                    'default'     => 'no',
                ),
                'title' => array(
                    'title'       => 'Title',
                    'label'       => 'text',
                    'default'     => 'Credit Card',
                    'desc_tip'    => true,
                )
            
            );

        }
    
        /*Respuesta manejada por la pasarela de pago*/
        public function process_payment( $order_id ) {
    
    
        }
    
        /*Validar campos*/
        public function validate_fields() {
            
    
        }

    }

}

?>