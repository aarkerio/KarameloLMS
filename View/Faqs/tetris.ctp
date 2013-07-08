<!-- (c) Tetrissimus - Programa realizado por Joan Alba Maldonado (granvino@granvino.com). Prohibido publicar, reproducir o modificar sin citar expresamente al autor original. -->
   <script language="JavaScript1.2" type="text/javascript">
            <!--

                //(c) Tetrissimus - Programa realizado por Joan Alba Maldonado (granvino@granvino.com). Prohibido publicar, reproducir o modificar sin citar expresamente al autor original.

                //Variable que activa el mapa modo debug:
                var mostrar_mapa_debug = false;
                
                //Variable que guarda el primer evento del teclado, por razones de compatibilidad:
                var primer_evento = "";
                
                //Se dibuja el mapa en una varialbe tipo string:
                var mapa = "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000" +
                           "000000000000";
                           
                //Se declara la matriz para guardar el mapa:
                var mapa_matriz = new Array();
                
                //El numero de columnas del mapa:
                var numero_columnas = 12;
                //El numero de filas del mapa:
                var numero_filas = 22;
                
                //Variable que contiene el ancho de cada celda (tile o panel):
                var panel_width = 20;
                //Varialbe que contiene el alto de cada celda (tile o panel):
                var panel_height = 20;

                //Velocidad de caida de las piezas (entre menor, mas rapido):
                var velocidad_inicial = 1500; //Velocidad inicial.
                var velocidad = velocidad_inicial; //Velocidad que ira incrementandose (al decrementar la variable).
                
                //Pizels de desplazamiento en la caida de las piezas:
                var desplazamiento_inicial = panel_height * 1; //Desplazamiento inicial.
                var desplazamiento = desplazamiento_inicial; //Desplazamiento que ira incrementandose.
        
                //Se realiza un bucle para guardar el mapa en la matriz:
                for (x=0; x<mapa.length; x++) { mapa_matriz[x] = mapa.substring(x, x+1); }

                //Variable que guarda el numero de la pieza actual:
                var numero_pieza = 0;
                //Variable que guarda el numero de la pieza siguiente:
                var numero_pieza_siguiente = 0;
                
                //Matriz que contiene la coleccion de piezas, con su ancho, alto y color:
                var pieza = new Array();
                
                //Varialbe para saber si una pieza se ha elevado verticalmente al ser rotada:
                var al_rotar_se_ha_elevado = false;

                //Variable donde se guardara el Interval del movimiento de la pieza cayendo:
                var movimiento_pieza = setInterval("", 1);

                //Variable donde se guardara el Timeout que hara que el mensaje del centro de la pantalla se oculte:
                var ocultar_mensaje = setTimeout("", 1);

                //Variable donde se guarda el numero de piezas:
                var numero_piezas = 0;

                //Variable que indica si se ha acabado el juego o todavia no:
                var game_over = false; //Todavia no se ha acabado el juego.

                //Variable que define las lineas necesarias para cambiar de nivel:
                var lineas_necesarias = 6;
                
                //Variable que cuenta cuantas lineas se han realizado en el nivel actual:
                var lineas_nivel_actual = 0;
                
                //Variable donde se guarda la puntuacion:
                var puntuacion = 0;
                
                //Variable donde se guada el nivel:
                var nivel = 1;
                
                //Contador de niveles, que cuando llega a 10 se sube el desplazamiento de las piezas (se desplazan mas espcio hacia abajo, para hacerlo mas dificil):
                var contador_niveles_desplazamiento = 0;
                
                //Variable que impide el Game Over, cuando ya ha ocurrido:
                var impedir_game_over = false;

                //Matriz vacia que se utilizara para cuando se llame a mostrar_mapa:
                var guardar_mapa_anterior = new Array();

                //Funcion que crea las piezas, con su ancho, alto y color:
                function crear_piezas()
                 {
                    //Pieza 1:
                    pieza[1] = new Array();
                    pieza[1]["forma"] = "1" +
                                        "1" +
                                        "1" +
                                        "1";
                    pieza[1]["width"] = 1;
                    pieza[1]["height"] = 4;
                    pieza[1]["color"] = "#aaffdd";

                    //Pieza 2:
                    pieza[2] = new Array();
                    pieza[2]["forma"] = "22" +
                                        "22";
                    pieza[2]["width"] = 2;
                    pieza[2]["height"] = 2;
                    pieza[2]["color"] = "#ffffdd";

                    //Pieza 3:
                    pieza[3] = new Array();
                    pieza[3]["forma"] = "33" +
                                        "03" +
                                        "03";
                    pieza[3]["width"] = 2;
                    pieza[3]["height"] = 3;
                    pieza[3]["color"] = "#ddaaff";

                    //Pieza 4:
                    pieza[4] = new Array();
                    pieza[4]["forma"] = "44" +
                                        "40" +
                                        "40";
                    pieza[4]["width"] = 2;
                    pieza[4]["height"] = 3;
                    pieza[4]["color"] = "#ffaadd";

                    //Pieza 5:
                    pieza[5] = new Array();
                    pieza[5]["forma"] = "055" +
                                        "550";
                    pieza[5]["width"] = 3;
                    pieza[5]["height"] = 2;
                    pieza[5]["color"] = "#ffddff";

                    //Pieza 6:
                    pieza[6] = new Array();
                    pieza[6]["forma"] = "660" +
                                        "066";
                    pieza[6]["width"] = 3;
                    pieza[6]["height"] = 2;
                    pieza[6]["color"] = "#aaddff";

                    //Pieza 7:
                    pieza[7] = new Array();
                    pieza[7]["forma"] = "070" +
                                        "777";
                    pieza[7]["width"] = 3;
                    pieza[7]["height"] = 2;
                    pieza[7]["color"] = "#ffddaa";

                    //Pieza 8:
//                    pieza[8] = new Array();
  //                  pieza[8]["forma"] = "808" +
//                                        "080" +
//                                        "080";
    //                pieza[8]["width"] = 3;
      //              pieza[8]["height"] = 3;
        //            pieza[8]["color"] = "orange";

                    //Se guarda el numero de piezas:
                    numero_piezas = pieza.length - 1;

                 }
                
                
                //Funcion que inicia el juego:
                function iniciar_juego()
                 {
                    //Se setea que aun no se ha acabado el juego:
                    game_over = false;

                    //Desbloquea el impedir game over:
                    impedir_game_over = false;

                    //Se crean las piezas:
                    crear_piezas();
                    
                    //Se setea la velocidad a la inicial:
                    velocidad = velocidad_inicial;
                    //Se setea el desplazamiento al inicial:
                    desplazamiento = desplazamiento_inicial;
                    
                    //Se deifne el contador de niveles que incrementa el desplazamiento, a 0:
                    contador_niveles_desplazamiento = 0;
                    
                    //Se definen las lineas del nivel actual a 0;
                    lineas_nivel_actual = 0;
                    
                    //Se define el marcador de puntuacio a 0:
                    puntuacion = 0;
                    
                    //Se define el nivel a 1:
                    nivel = 1;

                    //Se define el numero de pieza actual a 0 (ninguno):
                    var numero_pieza = 0;
                    //Se define el numero de pieza siguiente a 0 (ninguno):
                    var numero_pieza_siguiente = 0;

                    //Vaciar mapa (recorre la matriz, cambiando todo por 0):
                    for (x=0; x<mapa_matriz.length; x++) { mapa_matriz[x] = "0"; }
                    

                    //Se recoge el mapa en una matriz, para calcular las diferencias con este y el posterior:
                    mapa_matriz_anterior = guardar_mapa_anterior;
                    
                    //Se muestra el mapa:
                    mostrar_mapa(mapa_matriz, mapa_matriz_anterior);

                    //Se actualiza el marcador:
                    actualizar_marcador();
                    
                    //Se muestra el mensaje de "Comienza el juego":
                    mostrar_mensaje("The game begins");
                    
                    //Sacamos una pieza:
                    sacar_pieza();
                 }

                //Funcion que actualiza la matriz del mapa:
                function actualizar_mapa(numero_pieza)
                 {
                    //Si se ha enviado como pieza el cero, es que no hay piezas:
                    if (numero_pieza == 0)
                     {
                        //Recorre la matriz, cambiando todo lo que no sea 0 ni X por 0:
                        for (x=0; x<mapa_matriz.length; x++)
                         {
                            //Si no es 0 ni X, lo cambia a 0:
                            if (mapa_matriz[x] != "0" && mapa_matriz[x] != "X") { mapa_matriz[x] = "0"; }
                         }
                     }

                    //Pero si se ha enviado otro numero, mayor que cero:
                    else if (numero_pieza > 0)
                     {
                        //Se borra la pieza del mapa:
                        actualizar_mapa(0);
                        
                        //Se calcula en que posicion de la matriz comienza la pieza:
                        matriz_posicion_x = numero_columnas - (parseInt(document.getElementById("pieza").style.left) / panel_width);
                        matriz_posicion_y = parseInt(document.getElementById("pieza").style.top) / panel_height + 1;
                        //Esta es la posicion inicial (la clave de la matriz) donde comienza la pieza:
                        matriz_posicion_inicial = (numero_columnas * matriz_posicion_y) - matriz_posicion_x;
                        //Se actualiza la matriz pintando la pieza en ella, segun la posicion:
//                        for (x=0; x<mapa_matriz.length; x++)
                        for (x=matriz_posicion_inicial; x<matriz_posicion_inicial+pieza[numero_pieza]["forma"].length; x++)
                         {
                            //Si estamos en el indice donde comienza la pieza:
                            if (x == matriz_posicion_inicial)
                             {
                                //El contador de columnas:
                                contador_columnas = 0;
                                //La variable que se suma para saltar una fila:
                                saltar_fila = 0;
                                for (y=0; y<pieza[numero_pieza]["forma"].length; y++)
                                 {
                                    //Se toma como posicion de la matriz la posicion inicial y se le suma la variable que hace saltar filas:
                                    posicion_matriz_actual = x + saltar_fila;
                                    //Si la posicion actual de la pieza no es un cero, se graba en la matriz:
                                    if (pieza[numero_pieza]["forma"].substring(y, y+1) != "0") {mapa_matriz[posicion_matriz_actual] = pieza[numero_pieza]["forma"].substring(y, y+1); } //Se pinta la pieza.
                                    //Se incrementa el contador de columnas:
                                    contador_columnas++;
                                    //Se incrementa la variable para saltar filas:
                                    saltar_fila++;
                                    //Si el contador de columnas es mayor al ancho de la pieza, se salta una fila:
                                    if (contador_columnas >= pieza[numero_pieza]["width"]) { contador_columnas = 0; saltar_fila += numero_columnas - pieza[numero_pieza]["width"]; }
                                 }
                             }
                         }
                     }
                 }                

                //Funcion que activa/desactiva la visualizacion del mapa en modo debug:
                function activar_desactivar_mapa_debug(modo)
                 {
                    //Si no se ha enviado alternar, no se alterna el estado:
                    if (modo != "alternar") { var alternar_estado = mostrar_mapa_debug; }
                    //...pero si se ha enviado alternar, se alterna:
                    else { var alternar_estado = mostrar_mapa_debug ? false: true; }
                    
                    //Si se ha desactivado, setea para que no se muestre el mapa y esconde el mapa:
                    if (!alternar_estado) { mostrar_mapa_debug = false; document.getElementById("mapa_debug").style.visibility = "hidden"; document.formulario.casilla.checked = false; }
                    //Si no (se ha activado), lo vuelve a activar y a hacer visible:
                    else { mostrar_mapa_debug = true; document.getElementById("mapa_debug").style.visibility = "visible"; document.formulario.casilla.checked = true; mapa_matriz_anterior = guardar_mapa_anterior; mostrar_mapa(mapa_matriz, mapa_matriz_anterior); }
                 }

                //Funcion que muestra el mapa en modo debug:
                function mostrar_mapa(mapa_matriz, mapa_matriz_anterior)
                 {

                    //Si se ha enviado la misma matriz actual que la anterior, sale de la funcion (no hay nada que actualizar):
                    if (mapa_matriz == mapa_matriz_anterior) { return; }

                    //Se setea el contador de columnas a cero:
                    var columnas_contador = 0;
                    //Se setea el contador de filas a cero:
                    var filas_contador = 0;

                    //Variable que guardara el color a utilizar en cada celda (tile o panel):
                    var color_panel;

                    //Se borra el mapa:
//                    document.getElementById("mapa").innerHTML = "";
//                    if (mostrar_mapa_debug) { document.getElementById("mapa_debug").innerHTML = ""; } //Si esta en modo debug, tambien se borra el mapa debug.
                    //Se crean las variables que guardaran la informacion del mapa:
                    var mapa_bucle_temp = "";
                    var mapa_debug_bucle_temp = "";

                    //Se realiza un bucle para mostrar el contenido de la matriz en el espacio de debug:
                     for (x=0; x<mapa_matriz.length; x++)
                      {
                         //Se calcula que color utilizar, segun el caracter de celda (tile o panel):
                         if (mapa_matriz[x] == "X") { color_panel = "#555555"; } //Color gris oscuro (caracter X, piezas ya colocadas).
                         else if (mapa_matriz[x] != 0) { color_panel = pieza[mapa_matriz[x]]["color"]; } //Color de la pieza segun su numero.
                        
                         //Calcular la posicion de la celda (tile o panel):
                         panel_x = columnas_contador * panel_width; //Posicion horizontal.
                         panel_y = filas_contador * panel_height; //Posicion vertical.

                         //Se muestra la imagen en la celda, siempre que no este vacia (0) y que haya habido un cambio desde la anterior:
                         if (mapa_matriz[x] != 0 && mapa_matriz[x] != mapa_matriz_anterior[x]) { mapa_bucle_temp += '<div style="background:'+color_panel+'; top:'+panel_y+'px; left:'+panel_x+'px; width:'+panel_width+'px; height:'+panel_height+'px; position:absolute; padding:0px; font-size:1px; filter:alpha(opacity=80); opacity:0.8; -moz-opacity:0.8; z-index:5000;"></div>'; }

                         //Si esta activado el mapa debug, se escribe en el:
                         if (mostrar_mapa_debug) { mapa_debug_bucle_temp += mapa_matriz[x]; }

                         //Se incrementa el contador de columnas:
                         columnas_contador++;

                         //Si se alcanza el numero maximo de columnas, se baja una fila y se setea otra vez el contador a cero y se incrementa el contador de filas (si esta el mapa en modo debug, se baja una linea en este):
                         if (columnas_contador == numero_columnas) { columnas_contador = 0; filas_contador++; if (mostrar_mapa_debug) { mapa_debug_bucle_temp += "<br>"; } }
                      }
                     
                     //Se vuelcan las variables en el mapa:
                     document.getElementById("mapa").innerHTML = mapa_bucle_temp;
                     if (mostrar_mapa_debug) { document.getElementById("mapa_debug").innerHTML = mapa_debug_bucle_temp; } //Si esta en modo debug, tambien se vuelca el mapa en modo debug.
                 }

                //Funcion que saca una pieza al escenario:
                function sacar_pieza()
                 {
                    //Si ya ha habido game over, se sale de la funcion:
                    if (impedir_game_over) { return; }
                    
                    //Si aun no seh a escogido ninguna pieza, se escoge una aleatoriamente:
                    if (numero_pieza == 0) { numero_pieza = elegir_pieza(); }
                    //Si antes ya se habia escogido alguna, se setea la actual como la siguiente:
                    else { numero_pieza = numero_pieza_siguiente; }
                    //Ponemos el numero de la pieza siguiente, escogido aleatoriamente, en una variable:
                    numero_pieza_siguiente = elegir_pieza();
                    
                    //Se muestra la pieza siguiente:
                    mostrar_pieza_siguiente(numero_pieza_siguiente);

                    //Setear conforme todavia no se ha elevado verticalmente la pieza al ser rotada:
                    al_rotar_se_ha_elevado = false;

                    //Borrar esto:
                    //numero_pieza = 1;

                    //Devolver las piezas a su estado inicial:
                    crear_piezas();

                    //Se recoge el mapa en una matriz, para calcular las diferencias con este y el posterior:
                    mapa_matriz_anterior = guardar_mapa_anterior;

                    //Calcular ancho y alto de la pieza, segun el numero enviado:
                    pieza_width = pieza[numero_pieza]["width"];
                    pieza_height = pieza[numero_pieza]["height"];
                    
                    //Se situa horizontalmente en el centro:
                    //document.getElementById("pieza").style.left = parseInt( (numero_columnas * panel_width) / 2 - pieza_width * panel_width) + "px";
                    document.getElementById("pieza").style.left = "0px";
                    //Se situa verticalmente arriba:
                    document.getElementById("pieza").style.top = "0px";

                    mover_pieza(0, 0);

                    //Se actualiza el mapa:
                    //actualizar_mapa(numero_pieza);mostrar_mapa_debug(mapa_matriz);
                    
                    //Se muestra el mapa:
                    mostrar_mapa(mapa_matriz, mapa_matriz_anterior);


                    //Elimina el movimiento de la pieza cayendo, por si aun existia:
                    clearInterval(movimiento_pieza);

                    //Crea el movimiento de la pieza cayendo:
                    movimiento_pieza = setInterval("mapa_matriz_anterior = guardar_mapa_anterior; mover_pieza('mantener', parseInt(document.getElementById('pieza').style.top) + desplazamiento); mostrar_mapa(mapa_matriz, mapa_matriz_anterior);", velocidad);
                 }

                //Funcion que elige una pieza aleatoriamente:
                function elegir_pieza()
                 {
                    //Variable que escoge un numero aleatorio entre 1 y 8:
                    var numero_aleatorio = parseInt(Math.random() * numero_piezas) + 1;
                    
                    //Retorna el numero escogido de la pieza:
                    return numero_aleatorio;
                 }

                //Funcion que mueve la pieza segun las coordenadas enviadas:
                function mover_pieza(posicion_x, posicion_y)
                 {
                    //Si ya ha habido game over, se sale de la funcion:
                    if (impedir_game_over) { return; }
                    
                    //Si se ha enviado mantener posicion horizontal, no mover la pieza (conservar la X de esta):
                    if (posicion_x == "mantener") { posicion_x = parseInt(document.getElementById("pieza").style.left); }
                    
                    //Variable para saber si la pieza ha tocado fondo:
                    var ha_tocado_fondo = false;
                    //Si la pieza esta en el limite de abajo, situa la pieza lo maximo posible hacia abajo y se setea la variable ha_tocado_fondo a true:
                    if (posicion_y > panel_height * numero_filas - pieza[numero_pieza]["height"] * panel_height) { posicion_y = panel_height * numero_filas - pieza[numero_pieza]["height"] * panel_height; ha_tocado_fondo = true; }
                    //Si la pieza esta en el limite izquierdo, situa la pieza lo maximo posible hacia la izquierda:
                    if (posicion_x <= 0) { posicion_x = 0; }
                    //Si la pieza esta en el limite derecho, situa la pieza lo maximo posible hacia la derecha:
                    if (posicion_x + panel_width * pieza[numero_pieza]["width"] > panel_width * numero_columnas) { posicion_x = panel_width * numero_columnas - pieza[numero_pieza]["width"] * panel_width; }
                    
                    //Variables que impiden el movimiento horizontal si a la izquierda o a la derecha de la pieza hay otra ya colocada:
                    impedir_movimiento_derecho = false;
                    impedir_movimiento_izquierdo = false;

                    //Realizar un bucle en la matriz:
                    for (x=0; x<mapa_matriz.length; x++)
                     {
                        //Si la posicion actual de la matriz contiene un caracter que no es 0 ni X, contiene una pieza:
                        if (mapa_matriz[x] != "0" && mapa_matriz[x] != "X")
                         {
                            
                            //Si existe un caracter a la derecha del actual (no excede el tamaño de la matriz):
                            if (x + 1 <= mapa_matriz.length)
                             {
                                //Si el caracter que hay a la derecha es una X, impedir movimiento horizontal:
                                if (mapa_matriz[x+1] == "X") { impedir_movimiento_derecho = true; } //Se impide movimiento horizontal hacia la derecha.
                             }
                            
                            //Si existe un caracter a la izquierda del actual (no es menor a 0):
                            if (x - 1 >= 0)
                             {
                                //Si el caracter que hay a la izquierda es una X, impedir movimiento horizontal:
                                if (mapa_matriz[x-1] == "X") { impedir_movimiento_izquierdo = true; } //Se impide movimiento horizontal hacia la izquierda.
                             }
                         }
                     }
                    
                    //Si la posicion horizontal es hacia la izquierda y no esta impedida o es a la derecha y tampoco esta impedida, mueve la pieza horizontalmente:
                    posicion_x_actual = parseInt(document.getElementById("pieza").style.left);
                    if (posicion_x_actual > posicion_x && !impedir_movimiento_izquierdo || posicion_x_actual < posicion_x && !impedir_movimiento_derecho)
                     {
                        document.getElementById("pieza").style.left = posicion_x + "px"; //Se situa la pieza en la posicion horizontal dada.
                     }
                    
                    //Se situa la pieza en la posicion vertical dada:                    
                    document.getElementById("pieza").style.top = posicion_y + "px";
                    
                    //Se actualiza el mapa con la nueva posicion de la pieza:
                    actualizar_mapa(numero_pieza);

                    //Calcular colision:
                    var ha_colisionado = calcular_colision();

                    //Si la posicion vertical de la pieza la situa abajo del todo, se convierte todo el mapa que no sea 0 a X:
                    if (ha_tocado_fondo || ha_colisionado)
                     {
                        //Elimina el movimiento de la pieza cayendo, por si existia anteriormente:
                        //clearInterval(movimiento_pieza);

                        //Da 1 punto:
                        puntuacion += 1;
            
                        //Se setea todo lo que haya en el mapa como X (ya colocado):
                        for (x=0; x<mapa_matriz.length; x++) { if (mapa_matriz[x] != "0") { mapa_matriz[x] = "X"; } }

                        //Se hace bajar la pieza un panel, para que quede bien al pausar el juego:
                        document.getElementById("pieza").style.top = parseInt(document.getElementById("pieza").style.top) + panel_height + "px";
                        actualizar_mapa();
                        mostrar_mapa(mapa_matriz, mapa_matriz_anterior);
                        
                        //Calculamos si se ha llegado arriba del todo y se acaba el juego:
                        hay_game_over = calcular_game_over();

                        //Se saca una pieza:
                        if (!hay_game_over) { sacar_pieza(); }
                     }
                    
                    //Calcular si se ha hecho linea:
                    calcular_linea();
                    
                    //Se muestra el mapa:
//                    mostrar_mapa(mapa_matriz);
//                    mostrar_mapa(mapa_matriz, mapa_matriz_anterior);
                    
                 }
                
                //Funcion que calcula si una pieza ha chocado con otra (poniendose encima):
                function calcular_colision()
                 {
                    //Variable que calcula si ha colisionado o no:
                    var ha_colisionado = false;
                    
                    //Realizar bucle en la matriz, buscar caracteres que no sean 0 ni X y calcular si justo debajo tienen una X:
                    for (x=0; x<mapa_matriz.length; x++)
                     {
                        //Si la posicion actual de la matriz contiene un caracter que no es 0 ni X, contiene una pieza:
                        if (mapa_matriz[x] != "0" && mapa_matriz[x] != "X")
                         {
                            
                            //Si existe un caracter debajo del actual (no excede el tamaño de la matriz):
                            if (x + numero_columnas <= mapa_matriz.length)
                             {
                                //Si el caracter que hay debajo es una X, ha colisionado:
                                if (mapa_matriz[x+numero_columnas] == "X") { ha_colisionado = true; break; } //Ha habido colision y sale del bucle.
                             }
                         }
                     }

                    //Si ha colisionado:
                    if (ha_colisionado)
                     {
                        //Retorna true:
                        return true;
                     }
                    //...y si no:
                    else { return false; } //Retorna false;
                 }

                //Funcion que calcula si ha habido linea:
                function calcular_linea()
                 {
                    //Calcular si ha habido linea y calcular cuantas:
                    var columnas_contador = 0;
                    if (!numero_de_lineas) { var numero_de_lineas = 0; }
                    var ha_habido_linea = false;
                    var hay_linea = true;
                    for (var x=0; x<mapa_matriz.length; x++)
                     {
                        columnas_contador++;

                        if (mapa_matriz[x] != "X") { hay_linea = false; }

                        if (columnas_contador == numero_columnas)
                         {
                            if (hay_linea)
                             {
                                //Cambiar las X de la linea por 0:
                                for (var y=x-numero_columnas+1; y<=x; y++)
                                 {
                                    mapa_matriz[y] = "0";
                                 }
                                
                                //Bajar lineas:
                                se_ha_bajado_linea = hacer_caer_cuadros();
                                
                                //Volver a llamar a la funcion recursivamente si se ha bajado alguna linea, para ver si al bajar las piezas colocadas ha habido mas lineas:
//                                if (se_ha_bajado_linea) { calcular_linea(); }
                                //calcular_linea();
                                

                                //Incrementar el contador de lineas:
                                numero_de_lineas++;

                                ha_habido_linea = true;


                                  
                             }
                            columnas_contador = 0;
                            hay_linea = true;
                         }

                        //actualizar_mapa(numero_pieza);

                        
                     }
                    
                   
                    //Si ha habido linea, dar puntos segun cuantas lineas ha haya habido:
                    dar_puntos(numero_de_lineas);
                    
                 }

                //Funcion que hace caer los cuadros (X) cuando debajo no tienen nada (0):
                function hacer_caer_cuadros(posicion_final)
                 {

                     //Todavia no se ha bajado ninguna linea:
                     se_ha_bajado_linea = false;
                    
                    //Calcula si la linea esta en el aire o no:
                    var esta_en_el_aire = true;
            
                     //Bucle que va de arriba a abajo, haciendo caer las piezas:
//                     for (z=mapa_matriz.length-numero_columnas; z>=numero_columnas+1; z-=numero_columnas)
                     for (z=mapa_matriz.length-numero_columnas; z>=numero_columnas; z-=numero_columnas)
                      {
//                        alert(z);
                        //Calcula si la linea esta en el aire o no:
                        esta_en_el_aire = true;
                        
                        //Comprueba que la linea este en el aire:
                        for (k=z; k<=z+numero_columnas-1; k++) { if (k > mapa_matriz.length || mapa_matriz[k] != "0" || z > numero_columnas && mapa_matriz[k-numero_columnas] != "X" && mapa_matriz[k-numero_columnas] != "0") { esta_en_el_aire = false; } }
                        
                        //Si esta en el aire, se baja la linea:
                        if (esta_en_el_aire)
                         {
//                        alert(z);
                           for (k=z; k<=z+numero_columnas-1; k++)
                             {
                                  //Se replica la pieza en el cuadro de abajo:
                                  mapa_matriz[k] = mapa_matriz[k-numero_columnas];
                                  //Se borra la pieza en el cuadro actual:
                                  mapa_matriz[k-numero_columnas] = "0";
                                  //Setear conforme se ha bajado una linea:
                                  se_ha_bajado_linea = true;
                                  
//                        mostrar_mapa(mapa_matriz, mapa_matriz_anterior);
                             }
                            //Se setea como que ya no estan en el aire:
                            esta_en_el_aire = false; 
                         }
                       
                      }

                    if (se_ha_bajado_linea) { return true; }
                    else { return false; }
                 }

                //Funcion que rota la pieza:
                function rotar_pieza(direccion)
                 {
                    //Se inviert el ancho y el alto de la pieza:
                    var width_original = pieza[numero_pieza]["width"]; //El width anterior.
                    var height_original = pieza[numero_pieza]["height"]; //El height anterior.
                    pieza[numero_pieza]["width"] = height_original; //El nuevo width es el height.
                    pieza[numero_pieza]["height"] = width_original; //El numero height es el width anterior.
                    
                    //Se setea la matriz donde se guardara la nueva pieza:
                    var nueva_pieza_matriz = new Array(); //Se declara la matriz.
                    
                    //Variables que serviran para realizar los bucles:
                    var contador1 = 0;
                    var contador2 = height_original;
                    var contador3 = width_original;
                   
                    //Si se ha de rotar la pieza a la derecha:
                    if (direccion == "derecha")
                     {
                        //Se realiza un bucle por la pieza actual, y se guarda rotada a la derecha en la nueva pieza:
                        for (x=0; x<pieza[numero_pieza]["forma"].length; x++)
                         {
                            //Formula que yo mismo descubri, despues de mucho pensar x):
                            var formula = (contador1 * height_original) + (contador2  - 1);
                            nueva_pieza_matriz[formula] = pieza[numero_pieza]["forma"].substring(x,x+1);
                            contador1++;
                            contador3--;
                            if (contador3 == 0) { contador3 = width_original; contador1 = 0; contador2--; }
                         }
                     }
                   
                    //...O si se ha de rotar la pieza hacia la izquierda (o tres veces hacia la derecha):
                    else if (direccion == "izquierda")
                     {
                        //Se realiza un bucle por la pieza actual, y se guarda rotada a la derecha en la nueva pieza:
                        for (x=pieza[numero_pieza]["forma"].length; x>0; x--)
                         {
                            //Formula que yo mismo descubri, despues de mucho pensar x):
                            var formula = (contador1 * height_original) + (contador2  - 1);
                            nueva_pieza_matriz[formula] = pieza[numero_pieza]["forma"].substring(x-1,x);
                            contador1++;
                            contador3--;
                            if (contador3 == 0) { contador3 = width_original; contador1 = 0; contador2--; }
                         }
                     }

                    //Posicion vertical de la pieza                     
                    posicion_y = parseInt(document.getElementById("pieza").style.top);
                    
                    //Calcular si al rotarse la pieza va a estar encima de alguna X, entonces moverla a un lugar cercano (hasta en posicion horizontal - ancho pieza, posicion horizontal + ancho pieza, posicion vertical + alto pieza o en posicion vertical - alto pieza) con 0.
                    //Calcular si la pieza va a chocar al rotarse con alguna pieza inferior o lateral:
                    //* Si hay piezas debajo, elevar la pieza un cuadro.
                    //* Si hay piezas al lado, mover la pieza al lado contrario.
                    //* Si la nueva posicion calculada no es posible (hay X en lo que va a ocupar), no rotar la pieza y salir de la funcion.
                    
                    //Si la pieza va a estar demasiado cerca del borde inferior (abajo) o de alguna pieza inferior, se sube un poco hacia arriba:
                    if (posicion_y + pieza[numero_pieza]["height"] * panel_height >= numero_filas * panel_height) { posicion_y -= parseInt(pieza[numero_pieza]["height"] / 2 + 1) * panel_height; al_rotar_se_ha_elevado = true; }
                    //...y si no, y ya ha sido elevada anteriormente al rotarse, se vuelve a bajar:
                    else if (al_rotar_se_ha_elevado) { posicion_y += parseInt(pieza[numero_pieza]["width"] / 2 + 1) * panel_height; }

                    //Variable donde se guardara la forma de la nueva pieza rotada:
                    var nueva_pieza = "";
                    //Se realiza un bucle para introducir lo que hay en la matriz en una variable de texto plano:
                    for (x = 0; x<nueva_pieza_matriz.length; x++)
                     {
                        nueva_pieza += nueva_pieza_matriz[x];
                     }
                    //Se setea la forma de la pieza actual a la nueva pieza que hemos rotado:
                    pieza[numero_pieza]["forma"] = nueva_pieza;
                    
                    //Retorna la posicion vertical de la pieza:
                    return posicion_y;
                 }

                //Funcion que da puntos, segun un numero de lineas enviado:
                function dar_puntos (numero_lineas)
                 {
                    //Variable donde se guardara el mensaje a mostrar, si es necesario:
                    var mensaje = "";
                    
                    //Dar puntos, segun las lineas:
                    if (numero_lineas == 4) { puntuacion += 400; mensaje = "Tetris"; } //Se han hecho 4 lineas (tetris).
                    else if (numero_lineas == 3) { puntuacion += 300; mensaje = "Triple"; } //Se han hecho 3 lineas (triple).
                    else if (numero_lineas == 2) { puntuacion += 200; mensaje = "Double"; } //Se han hecho 2 lineas (doble).
                    else if (numero_lineas == 1) { puntuacion += 100; mensaje = "Single"; } //Se ha hecho 1 linea (simple).
                                        
                    //Mostrar en medio de la pantalla cuantas lineas se han hecho, siempre que se haya hecho alguna, y suma al contador de lineas:
                    if (mensaje != "") { mostrar_mensaje(mensaje); lineas_nivel_actual++; }
                    
                    //Si elas lineas del nivel actual alcanza o supera las necesarias para pasar de nivel, se llama a la funcion de pasar de nivel:
                    if (lineas_nivel_actual >= lineas_necesarias)
                     {
                        pasar_nivel();
                     }
                    
                    //Actualizar marcador:
                    actualizar_marcador();
                 }
                 
                //Funcion que pasa de nivel cada X lineas:
                function pasar_nivel()
                 {
                    //Si esta habiendo game over, salir de la funcion:
                    if (impedir_game_over) { return; }
                    
                    //Calcular si el numero de lineas realizadas en el nivel actual es igual o supera a lineas_necesarias, y entonces cambia de nivel:
                    if (lineas_nivel_actual >= lineas_necesarias)
                     {
                        //Se define el contador de lineas de cada nivel a cero:
                        lineas_nivel_actual = 0;

                        //Se incrementa el contador de niveles, que al llegar a 10 incrementa el desplazamiento de la pieza:
                        contador_niveles_desplazamiento++;

                        //Se suma un nivel:
                        nivel++;
                        
                        //Se sube la velocidad inicial (ahora la pieza tardara 50 milisegundos menos en caer hacia abajo en cada movimiento):
                        if (velocidad_inicial - 25 >= 0) { velocidad -= 25; }
                        
                        //Si el contador de niveles llega a 10, se sube el desplazamiento de la pieza (ahora la pieza se desplazara mas en cada caida):
                        if (contador_niveles_desplazamiento >= 10 && desplazamiento_inicial <= panel_height * numero_filas) { desplazamiento += panel_height; contador_niveles_desplazamiento = 0; }
                        
                        //Se dan 1000 puntos:
                        puntuacion += 1000;
                     }

                    //Mostrar en pantalla que se ha pasado de nivel:
                    mostrar_mensaje("Welcome to level "+nivel);
                    
                    //Actualizar marcador:
                    actualizar_marcador();
                 }

                //Funcion que actualiza el marcador:
                function actualizar_marcador()
                 {
                    //Actualiza el marcador (barra de estado):
                    document.getElementById("estado").innerHTML = "&nbsp; Level: "+nivel+" | Score: "+puntuacion;
                    
                    if (game_over) { document.getElementById("estado").innerHTML += " | [Game Over]"; }
                 }

                //Funcion que muestra la pieza siguiente:
                function mostrar_pieza_siguiente(numero_pieza_siguiente)
                 {
                    //Variable que contendra la pieza siguiente pintada (los div):
                    var pieza_pintada = "";
                    //Posicion de la pieza en el cuadro de "pieza siguiente":
                    posicion_y = panel_height; //Posicion vertical inicial.
                    posicion_x = panel_width; //Posicion horizontal inicial.
                    
                    //Contador de columnas, para saber cuando bajar la celda:
                    var contador_columnas = 0;

                    //Se realiza un bucle hasta cumplir el numero de celdas que tenga la pieza:
                    for (x=0; x<pieza[numero_pieza_siguiente]["forma"].length; x++)
                     {
                        //Se coge el color de la pieza:
                        color_pieza = pieza[numero_pieza_siguiente]["color"];
                        //Si la celda actual no esta vacia (0), se pinta (se crea un div con las posiciones correspondientes):
                        if (pieza[numero_pieza_siguiente]["forma"].substring(x,x+1) != "0") { pieza_pintada += '<div style="background:'+color_pieza+'; left:'+posicion_x+'; top:'+posicion_y+'; width:'+panel_width+'; height:'+panel_height+'; font-size:1px; position:absolute; z-index:5001;"></div>'; }
                        //Se incrementa la posicion horizontal:
                        posicion_x += panel_width;
                        //Se incrementa una columna:
                        contador_columnas++;
                        //Si se ha llegado al fin de las columnas, se baja una fila y se setea las columnas a 0:
                        if (contador_columnas >= pieza[numero_pieza_siguiente]["width"]) { contador_columnas = 0; posicion_y += panel_height; posicion_x = panel_width; }
                     }
                    
                    //Se muestra la ficha que hemos "pintado":
                    document.getElementById("pieza_siguiente").innerHTML = "Next piece: "+pieza_pintada;
                 }
                
                //Funcion que muestra un mensaje en medio de la pantalla, durante un tiempo:
                function mostrar_mensaje(mensaje)
                 {
                    //Se borra el Timeout anterior por si ya existia de antes:
                    clearTimeout(ocultar_mensaje);
                    //Se pone el teto en el recuadro:
                    document.getElementById("mensaje").innerHTML = mensaje;
                    //Se hace visible el recuadro:
                    document.getElementById("mensaje").style.visibility = "visible";
                    //Se esconde el recuadro a los 1500 milisegundos (un segundo y medio):
                    ocultar_mensaje = setTimeout("document.getElementById('mensaje').style.visibility = 'hidden';", 1500);
                 }                

                //Funcion que calcula si se ha llegado al tope de la pantalla, y si es asi da GameOver:
                function calcular_game_over()
                 {
                    //Si ya se ha ejecutado game over, sale de la funcion:
                    if (impedir_game_over) { return; }
                    
                    //Variable que definira si se ha llegado arriba del todo o no:
                    var se_ha_llegado_arriba = false;
                    
                    //Calcular si se ha llegado al fin del mapa, con un bucle:
                    for (x=0; x<numero_columnas; x++)
                     {
                        //Si arriba del mapa hay otra cosa que no es un 0, se ha llegado arriba:
                        if (mapa_matriz[x] != "0") { se_ha_llegado_arriba = true; }
                     }
                    
                    //Si ha llegado arriba del todo, hace el game over y luego inicia otro juego nuevo:
                    if (se_ha_llegado_arriba)
                     {
                        //Setea el game over:
                        game_over = true;
                    
                        //Actualizar marcador:
                        actualizar_marcador();
                    
                        //Se muestra el mensaje:
                        mostrar_mensaje("Game Over");
                    
                        //Impedir Game Over:
                        impedir_game_over = true;

                        //Se alerta:
                        alert("Game Over");
                    
                        //Se comienza el juego en 2 segundos:
                        setTimeout("iniciar_juego();", 2000);
                     
                        return true;
                     }
                    
                    else { return false; } //No ha habido game over.
                    
                 }

                //Funcion que recoge el mapa en la variable mapa_matriz_anterior()
                function guardar_mapa_anterior()
                 {
                    var mapa_matriz_anterior = new Array();
                    for (x=0; x<mapa_matriz.length; x++)
                     {
                        mapa_matriz_anterior[x] = mapa_matriz[x];
                     }
                    return mapa_matriz_anterior;
                 }

                //Funcion que captura la tecla pulsada y realiza la funcion necesaria:
                function pulsar_tecla(e, evento_actual)
                 {
                    //Si esta en pausa el juego, se sale de la funcion:
                    if (!movimiento_pieza) { return; }

                    //Se recoge el mapa en una matriz, para calcular las diferencias con este y el posterior:
                    mapa_matriz_anterior = guardar_mapa_anterior;

                    //Si el primer evento esta vacio, se le introduce como valor el evento actual (el que ha llamado a esta funcion):
                    if (primer_evento == "") { primer_evento = evento_actual; }
                    //Si el primer evento no es igual al evento actual (el que ha llamado a esta funcion), se vacia el primer evento (para que a la proxima llamada entre en la funcion) y se sale de la funcion:
                    if (primer_evento != evento_actual) { primer_evento = ""; return; }

                    //Capturamos la tacla pulsada, segun navegador:
                    if (e.keyCode) { var unicode = e.keyCode; }
                    //else if (event.keyCode) { var unicode = event.keyCode; }
                    else if (window.Event && e.which) { var unicode = e.which; }
                    else { var unicode = 40; } //Si no existe, por defecto se utiliza la flecha hacia abajo.

                    //Se obtiene la posicion actual de la pieza:
                    posicion_x = parseInt(document.getElementById("pieza").style.left); //Posicion horizontal.
                    posicion_y = parseInt(document.getElementById("pieza").style.top); //Posicion vertical.

                    //Si se pulsa la flecha hacia abajo, se suman 20 pixels verticales:
                    if (unicode == 40) { posicion_y += 20; }
                    //...y si se pulsa la flecha hacia la derecha, se suman 20 pixels horizontales:
                    else if (unicode == 39) { posicion_x += 20; }
                    //...y si se pulsa la flecha hacia la izquierda, se restan 20 pixels horizontales:
                    else if (unicode == 37) { posicion_x -= 20; }
                    //...y si se pulsa flecha arriba (38), control (17), intro (13) o . (190), se rota la pieza hacia la derecha:
                    else if (unicode == 38 || unicode == 17 || unicode == 13 || unicode == 190) { posicion_y = rotar_pieza("derecha"); }
                    //...y si se pulsa shift (16), espacio (32), 0 (96) o insert (45), se rota la pieza hacia la izquierda:
                    else if (unicode == 16 || unicode == 32 || unicode == 96 || unicode == 45) { posicion_y = rotar_pieza("izquierda"); }

                    
                    //Se mueve la pieza:
                    mover_pieza(posicion_x, posicion_y);

                    //Se muestra el mapa:
                    mostrar_mapa(mapa_matriz, mapa_matriz_anterior);
                 }


                //Funcion que pausa o reanuda el juego:
                function pausar_reanudar_juego()
                 {
                    //Si la pieza no esta moviendose, se reanuda:
                    if (!movimiento_pieza) { movimiento_pieza = setInterval("mapa_matriz_anterior = guardar_mapa_anterior; mover_pieza('mantener', parseInt(document.getElementById('pieza').style.top) + desplazamiento); mostrar_mapa(mapa_matriz, mapa_matriz_anterior);", velocidad); mostrar_mensaje("Game resumed"); document.getElementById("pausar").innerHTML = "[ Pause ]"; document.getElementById("pausar").title = "Click here to pause game"; }
                    //...pero si ya esta moviendose, se pausa:
                    else { clearInterval(movimiento_pieza); movimiento_pieza = false; document.getElementById("mensaje").innerHTML = "Game paused"; document.getElementById("mensaje").style.visibility = "visible"; setTimeout('document.getElementById("mensaje").innerHTML = "Game paused"; document.getElementById("mensaje").style.visibility = "visible";', 1500); document.getElementById("pausar").innerHTML = "[ Resume ]"; document.getElementById("pausar").title = "Click here to resume game"; }
                 }

            //-->
        </script>
    </head>
    <body onLoad="javascript:activar_desactivar_mapa_debug('mantener'); iniciar_juego();" onKeyDown="javascript:pulsar_tecla(event, 'onkeypress');" onKeyPress="javascript:pulsar_tecla(event, 'onkeydown');" bgcolor="#eeeeff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <!-- Zona de juego: -->
        <div id="zona_juego" style="background:#555555; color:#555555; visibility:visible; top:10px; left:20px; width:244px; height:442px; position:absolute; padding:0px; border:0px; font-size:1px; z-index:1;">
            <!-- Mapa: -->
            <div id="mapa" style="background:url('fondo.gif'); color:#000000; visibility:visible; top:0px; left:2px; width:242px; height:442px; position:absolute; padding:0px; border:0px; font-size:1px; z-index:2;"></div>
            <!-- Fin de Mapa. -->
            <!-- Pieza: -->
            <div id="pieza" style="background:transparent; color:#ffffff; visibility:hidden; position:absolute; left:0px; top:0px; font-size:1px; z-index:3;"></div>
            <!-- Fin de Pieza. -->
            <!-- Mensaje: -->
            <div id="mensaje" style="background:#cc0000; color:#ffffff; visibility:visible; top:210px; left:11px; width:225px; height:20px; position:absolute; padding:0px; border:0px; font-size:12px; line-height:14px; font-family:verdana; font-weight:bold; filter:alpha(opacity=80); opacity:0.8; -moz-opacity:0.8; text-align:center; z-index:4;">
                Loading...
            </div>
            <!-- Fin de Mensaje. -->
        </div>
        <!-- Fin de Zona de juego. -->
        <!-- Pieza siguiente: -->
        <div id="pieza_siguiente" style="background:#102020; color:#ffffff; visibility:visible; top:10px; left:270px; width:120px; height:120px; position:absolute; padding:0px; border:0px; font-size:12px; font-weight:bold; text-align:center; z-index:5;">
            Loading...
        </div>
        <!-- Fin de Pieza siguiente. -->
        <!-- Barra de estado: -->
        <div id="estado" style="background:#000077; color:#ffffff; visibility:visible; top:453px; left:20px; width:244px; height:20px; position:absolute; padding:0px; border:0px; font-size:10px; line-height:18px; font-family:verdana; font-weight:bold; z-index:6;">
            &nbsp; Loading...
        </div>
        <div id="autor" style="background:transparent; color:#aa0000; visibility:visible; top:473px; left:20px; width:244px; height:20px; position:absolute; padding:0px; border:0px; font-size:9px; line-height:15px; font-family:verdana; font-weight:bold; text-align:center; z-index:7;">
            Tetr&iacute;ssimus&copy; by Joan Alba Maldonado
        </div>
        <!-- Fin de Barra de estado. -->
        <!-- Mapa en modo debug: -->
        <div id="mapa_debug" style="top:135px; left:270px; background:cyan; visibility:hidden; color:#000066; position:absolute; padding:4px; border:0px; text-align:center; font-family:arial; font-size:12px; z-index:8;">
        </div>
        <div id="opcion_debug" style="visibility:visible; top:470px; left:270px; padding:0px; background:cyan; color:#000066; position:absolute; padding:4px; border:0px; text-align:center; font-weight:bold; font-family:arial; font-size:12px; line-height:20px; z-index:9;">
            <form name="formulario" id="formulario" style="display:inline;">
                <label for="casilla" title="Shows map on debug mode (text)" accesskey="m">
                    <input type="checkbox" name="casilla" id="casilla" onClick="javascript:activar_desactivar_mapa_debug('alternar');" checked> Show debug mode <u>m</u>ap &nbsp;
                </label>
            </form>
        </div>
        <div style="clear:both;"></div>
        <!-- Fin de Mapa en modo debug. -->
        <!-- Boton de Pausa: -->
        <div id="pausar" style="top:450px; left:360px; background:transparent; visibility:visible; color:#660000; position:absolute; padding:4px; border:0px; text-align:center; font-family:arial; font-size:12px; cursor: pointer; cursor: hand; z-index:8;" onClick="javascript:pausar_reanudar_juego();" title="Click here to pause game">
            [ Pause ]
        </div>
        <!-- Fin de Boton de Pausa. -->
        <!-- Informacion: -->
        <div style="left:400px; top:10px; height:0px; position:absolute; border:0px; padding:0px; background:transparent; color:#333333; text-align:left; line-height:20px; text-decoration:none; font-family:verdana; font-size:12px; z-index:10;">
            &copy; <b>Tetr&iacute;ssimus</b> 0.15a
            <br>
            &nbsp;&nbsp;by <i>Joan Alba Maldonado</i> (<a href="mailto:granvino@granvino.com;">granvino@granvino.com</a>) &nbsp;<sup>(100% DHTML)</sup>
            <br>&nbsp;&nbsp;- Prohibited to publish, reproduce or modify without maintain author's name.
            <br>
            &nbsp;&nbsp;<tt>* Use the keyboard arrow to move, and up arrow (also spacebar, control,
            <br>
            &nbsp;&nbsp;  shift or return) to rotate piece. Under Opera, leave the mouse cursor
            <br>
            &nbsp;&nbsp;  over game zone.</tt>
            <br>
            &nbsp;&nbsp;<i>Dedicated to Yasmina Llaveria del Castillo</i>
        <!-- Fin de Informacion. -->

