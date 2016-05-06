# MongoSingleton PHP

MongoSingleton establece una conexión cliente Mongo DB con PHP.

## Ejemplo de implementación:

```php
<?php

  require 'MongoSingleton.php'; // Dirección del cliente Mongo
  
  $databaseConn = MongoSingleton::connect(<"usuario">,<"contraseña">,<"nombreBaseDatos">);
  
  if($databaseConn != null)
  {
    // Ejemplo de una consulta find de la colección usuarios
    $cursor = $database->usuarios->find();

		foreach ( $cursor as $id => $value )
		{
		    print json_encode( $value );
		    echo "<br/>";
		}
  }

?>
```


Basado en : [https://github.com/calebjonasson/mongodb-php-singleton](https://github.com/calebjonasson/mongodb-php-singleton)
