<?php
    // Define el espacio de nombres de la clase
    namespace app\models;

    // Define la clase viewsModel
    class viewsModel {

        /*---------- Modelo obtener vista ----------*/
        // Función para obtener una vista
        protected function obtenerVistasModelo($vista) {

            // Lista de vistas permitidas
            $listaBlanca = ["dashboard", 
                            "userNew", "userList", "userUpdate", "userPhoto", 
                            "logOut", "404", 
                            "productList", "productNew", "productSearch", "productPhoto", "productUpdate", 
                            "almacenGeneralList", 
                            "provNew", "provList", "provUpdate", "provSearch",
                            "movUpdate",
                            "orderCNew","orderCPNew","orderSearch",
                            "movList","movSearch",
                            "movList2","movSearch2",
                            "busqueda",
                            "kitArticulador",
                            "productEntrance",
                            "menuStorage",
                            "descInventory",
                            "orderGNew",
                            "orderGPNew",
                            "orderGSearch",
                            "kitList",
                            "cpiList",
                            "artList",
                            "arcList",
                            "herramientasMaquinado",
                            "tornilleriaMaquinadosCPI",
                            "piezasMaquinadosCPI",
                            "tornilleriaExternaCPI",
                            "piezasExternasCPI",
                            "piezasMaquinadosArticulador",
                            "tornilleriaMaquinadosArticulador",
                            "tornilleriaExternaArticulador",
                            "piezasExternasArticulador",
                            "piezasMaquinadosArco",
                            "tornilleriaMaquinadosArco",
                            "tornilleriaExternaArco",
                            "piezasExternasArco",
                            "notaENew",
                            "notaEPNew",
                            "notaESearch",
                            "piezasMaquinadosKit",
                            "tornilleriaMaquinadosKit",
                            "tornilleriaExternaKit",
                            "piezasExternasKit",
                            "inventoryList",
                            "facturaNew",
                            "facturaPNew",
                            "facturaSearch",
                            "movFactura",
                            "productoTerminado",
                            "venceFactura",
                            "controlProcesos",
                            "regNumeroLote",
                            "consultaNumeroLote",
                            "regNumeroSerie",
                            "consultaNumeroSerie",
                            "salidasProductoTerminado",
                            "salidaPTNew",
                            "salidaPTSearch",
                            "numSerSearch",
                            "facturacion",
                            "clientNew",
                            "clientList",
                            "controlLotes",
                            "productMain",
                            "userMain",
                            "movementsMain",
                            "productDetails",
                        ];

            // Comprueba si la vista solicitada está en la lista blanca
            if (in_array($vista, $listaBlanca)) {

                // Comprueba si el archivo de la vista existe
                if (is_file("./app/views/content/".$vista."-view.php")) {
                    // Si existe, establece el contenido a la vista solicitada
                    $contenido = "./app/views/content/".$vista."-view.php";
                } else {
                    // Si no existe, establece el contenido a la vista 404
                    $contenido = "404";
                }

            // Comprueba si la vista solicitada es la vista de inicio de sesión o la vista de índice
            } elseif ($vista == "login" || $vista == "index") {
                // Si es así, establece el contenido a la vista de inicio de sesión
                $contenido = "login";

            } else {
                // Si la vista solicitada no está en la lista blanca y no es la vista de inicio de sesión ni la vista de índice, establece el contenido a la vista 404
                $contenido = "404";
            }

            // Devuelve el contenido
            return $contenido;
        }

    }