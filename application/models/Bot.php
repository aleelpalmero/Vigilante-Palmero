<?php
//date_default_timezone_set('Europe/London');
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {

	function log($text){
		$fp = fopen('error.log', 'a');
		fwrite($fp, $text ."\n");
		fclose($fp);
	}

	public function index(){

		$this->log($this->telegram->dump(TRUE) );

		if($this->telegram->receive(["Quien eres vigilante", "identificate", "/start"])){ 																					## Para enviar mensajes - autorrespuestas
			$this->telegram->send
				->text("Soy el <b>Vigilante Palmero</b>, estoy aquí para ayudarte y mantenter el orden en los grupos de @TurboPower, si tienes alguna duda sobre lo que puedo hacer escribeme por privado: <b>Ayuda</b>", "HTML")
			->send();
		}

		// PRUEBA DE CODIGO CON BASE DE DATOS - Esto hay que crearlo (Ayuda)
/*
		elseif($this->telegram->text_command("register")){
			$str = "Hola " .$this->telegram->user->first_name ."! ¿Me podrías decir si eres conductor o pasajero?\n"
					."(*Soy* ...)";
			if($this->is_shutup()){
				$str = "Hola! Ábreme y registrate por privado :)";
			}
			$this->telegram->send
				->notification(FALSE)
				->text($str, TRUE)
			->send();
			return;
		}

		// guardar datos
		elseif(
		    ($this->telegram->text_has(["Soy", "Voy de"]) && $this->telegram->text_has($colores)) or
		    ($this->telegram->text_has($colores) && $this->telegram->words() == 1)
		){
			if(!$datosdb->user_exists($user->id)){
				$text = trim(strtolower($this->telegram->last_word('alphanumeric-accent')));
				// Registrar al usuario si es del color correcto
				if(strlen($text) >= 4 and $datosdb->register($user->id, $text) !== FALSE){
					$name = $user->first_name ." " .$user->last_name;
					$datosdb->update_user_data($user->id, 'fullname', $name);
					$datosdb->step($user->id, 'SETNAME'); // HACK Poner nombre con una palabra
					// enviar mensaje al usuario
					$this->telegram->send
						->notification(FALSE)
						->reply_to(TRUE)
						->text("Muchas gracias $user->first_name! Por cierto, *¿cómo te llamas?* \n_(Me llamo...)_", TRUE)
					->send();
				}else{
					$this->telegram->send
						->notification(FALSE)
						->reply_to(TRUE)
						->text("No te he entendido bien...\n¿Puedes decirme sencillamente *soy juan*, *soy airam* o *soy alejandro*?", TRUE)
					->send();
				}
			}
		}else{
			// ---------
		}
	} */
        											/***********************************************************************************/
        											/*****************************    Sistema de ayudas    *****************************/						//OGG formato voice (notas)
        											/***********************************************************************************/

																																											// Novedades //
		elseif($this->telegram->receive(["Novedad", "Novedades"]) && $this->telegram->words() <= 2){
		    $text = "<i>Gracias por el interés puesto en mí, a continuación te monstraré lo que puedo hacer, lo que no y lo que pronto podré hacer:</i>\n\n"
		            ."<i>- Puedes pedirme el</i> <b>tiempo</b>. "  .$this->telegram->emoji(":green-check:"). "\n "
								."<i>- Puedes solicitarme la</i> <b>hora</b> - <i>(¿Que hora es?) </i>"  .$this->telegram->emoji(":green-check:"). "\n "
		            ."<i>- Podré</i> <b>expulsar y banear (bloquear)</b> <i>a todo miembro que no cumpla la normativa del grupo. </i>" .$this->telegram->emoji("\ud83d\udd34"). "\n "
								."<i>- Recibiréis al instante la información del</i> <b>1-1-2</b> <i>a traves de Twitter directamente en el grupo. </i>" .$this->telegram->emoji("\ud83d\udd34"). "\n "
								."<i>- Puedes escribir</i> <b>Normas</b> <i>y enviaré dicha normativa del grupo.</i> " .$this->telegram->emoji(":green-check:"). "\n "
								."<i>- Sistema para</i> <b>Bla Bla Car</b> <i>verificación de conductores y votos.</i> " .$this->telegram->emoji("\ud83d\udd34"). "\n"
								."<i>- Puedes ver la</i> <b>Lista negra</b> <i>y ver quienes son las personas problemáticas y de poca confianza. </i>" .$this->telegram->emoji(":green-check:"). "\n"
								."<i>- Las</i> <b>Normas en texto</b> <i>o en</i> <b>Audio</b> - <i>(Pronto en audio)</i> " .$this->telegram->emoji(":warning:"). "\n"
								."<i>- Escribe</i> <b>Actualización Normas</b> <i>y te diré cuando ha sido la última actualización de las normas y en qué grupo.</i> " .$this->telegram->emoji(":green-check:"). "\n"
								."<i>- Te puedo enviar la</i> <b>Lista de grupos</b> <i>con todos los enlaces para acceder a ellos (únicamente donde estoy de guardia).</i> " .$this->telegram->emoji(":green-check:"). "\n\n"
								."<b>##LEYENDA##</b>\n"
								."		<i>- En proceso de creación</i> " .$this->telegram->emoji(":warning:"). "\n"
								."		<i>- El proceso no ha comenzado</i> " .$this->telegram->emoji("\ud83d\udd34"). "\n"
								."		<i>- El proceso ha finalizado y está funcionando</i> " .$this->telegram->emoji(":green-check:");
		    $this->telegram->send
		        ->text($text, "HTML")
		    ->send();
	    }
			elseif($this->telegram->receive(["Lista rutas", "Listado rutas"]) && $this->telegram->words() <= 2){
					$text = "<i>A continuación te mostraré la lista de rutas de los miembros:</i>\n\n"
									."- @Neptuno1 <b>Todos los días de El Paso a Tazacorte a las 6:50 de la mañana.</b>\n"
									."- @Atr4563 <b>Lunes a Sábado de Santa Cruz - El Paso. Ida a las 7 de la mañana y vuelta a las 7 de la tarde.</b>\n"
									."- @bea87 <b>Lunes a Viernes desde Barlovento - Los Cancajos 9:00 de la mañana , Los Cancajos - Barlovento  19:00</b>\n"
									."- @Estrambotika <b>Lunes a Viernes Los Llanos - Santa Cruz ida a las 6:15 de la mañana y vuelta SC - Los Llanos a las 15:00</b>\n"
									."- @Cdhcrack <b>Casi todos los findes desde Puntallana subida a Marcos y Corderos</b>\n"
									."- @Ilusionporvivir <b>Todos los días de Los Llanos a San Pedro sobre las 7:15</b>\n"
									."- @JorgeSastre <b>Casi todos los días Los Llanos - Santa Cruz, a las 7:00 de la mañana.</b>\n\n"
									."<i>* Si quieres ser añadido a la lista escribe por privado a</i> @TurboPower u @oceanwoman ";
					$this->telegram->send
							->text($text, "HTML")
					->send();
				}
																																										// Ayuda tiempo //
        elseif($this->telegram->receive(["Ayuda tiempo", "ayuda tiemp"]) && $this->telegram->words() <= 2){
            $text = "<i>Para saber el tiempo de tu zona debes de escribir</i> <b>Tiempo de</b> <i>y la zona que deseas averiguar.</i>\n\n"
                     	."<b>•</b> <i>Esta es la lista de los sitios disponibles para saber el tiempo, si quieres que sea añadido alguno más contacta con mi jefe:</i>\n"
                     	."<b>- Los Llanos de Aridane</b>\n"
			        		 		."<b>- Santa Cruz de La Palma</b>\n"
                     	."<b>- Tazacorte</b>\n"
                     	."<b>- El Paso</b>\n\n"
                     	."<i>- Toda la información recopilada está sacada directamente de la\n"
					 .$this->telegram->emoji(":global_with_meridians:") ."</i> <b>AEMET</b>" .$this->telegram->emoji(":global_with_meridians:"). "\n\n"
					 					."<i>* La información dada se lee primero la mínima y después la máxima de cada valor.</i>\n\n"
					 					."<b>##LEYENDA VIENTO##</b>\n"
										."		<b>- C:</b> <i>En Calma</i>\n"
										."		<b>- SO:</b> <i>Suroeste</i>\n"
										."		<b>- NE:</b> <i>Nordeste</i>\n";
            $this->telegram->send
                ->text($text, "HTML")
            ->send();
        }
																																										// Ayuda ubicacion //
		elseif($this->telegram->receive(["Ayuda ubicacion", "ayuda ubicación"]) && $this->telegram->words() <= 2){
			$text = "<i>Si quiere recibir la ubicación de un lugar puedes escribir</i> <b>Ubicación o Envíame la ubicación</b> <i>y la zona que deseas que te envíe.</i> \n\n"
					 ."<b>•</b> <i>Esta es la lista de los sitios disponibles de los que te puedo enviar la ubicación, si quieres que sea añadido alguno más contacta con mi jefe:</i>\n"
					 ."<b>- Hospital General</b>\n"
					 ."<b>- Policia Nacional</b>\n"
					 ."<b>- Hospital de dolores</b>\n";
			$this->telegram->send
				->text($text, "HTML")
			->send();
		}

        																																								// Ayuda General //
		elseif($this->telegram->receive("Ayuda") && $this->telegram->words() <= 1){ ## Ayuda General sobre lo que puedo hacer AÑADIR AYUDA UBICACION, AYUDA TIEMPO
			$text = "<b>Muy buenas!</b> <i>A continuación te mostraré una lista de todo lo que he aprendido de momento:</i>\n\n"
                    ."- <i>Si escribes</i> <b>Ayuda Ubicación</b> <i>te mostraré una lista de las ubicaciones disponibles.</i>\n"
										."- <i>Puedes decirme</i> <b>Lista de Grupos</b> <i>y te daré los enlaces de todos los grupos que Administro.</i>"
										."- <i>Revisa la lista negra de los miembros problemáticos y que han sido expulsados escribiendo:</i> <b>Lista Negra.</b>\n"
                    ."- <i>Para saber las zonas que puedes consultar el tiempo escribe</i> <b>Ayuda Tiempo</b>.\n"
										."- <i>Escribe</i> <b>Administradores</b> <i>para saber quienes son los Administradores del grupo.</i>\n"
                    ."- <i>Para saber lo que hay de nuevo y lo que está por llegar escribe</i> <b>Novedades</b>\n"
										."- <i>Si quieres saber la hora pídemela</i> (<b>¿Qué hora es?</b>)\n"
										."- <i>Ahora puedes saber el tiempo que hace escribiendo</i> <b>El Tiempo de</b> <i>y seguido de la zona </i>: \n\n"
                    ."		<b>• Los Llanos de Aridane</b>\n"
										."		<b>• Santa Cruz de La Palma</b>\n"
										."		<b>• Tazacorte</b>\n"
										."		<b>• El Paso</b>\n\n"
                    ."<i>Recuerdo que tengan paciencia y si tienen alguna duda lo hagan por privado a mi jefe @TurboPower</i>\n\n"
					.$this->telegram->emoji(":banned:") ."<b>NO olvides que está prohibido abusar de mis funciones en los grupos! Puede conllevar a la expulsión del mismo</b>" .$this->telegram->emoji(":banned:");
			$this->telegram->send
				->text($text, "HTML")
			->send();
		}
																																											// Normas //

																																				// Normas en texto controles //
		elseif($this->telegram->text_has(["normas en"], "texto") && $this->telegram->text_contains("grupo 1") && $this->telegram->words() <= 5){
			$text = "<i>Querido miembro, las siguientes normas se aplican al grupo</i> <b>#1 - Grupo 1</b> <i> de </i><b>@TurboPower:</b>\n\n"
							."<i>- No se pueden enviar imágenes de cuerpos oficiales y sus vehiculos.</i>\n"
							."<i>- No enviar imágenes de un accidente donde salga la persona accidentada o el vehículo.</i>\n"
							."<i>- Prohibido enviar falsos avisos, a esto se refiere por ejemplo,</i> <b>de los Llanos a El Paso libre</b>.\n"
							."<i>- Preguntar por el grupo si de un lado (El paso) a Los llanos (por ejemplo) está libre, si no se ha puesto nada en los grupos es por algo.</i>\n"
							."<i>- Cualquier</i> <b>falta de respeto</b> <i>a un integrante del grupo o al Administrador será castigada con la expulsión directa y bloqueo del grupo.</i>\n"
							."<i>- Si no está conforme a las normas y publicas algún comentario obsceno o cualquier comentario inapropiado quedará expulsado permanentemente de todos los grupos y añadido a la</i> <b> Lista negra.</b>\n\n"
              ."<i>* Si quieres recibir las normas en audio escribe:</i> <b>Normas en audio grupo 1</b> <i>(No disponible aún).</i>";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->text_has(["normas en"], "texto") && $this->telegram->text_contains("grupo 2") && $this->telegram->words() <= 5){
			$text = "<i>Querido miembro, las siguientes normas se aplican al grupo</i> <b>#1 - grupo 2</b> <i> de </i><b>@TurboPower:</b>\n\n"
							."<i>- Prohibida la venta de animales de compañía, ya sean gatos, perros, aves,...</i>\n"
							."<i>-</i> <b>IMPORTANTE!</b> <i>Prohibido publicar el mismo anuncio en menos de 24h (1 día).</i>\n"
							."<i>- Criticar el precio o estado del anunciante. Si crees que no deberia de estar ese anuncio, no estas conforme con el precio o su estado habla con la persona que lo ha publicado</i> <b>POR PRIVADO</b> <i>y</i> <b>SIEMPRE manteniendo la calma y respeto.</b>\n"
							."<i>- Hablar por privado a cualquier integrante del grupo, únicamente para negociar sobre un artículo y nunca hacerlo dentro del grupo.</i>\n"
							."<i>- Enviar un anuncio sin publicar la imagen original del mismo</i> (<b>OJO!</b> <i>No es obligatorio poner precio pero sí se debería... Al que le interese un artículo, hablar por privado al anunciante.</i>\n"
							."<i>- Publicar enlaces de cualquier tipo al igual que imágenes de otro interés conllevará a la expulsión directa sin aviso.</i>\n"
							."<i>- Cualquier falta de respeto a un integrante del grupo o al Administrador será castigada con la expulsión directa y bloqueo del grupo.</i>\n"
							."<i>- Máximo dos imágenes del artículo con precio en una de las fotos y descripción (no obligatorio pero sí un máximo de dos imágenes).</i>\n"
							."<i>- Máximo de una publicación diaria y no repetir el anuncio pasada una semana.</i>\n"
							."<i>- Si no está conforme a las normas y publicas algún comentario obsceno o cualquier comentario inapropiado quedará expulsado permanentemente de todos los grupos y añadido a la</i> <b> Lista negra.</b>\n\n"
              ."<i>* Si quieres recibir las normas en audio escribe:</i> <b>Normas en audio grupo 2</b> <i>(No disponible aún).</i>";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->text_has(["normas en"], "texto") && $this->telegram->text_contains("grupo 3") && $this->telegram->words() <= 5){
			$text = "<i>Querido miembro, las siguientes normas se aplican al grupo</i> <b>grupo 3</b><i> de </i><b>@TurboPower</b> <i>y</i> <b>@oceanwoman</b>\n\n"
							."<i>- Todo miembro de este grupo deberá estar registrado en la web/aplicación oficial de Bla Bla Car para así poder dar los votos y consultar la reputación de dicho conductor en caso de viajar con el para más seguridad y confianza, también deberá de especificar el tipo de vehículo que lleva, a ser posible poniendo una foto de el (no es obligatorio).</i>\n"
							."<i>- El conductor impone las normas, si se puede fumar o no en el coche, comer/beber, la cantidad y tamaño del equipaje, las personas que puede transportar a la vez en el vehículo (asientos traseros y delanteros y por supuesto el importe por llevar a cada persona.</i>\n"
							."<i>- A la vez que se publiquen los viajes a través de la pagina, podéis publicarlos en el grupo de Telegram para darlo a conocer y llegar a más gente, pero siempre recomendamos a los acompañantes que antes de subirse al coche comprueben la buena reputación del conductor a través de la pagina web de bla bla car por vuestra seguridad y a su vez a los conductores para garantizar su buena reputación y conseguir compartir más viajes.</i>\n"
							."<i>- Si no está conforme a las normas y publicas algún comentario obsceno o cualquier comentario inapropiado quedará expulsado permanentemente de todos los grupos y añadido a la</i> <b> Lista negra.</b>\n\n"
		          ."<i>* Si quieres recibir las normas en audio escribe:</i> <b>Normas en audio grupo 3</b> <i>(No disponible aún).</i>";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}
 
 			//GET DB (Ayuda)
		elseif($this->telegram->receive("Lista negra") && $this->telegram->words() <= 2){ 
			$text = "<b>LISTA NEGRA</b>\n\n"
							."- <i>De momento no hay ningún miembro en la lista.</i>";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->receive("Lista de grupos") && $this->telegram->words() <= 3){
			$text = "<b>LISTA DE GRUPOS</b>\n"
							."<i>La siguiente lista son de grupos que colaboran con el funcionamiento de este bot y a su vez recomendamos dichos grupos por el buen funcionamiento:</i>\n\n"
							."- <b>Grupo 1:</b> @controleslapalma <i>| Informa del estado de la vía, accidentes y otros incidentes para estar informados.</i>\n"
							."- <b>Grupo 2:</b> @tumejorofertalapalma <i>| Grupo de Compra/Venta en La Palma.</i>\n"
							."- <b>Grupo 3:</b> @compartircochelapalma <i>| Comparte vehículo con otras personas que vayan al mismo destino que tú.</i>\n\n"
							."- <i> Si quieres que tu grupo esté aquí contacta con @TurboPower por privado.</i>";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->receive("Normas") && $this->telegram->words() <= 1){
			$text = "<i>Para saber que normativa cumplo puedes pedirme la lista de normas en texto o en audio:</i>\n\n"
							."<i>* Para recibir las normas de un grupo en concreto escribe,</i> <b>Normas</b> <i>seguido de como quieres que te las envíe,</i> <b>en texto</b> <i>o</i> <b>en audio</b> <i>terminando con el grupo en concreto</i> "
							."<i>del que quieres saber las normas</i>, <b>Grupo 1</b><i>,</i> <b>Grupo 2</b> <i>ú</i> <b>Grupo 3.</b> <i>Ejemplo:</i> <b>Normas en texto Grupo 1</b>\n\n"
							."- <i>Si quieres recibir las normas en texto escribe:</i> <b>Normas en texto</b>\n"
							."- <i>Si quieres recibir las normas en audio escribe:</i> <b>Normas en audio</b>.\n\n"
							."{ <b>Grupo 1</b> - <i>Controles La Palma</i> | <b>Grupo 2</b> - <i>Tu Mejor Oferta</i> | <b>Grupo 3</b> - <i>Carshare La Palma</i> }\n\n"
							."- <i>¡Enterate de cuando se actualizen las normas! Escribe:</i> <b>Actualización Normas</b>.\n";
					$this->telegram->send
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->receive(["Actualizacion Normas", "Actualización Normas"]) && $this->telegram->words() <= 2){
			$time = strtotime("2021-03-04 19:20"); // El 24
			$actualizacion = strtotime("now") - $time;
			$text = "<b>Última actualización de las normas:</b> Hace " .floor($actualizacion / (60*60*24)) ." días. ";
			$this->telegram->send
			->text($text, "HTML")
			->send();
		}

		// Enlaces descarga bla bla car y notas audio normas
													/***********************************************************************************/
												 	/****************************    Sistemas Generales    ***************************/
													/***********************************************************************************/

	// Enviar por privado																																				// Mensaje bienvenida //
	/*	elseif($this->telegram->data_received() == "new_chat_participant"){
				$text = "<i>- Has ingresado correctamente al grupo:</i><b> " .$this->telegram->chat->title ."</b>";
				if($this->telegram->is_chat_group() && !empty($this->telegram->chat->username)){ $text .=" @" .$this->telegram->chat->username; }
				$text .= "\n";
				$text .= "<b>- Bienvenid@:</b> "  .$this->telegram->user->first_name ." " .$this->telegram->user->last_name ." ";
				if(!empty($this->telegram->user->username)){ $text .=" @" .$this->telegram->user->username; }
				$text .= "\n";
				$text .= "<i>* Recuerda leer las normas para evitar ser expulsado</i> " .$this->telegram->emoji("\ud83d\udccb");


				$this->telegram->send
					->reply_to(FALSE)
					->text($text, "HTML")
				->send();
			} */
	// Filtrado de Palabras																																																																									// kickear y banear //
	elseif($this->telegram->receive(["grupo de", "https://", "http://", "gilipollas", "estafador", "ventas", "libre de", "compra venta", "enlace", "mierda", "Puta", "puto", "capullo", "capulla", "cabron", "tontos", "tonto", "https", "http", "direccion a", "trail direccion"]) && $this->telegram->words() <= 2){
			$this->telegram->send
			->kick($this->telegram->user->id, $this->telegram->chat->id);
		}
	// Kick de usuarios y arreglar Ban
		elseif($this->telegram->text_has(["/kick", "/ban"], TRUE) && $this->telegram->is_chat_group()){
			$admins = $this->telegram->get_admins();
			$admins[] = $this->config->item('creator');
			$admins[] = $this->config->item('telegram_bot_id');
			if(in_array($this->telegram->user->id, $admins)){ // Tiene que ser admin
				$kick = NULL;
				if($this->telegram->has_reply){
					$kick = $this->telegram->reply_user->id;
				}elseif($this->telegram->words() == 2){
					// Buscar usuario.
					$kick = ($this->telegram->text_mention() ? $this->telegram->text_mention() : $this->telegram->last_word());
					if(is_array($kick)){ $kick = key($kick); } // Get TelegramID
					// Buscar si no en PKGO user DB.
				}
				if(($this->telegram->user->id == $this->config->item('creator')) or !in_array($kick, $admins)){ // Si es creador o no hay target a admins
					if($this->telegram->text_contains("kick")){
						$this->telegram->send->kick($kick, $this->telegram->chat->id);
					}elseif($this->telegram->text_contains("ban")){
						$this->telegram->send->ban($kick, $this->telegram->chat->id);
					}
				}
			}
		}
																																																																																										// Saber la hora //
		elseif($this->telegram->text_has(["qué", "la"], "hora") && $this->telegram->text_contains("?") && $this->telegram->words() <= 4){  // Forzar a poner ?
					$this->telegram->send
					->text("<i>Son las</i> " .date("<b>H:i</b>", strtotime("+0 hour")) ."<i>, una hora más en la peninsula</i> " .$this->telegram->emoji("\u23f0"), "HTML")
					->send();
        }																																																																																						// Mensaje Muchas Gracias //
        elseif($this->telegram->receive(["Muchas gracias", "Gracias"]) && $this->telegram->words() <= 2){ ## Respuesta a las gracias
			$this->telegram->send
				->text("Muchas gracias a ti por contactar conmigo y espero te haya sido útil la respuesta! " .$this->telegram->emoji("\ud83d\udc6e"), "HTML")
                ->reply_to(TRUE)
			->send();
		}


																																																																																							// Enviar ubicación //
		elseif($this->telegram->text_has(["enviame la", "mandame", "la"], "ubicacion") && $this->telegram->text_contains("hospital general", "hospital") && $this->telegram->words() <= 20){
			$this->telegram->send
				->location(28.6726446,-17.7899276,726)
			->send();
            $this->telegram->send
                ->text($this->telegram->emoji("\ud83d\udd30") ."<i>Ésta es la ubicación del Hospital General de La Palma</i>" .$this->telegram->emoji("\ud83d\udd30"), "HTML")
            ->send();
		//	$this->telegram->send
		//		->file('sticker', "BQADAgADTAADGgZFBMqkqh9r_0fNAg");
		}

		elseif($this->telegram->text_has(["enviame la", "mandame", "la"], "ubicacion") && $this->telegram->text_contains("policia nacional", "policia") && $this->telegram->words() <= 10){
			$this->telegram->send
				->location(28.6879667,-17.7607622)
			->send();
            $this->telegram->send
                ->text($this->telegram->emoji("\ud83d\udd30") ."<i>Ésta es la ubicación de la Policia Nacional</i>" .$this->telegram->emoji("\ud83d\udd30"), "HTML")
            ->send();
		//	$this->telegram->send
		//		->file('sticker', "BQADAgADTAADGgZFBMqkqh9r_0fNAg");
		}

		elseif($this->telegram->text_has(["enviame la", "mandame", "la"], "ubicacion") && $this->telegram->text_contains("hospital de dolores", "hospital dolores") && $this->telegram->words() <= 10){
			$this->telegram->send
				->location(28.6850537,-17.763085)
			->send();
            $this->telegram->send
                ->text($this->telegram->emoji("\ud83d\udd30") ."<i>Ésta es la ubicación del Hospital de Dolores</i>" .$this->telegram->emoji("\ud83d\udd30"), "HTML")
            ->send();
		//	$this->telegram->send
		//		->file('sticker', "BQADAgADTAADGgZFBMqkqh9r_0fNAg");
		}
																																																																																				// Enviar mensaje a grupos //
elseif($this->telegram->receive("repite grupo 1 ", NULL, TRUE)){
			$text = $this->telegram->text();
			$text = substr($text, strlen("repite grupo 1 "));
			$this->telegram->send
				->chat("-1001006120181")
				->text($text, "HTML")
			->send();
		}

		elseif($this->telegram->receive("repite grupo 2 ", NULL, TRUE) && $user->id = $this->config->item('creator')){
			$text = $this->telegram->text();
			$text = substr($text, strlen("repite grupo 2 "));
			$this->telegram->send
				->chat("-1001004172849")
				->text($text, "HTML")
			->send();
		}

elseif($this->telegram->receive("repite grupo 3 ", NULL, TRUE) && $user->id = $this->config->item('creator')){
			$text = $this->telegram->text();
			$text = substr($text, strlen("repite grupo 3 "));
			$this->telegram->send
				->chat("-1001048596638")
				->text($text, "HTML")
			->send();
		}
																																							// Anuncio a todos
		elseif($this->telegram->receive("anuncio todos", NULL, TRUE) && $user->id = $this->config->item('creator')){

			$this->telegram->send->chat("-1001006120181")

			->file('voice', FCPATH . '/files/anuncio.mp3');
		}
																																								// Enviar anuncios //
		elseif($this->telegram->receive("anuncio grupo 1", NULL, TRUE) && $user->id = $this->config->item('creator')){

			$this->telegram->send->chat("-1001006120181")
			->file('audio', FCPATH .'/files/anuncio.mp3');
		}
																																							// Anuncio controles //
		elseif($this->telegram->receive("anuncio grupo 2", NULL, TRUE) && $user->id = $this->config->item('creator')){

			$this->telegram->send->chat("ID")
			->file('voice', FCPATH .'/files/grupo 2.ogg');
		}
																																							// anuncio tu mejor oferta //
		elseif($this->telegram->receive("anuncio grupo 3", NULL, TRUE) && $user->id = $this->config->item('creator')){
			$this->telegram->send->chat("ID")
			->file('voice', FCPATH .'/files/grupo 3.ogg');
		}
																																		// Para saber donde estás, id grupo, id de usuario //
		elseif($this->telegram->receive("donde estoy")){
			$text = "- Estás en el grupo: " .$this->telegram->chat->title ." (" .$this->telegram->chat->id .")";
			if($this->telegram->is_chat_group() && !empty($this->telegram->chat->username)){ $text .=" @" .$this->telegram->chat->username; }
			$text .= "\n";
			$text .= "- Eres: " .$this->telegram->user->first_name ." " .$this->telegram->user->last_name ." \n- Tienes esta ID: (" .$this->telegram->user->id .")";
			if(!empty($this->telegram->user->username)){ $text .=" @" .$this->telegram->user->username; }

			$this->telegram->send
				->reply_to(TRUE)
				->text($text)
			->send();
		}

																																									// Tiempo los llanos //
		elseif($this->telegram->receive(["tiempo de los llanos de aridane", "tiempo de los llanos", "tiempo en los llanos"]) && $this->telegram->words() <= 6){
			$web = "http://www.aemet.es/xml/municipios/localidad_38024.xml";
			$data = file_get_contents($web);

			$xml = simplexml_load_string($data);
			$tiempo = [$xml->prediccion->dia[0]->temperatura->minima, $xml->prediccion->dia[0]->temperatura->maxima];
			$humedad = [$xml->prediccion->dia[0]->humedad_relativa->minima, $xml->prediccion->dia[0]->humedad_relativa->maxima];
			$termica = [$xml->prediccion->dia[0]->sens_termica->minima, $xml->prediccion->dia[0]->sens_termica->maxima];
			$hora = floor(date("H") / 6);
			$hora = $hora * 6;
			$subhora = $hora + 6;

			$hora = str_pad($hora, 2, "0", STR_PAD_LEFT);
			$subhora = str_pad($subhora, 2, "0", STR_PAD_LEFT);
			$atr = $hora ."-" .$subhora;
			$datos = $xml->xpath('//prediccion/dia[@fecha="' .date("Y-m-d") .'"]/viento[@periodo="' .$atr .'"]');
			$datos = $datos[0];


	//		$prob_precipitacion = [$xml->prediccion->dia[0]->prob_precipitacion];

			$text = "<b>Temperatura: </b>". $tiempo[0] ." / " .$tiempo[1] ."ºC " .$this->telegram->emoji(":sunny:") ."\n"
					."<b>Humedad: </b>". $humedad[0] ." / " .$humedad[1] ."% " .$this->telegram->emoji(":cloud:") ."\n"
					."<b>Sensación termica: </b>". $termica[0] ." / " .$termica[1] ."ºC " .$this->telegram->emoji("\u2668") ."\n"
					."<b>Viento:</b> " /*.$atr .": " */.$datos->velocidad ." Kmh / " .$datos->direccion  ." " .$this->telegram->emoji(":leaves:") ."\n";
				$this->telegram->send
				->text($text, "HTML")
					->send();

		}
																																										// Tiempo SC //
		elseif($this->telegram->receive(["tiempo de santa cruz", "tiempo de sc", "tiempo en sc", "tiempo en santa cruz"]) && $this->telegram->words() <= 17){
			$web = "http://www.aemet.es/xml/municipios/localidad_38037.xml";
			$data = file_get_contents($web);

			$xml = simplexml_load_string($data);
			$tiempo = [$xml->prediccion->dia[0]->temperatura->minima, $xml->prediccion->dia[0]->temperatura->maxima];
			$humedad = [$xml->prediccion->dia[0]->humedad_relativa->minima, $xml->prediccion->dia[0]->humedad_relativa->maxima];
			$termica = [$xml->prediccion->dia[0]->sens_termica->minima, $xml->prediccion->dia[0]->sens_termica->maxima];
			$hora = floor(date("H") / 6);
			$hora = $hora * 6;
			$subhora = $hora + 6;

			$hora = str_pad($hora, 2, "0", STR_PAD_LEFT);
			$subhora = str_pad($subhora, 2, "0", STR_PAD_LEFT);
			$atr = $hora ."-" .$subhora;
			$datos = $xml->xpath('//prediccion/dia[@fecha="' .date("Y-m-d") .'"]/viento[@periodo="' .$atr .'"]');
			$datos = $datos[0];

				$text = "<b>Temperatura: </b>". $tiempo[0] ." / " .$tiempo[1] ."ºC " .$this->telegram->emoji(":sunny:") ."\n"
						."<b>Humedad: </b>". $humedad[0] ." / " .$humedad[1] ."% " .$this->telegram->emoji(":cloud:") ."\n"
						."<b>Sensación termica: </b>". $termica[0] ." / " .$termica[1] ."ºC " .$this->telegram->emoji("\u2668") ."\n"
						."<b>Viento:</b> " /*.$atr .": " */.$datos->velocidad ." Kmh / " .$datos->direccion  ." " .$this->telegram->emoji(":leaves:") ."\n";
					$this->telegram->send
					->text($text, "HTML")
						->send();

		}


elseif($this->telegram->receive(["tiempo de tazacorte", "tiempo en tazacorte"]) && $this->telegram->words() <= 3){
			$web = "http://www.aemet.es/xml/municipios/localidad_38045.xml";
			$data = file_get_contents($web);

			$xml = simplexml_load_string($data);
			$tiempo = [$xml->prediccion->dia[0]->temperatura->minima, $xml->prediccion->dia[0]->temperatura->maxima];
			$humedad = [$xml->prediccion->dia[0]->humedad_relativa->minima, $xml->prediccion->dia[0]->humedad_relativa->maxima];
			$termica = [$xml->prediccion->dia[0]->sens_termica->minima, $xml->prediccion->dia[0]->sens_termica->maxima];
			$hora = floor(date("H") / 6);
			$hora = $hora * 6;
			$subhora = $hora + 6;

			$hora = str_pad($hora, 2, "0", STR_PAD_LEFT);
			$subhora = str_pad($subhora, 2, "0", STR_PAD_LEFT);
			$atr = $hora ."-" .$subhora;
			$datos = $xml->xpath('//prediccion/dia[@fecha="' .date("Y-m-d") .'"]/viento[@periodo="' .$atr .'"]');
			$datos = $datos[0];

				$text = "<b>Temperatura: </b>". $tiempo[0] ." / " .$tiempo[1] ."ºC " .$this->telegram->emoji(":sunny:") ."\n"
						."<b>Humedad: </b>". $humedad[0] ." / " .$humedad[1] ."% " .$this->telegram->emoji(":cloud:") ."\n"
						."<b>Sensación termica: </b>". $termica[0] ." / " .$termica[1] ."ºC " .$this->telegram->emoji("\u2668") ."\n"
						."<b>Viento:</b> " /*.$atr .": " */.$datos->velocidad ." Kmh / " .$datos->direccion  ." " .$this->telegram->emoji(":leaves:") ."\n";
					$this->telegram->send
					->text($text, "HTML")
						->send();

		}

elseif($this->telegram->receive(["tiempo de el paso", "tiempo en el paso"]) && $this->telegram->words() <= 4){
			$web = "http://www.aemet.es/xml/municipios/localidad_38027.xml";
			$data = file_get_contents($web);

			$xml = simplexml_load_string($data);
			$tiempo = [$xml->prediccion->dia[0]->temperatura->minima, $xml->prediccion->dia[0]->temperatura->maxima];
			$humedad = [$xml->prediccion->dia[0]->humedad_relativa->minima, $xml->prediccion->dia[0]->humedad_relativa->maxima];
			$termica = [$xml->prediccion->dia[0]->sens_termica->minima, $xml->prediccion->dia[0]->sens_termica->maxima];
			$hora = floor(date("H") / 6);
			$hora = $hora * 6;
			$subhora = $hora + 6;

			$hora = str_pad($hora, 2, "0", STR_PAD_LEFT);
			$subhora = str_pad($subhora, 2, "0", STR_PAD_LEFT);
			$atr = $hora ."-" .$subhora;
			$datos = $xml->xpath('//prediccion/dia[@fecha="' .date("Y-m-d") .'"]/viento[@periodo="' .$atr .'"]');
			$datos = $datos[0];

				$text = "<b>Temperatura: </b>". $tiempo[0] ." / " .$tiempo[1] ."ºC " .$this->telegram->emoji(":sunny:") ."\n"
						."<b>Humedad: </b>". $humedad[0] ." / " .$humedad[1] ."% " .$this->telegram->emoji(":cloud:") ."\n"
						."<b>Sensación termica: </b>". $termica[0] ." / " .$termica[1] ."ºC " .$this->telegram->emoji("\u2668") ."\n"
						."<b>Viento:</b> " /*.$atr .": " */.$datos->velocidad ." Kmh / " .$datos->direccion  ." " .$this->telegram->emoji(":leaves:") ."\n";
					$this->telegram->send
					->text($text, "HTML")
						->send();

		}
																																			// Para saber quienes son los Administradores //
		elseif($this->telegram->receive(["quien", "quién", "lista", "administradores"]) && $this->telegram->receive("admin") && $this->telegram->is_chat_group()){
			$admins = $this->telegram->get_admins($this->telegram->chat->id, TRUE);
			$str = "";
			foreach($admins as $k => $a){
				if($a['status'] == 'creator'){
					unset($admins[$k]);
					array_unshift($admins, $a);
				}elseif($a['user']['id'] == $this->config->item('telegram_bot_id')){
					unset($admins[$k]);
					array_push($admins, $a);
				}
			}
			foreach($admins as $k => $a){
				$str .= $a['user']['first_name'] ." ";
				if(isset($a['user']['username'])){ $str .= "( @" .$a['user']['username'] ." ) " .$this->telegram->emoji(":green-check:"); }
				if($k == 0){ $str .= "\n"; } // - Creator
				$str .= "\n";
			}
			$this->telegram->send
				->notification(FALSE)
				->text($str)
			->send();
		}
	}
																																							// Probar funciones //
		function prueba(){

			$web = "http://www.aemet.es/xml/municipios/localidad_38024.xml";
			$data = file_get_contents($web);

			$xml = simplexml_load_string($data);
			$tiempo = [$xml->prediccion->dia[0]->temperatura->minima, $xml->prediccion->dia[0]->temperatura->maxima];
			$humedad = [$xml->prediccion->dia[0]->humedad_relativa->minima, $xml->prediccion->dia[0]->humedad_relativa->maxima];

			echo ($tiempo[0] ." / " .$tiempo[1] ."ºC");
		}
	}
