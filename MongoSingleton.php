<?php
	
	/**
	 * NOTA IMPORTANTE
	 * Basado en : https://github.com/calebjonasson/mongodb-php-singleton
	 * Modificado por : Adrián Álvarez @chapitro
	 */

	/**
	 * MongoSingleton busca generar una instancia de la conexión con la Base de datos
	 * dado un usuario y una contraseña de usuario previamente configurada.
	 */
	class MongoSingleton
	{
		private static $_connection;
		private static $_instance;
		
		// El método constructor y el de clonación van a ser privados.
		private function __construct(){}
		private function __clone(){}

		/**
		 * Este método retornará la instancia del objeto creado por un cliente mongo.
		 * El retorno cambia dependiendo de $database parameter.
		 * 
		 * @param String $database : nombre de la base de datos
		 * @return Object $_connection : Cliente Mongo con la conexión establecida
		 **/
		public static function connect($_user, $_password, $database = null)
		{
			/*
			 * Crea el objeto de tipo MongoSingleton almacenado como atributo.
			 * Sólo se crea una única vez.
			 */
			if(!isset(self::$_instance))
			{
				self::$_instance = new MongoSingleton();
			}
			
			/*
			 * Establece una conexión Cliente a MongoDB
			 * Sólo se establece una única vez.
			 */
			if(!isset(self::$_connection))
			{
				try
				{
					self::$_connection = new MongoClient("mongodb://".$_user.":".	$_password."@localhost");
				}
				catch(Exception $e)
				{
					echo "Servidor MongoDB offline";
					return null;
				}
			}

			/*
			 * Se asegura que se haya establecido la conexión.
			 */
			if(!self::$_connection->connected) {
				throw new Exception("Error conexión con MongoDB.");
			}

			if(!empty($database) && is_string($database))
			{
				$connectedDatabase = self::$_connection->selectDB($database);
				if(isset($connectedDatabase)) {
					return $connectedDatabase;
				}else{
					throw new Exception("No se pudo conectar a la base de datos deseada.");
				}
			}

			return self::$_connection;
		}
	}

	/*
		Nota: Recuerde que esto retorna no solo la conexión al servidor de MongoDB,
		sino también la conexión ya establecida con el usuario/contraseña a una base de datos específica.
		Por lo que queda es realizar consultas a sus colecciones.
	*/

?>
