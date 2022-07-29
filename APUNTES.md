# Apuntes Symfony 4
#### GETTING STARTED
- [x] Setup / Installation
- [x] Creating Pages
- [x] Routing / Generating URLs
- [x] Controllers
- [ ] Templates / Twig
- [ ] Configuration / Env Vars
#### ARCHITECTURE
- [ ] Requests / Responses
- [ ] Kernel
- [ ] Services / DI
- [ ] Events
- [ ] Contracts
- [ ] Bundles
#### THE BASICS
- [ ] Databases / Doctrine
- [ ] Forms
- [ ] Tests
- [ ] Sessions
- [ ] Cache
- [ ] Logger
- [ ] Errors / Debugging
#### ADVANCED TOPICS
- [ ] Console
- [ ] Mailer / Emails
- [ ] Validation
- [ ] Messaging / Queues
- [ ] Notifications
- [ ] Serialization
- [ ] Translation / i18n
#### SECURITY
- [ ] Introduction
- [ ] Users
- [ ] Authentication / Firewalls
- [ ] Authorization / Voters
- [ ] Passwords
- [ ] CSRF
- [ ] LDAP
#### FRONT-END
- [ ] Symfony UX / Stimulus
- [ ] Webpack Encore
- [ ] React.js
- [ ] Vue.js
- [ ] Bootstrap
- [ ] Web Assets
- [ ] WebLink
#### UTILITIES
- [ ] HTTP Client
- [ ] Files / Filesystem
- [ ] Expression Language
- [ ] Locks
- [ ] Workflows
- [ ] Strings / Unicode
- [ ] UID / UUID
- [ ] YAML Parser
#### PRODUCTION
- [ ] Deployment
- [ ] Performance
- [ ] HTTP Cache
- [ ] Cloud / Platform.sh

# Setup / Installation

## Symfony Flex
Se usa symfony flex para instalar y configurar paquetes automáticamente. 
Es un complemento de composer.
Permite instalar recipes que son recetas de paquetes preconfigurados que se implementan en symfony
Las recipes son implementadas por algunos bundles de Symfony para instalar los paquetes necesarios
Al instalar una receta de Flex está descomprime automáticamente el resto de paquetes en composer, por lo tanto se ven los paquetes y no la receta.

Ej:
- composer require logger => I 

Si encuentra un error al instalar “ composer require logger “:
1. composer remove symfony/symfony
2. composer require symfony/flex

## License
La licencia de uso de symfony es de código libre, cualquier persona puede usar el software para reproducir, modificar o crear copias, mientras se encuentre agregada esta licencia.

## Components

#### Assets
https://symfony.com/doc/4.4/components/asset.html
Se encarga de la generación de urls y versionado de los assets del sitio web (CSS, JS & Archivos Multimedia).

Permite:
- Definir versiones de assets
- Mover archivos solo cambiando la ruta asociada al asset
- Usar CDNs y HTTP o HTTPS de manera automática
- Versionar los activos
- Obtener activos por medio de distintos protocolos file/ftp/etc…
- Obtener activos según el contexto “application/…”
- Obtener activos por nombre de tipo de activo

#### PHPUNIT
https://symfony.com/doc/4.4/testing.html

Componente para pruebas en Symfony, implementa PHPUnit. Cada prueba es una clase que termina en “Test”, en la carpeta tests.

#### Fixturres
https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html

Componenete para crear datos de prueba para cargar la base de datos.

# Controllers
Suele ser un método dentro de una clase Controller

## Naming conventions
- `namespace App\Controller;`
- `class ControlladorController {}`

## The base Controller class
Symfony cuenta con una base controller opcional llamada AbstractController
https://github.com/symfony/symfony/blob/4.4/src/Symfony/Bundle/FrameworkBundle/Controller/AbstractController.php

## Internal redirects
Generar la URL de una ruta determinada
`$this->generateUrl(string $nameRoute, ?array $params)`

## HTTP redirects
- $this->redirectToRoute(string $nameRoute, ?array $params, int $responseCode) 
- Es igual a: return new RedirectResponse($this->generateUrl('homepage'));
- Los códigos de respuesta están como constantes en la clase Response: Response::HTTP_MOVED_PERMANENTLY
- `$this->redirect(‘http://url.externa.com’)` Redirección externa

## Renderizado de plantillas
Para renderizar una plantilla se debe retornar el método:
`return $this->render(string $direccionPlantilla , array $params);`

## Autowiring de Servicios
- Para usar clases de servicios Symfony se pueden solicitar en cada una de las acciones del controlador, entonces symfony las pasará automáticamente.
- Para conocer la lista de servicios disponibles para autowiring, se puede usar el comando en consola: php bin/console debug:autowiring
- También se puede inyectar las clases por nombre desde el archivo config/services.yml
- También se pueden inyectar los servicios en el controlador

## Symfony Maker
- Crear un nuevo controlador: `$php bin/console make:controller BrandNewController`
- Crear un nuevo CRUD: `$php bin/console make:crud Product`

## Generate 404 pages
Se puede retornar el método createNotFoundException(string $mensaje); 
Es un atajo para la creación del objeto de tipo NotFoundHttpException
Ej:
`throw $this->createNotFoundException('The product does not exist');`

Es lo mismo que:
`throw new NotFoundHttpException('The product does not exist');`

Esto finalmente desencadena en la la respuesta HTTP 404 de Symfony
Si se lanza una exepción que extiende de `HttpException`, symfony usará el códgio de estado HTTP apropiado, de lo contrario siempre retornará HTTP 500

## Obtener los parametros $_GET
Se usa la clase Request, y se accede al atributo “query” y con el método ->get() de este se obtiene el parametro:
EJ: `$page = $request->query->get(string $parametro, mixed $default);``

## The response
- Se puede retornar una respuesta json usando: `return $this->json(array $response);`
- Se puede retornar un archivo usando: `return $this->file(string $pathToFile, ?string $nombreArchivo, ?int ResponseHeaderBag::DISPOSITION_INLINE);`

## The Request
- `$request->isXmlHttpRequest();` // Es una request Ajax?
- `$request->getPreferredLanguage(['en', 'fr']);` // Obtener el lenguaje preferido
- `$request->query->get('page');` // Obtener parametros de la consulta GET
- `$request->request->get('page');` // Obtener parametros de la consulta POST
- `$request->server->get('HTTP_HOST');` // Obtener las variables del servidor
- `$request->files->get('foo');` // Obtener los archivos de un parametro
- `$request->cookies->get('PHPSESSID');` // Obtener una cookie en especifico 
- `$request->headers->get('host');` // Obtener los headers (normalizados con lowercase)

## The cookies
- `$request->cookies->get('PHPSESSID');`

## The session
- El servicio que ofrece Symfony para tratar las sesiones es: `use Symfony\Component\HttpFoundation\Session\SessionInterface;`
- Para hacer uso de la session solo es necesario llamarla desde la acción `accion(SessionInterface $session)`
- Los métodos que existen para manejar las sesiones son:
- - `$session->set(string $sessionName, string $sessionValue)`
- - `$session->get(string $sessionName, ?string|array $default);`

## Headers
- Al Igual que la Request y Response, headers tiene una clase especifica para gestionar los header: `ResponseHeaderBag`
https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/HttpFoundation/ResponseHeaderBag.php
- En la respuesta: `$response->headers->set('Content-Type', 'text/css');`

## The flash messages
- Los mensajes flash están destinados a usarse exactamente una vez
- Para generar un mensaje flash use: `$this->addFlash(string $categoria, string $mensaje)`
- Para obtener un mensaje se usa `app.flashes(string $categoria)` en la vista

## File upload
https://symfony-com.translate.goog/doc/4.4/controller/upload_file.html
`$request->files->get('foo');`

# Routing
## Configuration (annotations)
- Annotations /* @Route()

Se pueden generar rutas en Symfony usando anotaciones usando la clase: Symfony\Component\Routing\Annotation\Route
- `/* {variables}`
- `/* {variablesUNICODE<\p{L}\d+>} utf8=true`
- `/* condition=" context.getMethod() in ['GET', 'HEAD'] and and request.headers.get('User-Agent') matches '/chrome/i' “`
- `/* requirements={"codigoEntero"="\d+"}`
- `/* methods={"HEAD", "GET"}`
- `/* name="route_name"`
- `/* paramConverter {entity_id}` https://symfony-com.translate.goog/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=wapp
- `/* {_locale} {_format}`

## Restrict URL parameters
Se usan las anotaciones: requirements
>`*   requirements={ `
>`*     "_locale": "en|fr|es", `
>`*     "_format": "html|xml|json", `
>`*     "variable"="\d+" `
>`*   } `
>`* )`

## Set default values to URL parameters
- Se puede asignar en comentarios o en la función.
`{slug<\C+>?defaultAnnotation}`

## Special internal routing attributes
`/ {_locale} {_format}`

## Domain name matching
condition="request.headers.get('User-Agent') matches '/chrome/i'" 

## Conditional request matching
Se puede usar en la condición los objetos context, request y ENV_VARS % % [OR AND]
condition="context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/chrome/i'" 

## HTTP methods matching
`/* condition="context.getMethod() in ['GET', 'HEAD']" `

# Console
## Built-in commands
- Para ejecutar un comando desde consola se debe usar el comando: php bin/console “comando”
- Para ver la lista de comandos se usa el comando: php bin/console list
- - Agregarndo --short al comando retornara la lista de comandos sin la descripción
- Para ver la ayuda correspondiente al comando se debe agreegar la opción  –help
- - `$ php bin/console assets:install --help`
- Los comandos se ejecutan por defecto en el entorno definido en el archivo .env en la opción variable APP_ENV. Pero se puede determinar el entorno al momento de ejecutar el comando:
- - `$ APP_ENV=prod php bin/console cache:clear`
- TIP (Symfony 6): Se puede agregar un autocompletar usando TAB agregando la la extensión para symfony en el sistema: `php bin/console completion bash | sudo tee /etc/bash_completion.d/console-events-terminate`

## Custom commands
Los comandos se definen en clases que amplian la clase Command

- Crear una clase que extienda Command
- - Con namespace App\Command;
- - Agregar un nombre al comando: `protected static $defaultName = 'app:create-user';`
- - Crear una función execute que retorna el ID de respuesta: `protected function execute(InputInterface $input, OutputInterface $output): int`
- - - `Command::SUCCESS;` // Si el comando se ejecuto sin problemas => 1
- - -  `Command::FAILURE;` // Si ocurrió un error => 1
- - - `Command::INVALID;` // Si el comando se ejecutó erroneamente => 2

- - Agregar una descripción al comando: `protected static $defaultDescription = 'Creates a new user.';`
- - - TIP: “Definir la `$defaultDescriptionpropiedad` estática en lugar de usar el `setDescription()` método permite obtener la descripción del comando sin instanciar su clase. Esto hace que el `php bin/console list` comando se ejecute mucho más rápido.”

- - Agregar la descripción de ayuda al comando `“ –help”`, en la función: `protected function configure(): void`
- - - `$this->setHelp('This command allows you to create a user...')`

- - A partir de PHP 8 se puede definir el comando haciendo uso de los comentarios
>`#[AsCommand(`
>`    name: 'app:create-user',`
>`    description: 'Creates a new user.',`
>`    hidden: false,`
>`    aliases: ['app:add-user']`
>`)]`

- - Si no se pueden usar los atributos de PHP se deberá registrar el servicio y etiquetarlo con console.command: `config/services.yaml`
>`services:`
>`    App\Twig\AppExtension:`
>`        tags: ['twig.extension']`

- - Salida de consola: con la variable  OutputInterface $output 
- - - Se puede imprimir mensajes con salto de linea: `$output->writeln('Whoa!')`
- - - Se pueden imprimir mensajes sin salto de linea: `$output->write('create a user.');`
- - - Se puede imprimir mensajes durante la ejecución del comando haciendo uso de `$output->section()`. Eso creará una nueva sección para cada mensaje con: `$section1->writeln('Hello');` Y permitira sobreescribirlas con `$section1->overwrite('Goodbye')` así se podrán mostrar mensajes de avance  sobre la ejecución. Finalmente se puede limpiar toda la sección con el método: `$section2->clear();`


- - Entrada de consola: 
- - - Para especificar los argumentos de entrada se deben usar el siguiente método en al función configure: `$this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')` O se puede especificar en los nested attributes (atributos anidados) si se usa PHP 8
- - - Para obtener las argumentos se usa `$input->getArgument('username')`

- - Se puede usar inyección de dependencias en el controlador como en cualquier servicio dado que los comandos se encuentran registrados como servicios. **NOTA: no olvidar llamar el cosntructor padre al final del controlador para obtener las variables establecidas: `parent::__construct();`**

- Ciclo de vida de los comandos:
- - `initialize()` OPCIONAL: Este método se ejecuta antes que interact()los execute()métodos y . Su objetivo principal es inicializar las variables utilizadas en el resto de los métodos de comando.
- - `interact()` OPCIONAL: Se ejecuta despues de `initialize()` y antes de `execute()`
- - - Su propósito es verificar si faltan algunas de las opciones/argumentos y preguntar de forma interactiva al usuario por esos valores. - - - Este es el último lugar donde puede solicitar opciones/argumentos faltantes. Después de este comando, las opciones/argumentos faltantes darán como resultado un error.
- - `execute()`
- - - Este metodo se encarga de ejecutar el comando en sí.

#### Estilos de comandos
`clase SymfonyStyle $io = new SymfonyStyle($input, $output);`
- - Declarar un titulo `$io->title('Lorem Ipsum Dolor Sit Amet');`
- - Declarar una sección: `$io->section('Adding a User');`

- - Métodos de contenido
- - - `$io->text(array|string $texto)`: mostrar cadenas de texto 
- - - `$io->listing(array $lista)`: Muestra una lissta en base a una matriz
- - - `$io->table(array $headerTable, array $table)`: Muestra una tabla
- - - `$io->horizontalTable(array $headerTable, array $table)`: Muestra una tabla horizontal
- - - `$io->definitionList(mixed $title, mexed $table)`: Muestra los key => valuepares dados como una lista compacta de elementos:
- - - `$io->newLine(?int $lineNumber);` crea una nueva linea

- - Métodos de amonestación
- - - `$io->note(string|array $messages)`: Muestra una advertencia
- - - `$io->caution(string|array $messages)`: Muestra un mensaje de error

- - Métodos de barra de progreso
- - - `$io->progressStart();` Muestra una barra de progreso
- - - `$io->progressStart(100);` Muestra una barra de progreso con 100 pasos 
- - - `$io->progressAdvance(?int = 1);` Hace avanzar la barra de progreso n pasos
- - - `$io->progressFinish();` Finaliza la barra de progreso
- - - `$io->progressIterate(array $iterable)` El helper progressIterable sirve para avanzar la barra de progreso en base a una variable iterable, en foreach SYMFONY 6.1
- - - `$io->createProgressBar();` Crea una instancia de ProgressBar de acuerdo a la guía de estilos de symfony

- - Métodos de entrada del usuario
- - - `$io->ask(string $pregunta, any $default, function $validator)` Preguntar por un valor
Si al validar el parametro no es correcto, ejectue un error con la clase: throw new \RuntimeException(
- - - `$io->askHidden(string $pregunta, any $default, function $validator)` preguntar por un valor sin mostrar el ingreso del usuario
- - - `$io->confirm(string $pregunta, mixed $default)` Preguntar para obtener una respuesta del usuario, el segundo campo que se pasa es el valor predeterminado
- - - `$io->choice(string $pregunta, array $opciones, mixed $respuestaDefault)` Hace una pregunta cuya respuesta está restringida a la lista dada de respuestas válidas

- - Métodos de resultados
- - - `$io->success(string|array $mensaje(s))` Muestra la cadena dada o la matriz de cadenas resaltada como un mensaje exitoso (con un fondo verde y la [OK]etiqueta)
- - - `$io->info(string|array $mensaje(s))` Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, sin mostrar el resultado como exitoso o fallido:
- - - `$io->warning(string|array $mensaje(s))` Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, pero puede usarlo repetidamente durante la ejecución del comando
- - - `$io->error(string|array $mensaje(s))` . Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, pero puede usarlo repetidamente durante la ejecución del comando
