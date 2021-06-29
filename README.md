## wsm-backend-test-SAGE
Test for Software Ingeniering job

# Los archivos agregados al proyecto son:
  src:---
        |----Controller:----
        |                  |-------ReportsController.php
        |
        |
        |-----lib:----
        |              |-------db_conection.php
        |              |
        |              |---------functions.php
        |
        |
        |----templates:--
                        |----tablesScreen.thml.twig
                        
En la catpeta lin se encuentra todo lo relacionado a la coneccionn de la base de datos,
cabe destacar que es necesario setear la variable de entorno MONGO_DATABASE para poder
conecctarse a la base de datos.

el archivo ReportsController.php se encarga de gestionar las consultas segun se requiera
y de renderizar el template tablesScreen.thml.twig con la informacion recuperada

En la carpeta img encontraran imagenes del proyecto en funcionamiento. Gracias por su 
tiempo de antemano, Atte. Sergio Gutierrez.
