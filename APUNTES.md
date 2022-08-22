# Apuntes Symfony 4

## GETTING STARTED

- [x] [Setup / Installation](#setup--installation)
- [x] [Creating Pages](#creando-paginas)
- [x] [Routing / Generating URLs](#routing)
- [x] [Controllers](#controllers)
- [x] [Templates / Twig](#templates--twig)
- [x] [Configuration / Env Vars](#configurando-symfony)

## ARCHITECTURE

- [ ] Requests / Responses
- [ ] Kernel
- [ ] Services / DI
- [ ] Events
- [ ] Contracts
- [ ] Bundles

## THE BASICS

- [ ] Databases / Doctrine
- [ ] Forms
- [ ] Tests
- [ ] Sessions
- [ ] Cache
- [ ] Logger
- [ ] Errors / Debugging

## ADVANCED TOPICS

- [ ] Console
- [ ] Mailer / Emails
- [ ] Validation
- [ ] Messaging / Queues
- [ ] Notifications
- [ ] Serialization
- [ ] Translation / i18n

## SECURITY

- [ ] Introduction
- [ ] Users
- [ ] Authentication / Firewalls
- [ ] Authorization / Voters
- [ ] Passwords
- [ ] CSRF
- [ ] LDAP

## FRONT-END

- [ ] Symfony UX / Stimulus
- [ ] Webpack Encore
- [ ] React.js
- [ ] Vue.js
- [ ] Bootstrap
- [ ] Web Assets
- [ ] WebLink

## UTILITIES

- [ ] HTTP Client
- [ ] Files / Filesystem
- [ ] Expression Language
- [ ] Locks
- [ ] Workflows
- [ ] Strings / Unicode
- [ ] UID / UUID
- [ ] YAML Parser

## PRODUCTION

- [ ] Deployment
- [ ] Performance
- [ ] HTTP Cache
- [ ] Cloud / Platform.sh

## Setup / Installation

### Symfony Flex

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

### License

La licencia de uso de symfony es de código libre, cualquier persona puede usar el software para reproducir, modificar o crear copias, mientras se encuentre agregada esta licencia.

### Components

#### Assets

<https://symfony.com/doc/4.4/components/asset.html>
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

<https://symfony.com/doc/4.4/testing.html>

Componente para pruebas en Symfony, implementa PHPUnit. Cada prueba es una clase que termina en “Test”, en la carpeta tests.

#### Fixturres

<https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html>

Componenete para crear datos de prueba para cargar la base de datos.

## Controllers

Suele ser un método dentro de una clase Controller

### Naming conventions

- `namespace App\Controller;`
- `class ControlladorController {}`

### The base Controller class

Symfony cuenta con una base controller opcional llamada AbstractController
<https://github.com/symfony/symfony/blob/4.4/src/Symfony/Bundle/FrameworkBundle/Controller/AbstractController.php>

### Internal redirects

Generar la URL de una ruta determinada
`$this->generateUrl(string $nameRoute, ?array $params)`

### HTTP redirects

- $this->redirectToRoute(string $nameRoute, ?array $params, int $responseCode)
- Es igual a: return new RedirectResponse($this->generateUrl('homepage'));
- Los códigos de respuesta están como constantes en la clase Response: Response::HTTP_MOVED_PERMANENTLY
- `$this->redirect(‘http://url.externa.com’)` Redirección externa

### Renderizado de plantillas

Para renderizar una plantilla se debe retornar el método:
`return $this->render(string $direccionPlantilla , array $params);`

### Autowiring de Servicios

- Para usar clases de servicios Symfony se pueden solicitar en cada una de las acciones del controlador, entonces symfony las pasará automáticamente.
- Para conocer la lista de servicios disponibles para autowiring, se puede usar el comando en consola: php bin/console debug:autowiring
- También se puede inyectar las clases por nombre desde el archivo config/services.yml
- También se pueden inyectar los servicios en el controlador

### Symfony Maker

- Crear un nuevo controlador: `$php bin/console make:controller BrandNewController`
- Crear un nuevo CRUD: `$php bin/console make:crud Product`

###  Generate 404 pages

Se puede retornar el método createNotFoundException(string $mensaje);
Es un atajo para la creación del objeto de tipo NotFoundHttpException
Ej:
`throw $this->createNotFoundException('The product does not exist');`

Es lo mismo que:
`throw new NotFoundHttpException('The product does not exist');`

Esto finalmente desencadena en la la respuesta HTTP 404 de Symfony
Si se lanza una exepción que extiende de `HttpException`, symfony usará el códgio de estado HTTP apropiado, de lo contrario siempre retornará HTTP 500

### Obtener los parametros $_GET

Se usa la clase Request, y se accede al atributo “query” y con el método ->get() de este se obtiene el parametro:
EJ: `$page = $request->query->get(string $parametro, mixed $default);``

### The response

- Se puede retornar una respuesta json usando: `return $this->json(array $response);`
- Se puede retornar un archivo usando: `return $this->file(string $pathToFile, ?string $nombreArchivo, ?int ResponseHeaderBag::DISPOSITION_INLINE);`

### The Request

- `$request->isXmlHttpRequest();` // Es una request Ajax?
- `$request->getPreferredLanguage(['en', 'fr']);` // Obtener el lenguaje preferido
- `$request->query->get('page');` // Obtener parametros de la consulta GET
- `$request->request->get('page');` // Obtener parametros de la consulta POST
- `$request->server->get('HTTP_HOST');` // Obtener las variables del servidor
- `$request->files->get('foo');` // Obtener los archivos de un parametro
- `$request->cookies->get('PHPSESSID');` // Obtener una cookie en especifico
- `$request->headers->get('host');` // Obtener los headers (normalizados con lowercase)

### The cookies

- `$request->cookies->get('PHPSESSID');`

### The session

- El servicio que ofrece Symfony para tratar las sesiones es: `use Symfony\Component\HttpFoundation\Session\SessionInterface;`
- Para hacer uso de la session solo es necesario llamarla desde la acción `accion(SessionInterface $session)`
- Los métodos que existen para manejar las sesiones son:
  - `$session->set(string $sessionName, string $sessionValue)`
  - `$session->get(string $sessionName, ?string|array $default);`

### Headers

- Al Igual que la Request y Response, headers tiene una clase especifica para gestionar los header: `ResponseHeaderBag`
<https://github.com/symfony/symfony/blob/4.4/src/Symfony/Component/HttpFoundation/ResponseHeaderBag.php>
- En la respuesta: `$response->headers->set('Content-Type', 'text/css');`

### The flash messages

- Los mensajes flash están destinados a usarse exactamente una vez
- Para generar un mensaje flash use: `$this->addFlash(string $categoria, string $mensaje)`
- Para obtener un mensaje se usa `app.flashes(string $categoria)` en la vista

### File upload

<https://symfony-com.translate.goog/doc/4.4/controller/upload_file.html>
`$request->files->get('foo');`

## Creando Paginas

Crear una nueva pagina - si es una pagina HTML o un JSON endpoint - es un proceso de dos pasos:

1. **Crear una ruta:** Una ruta es la URL (E.J `/about`) para tus paginas y puntos a un controlador;
2. **Crear un controlador:** Un controlador es la función de PHP que se escribe para crear la pagina. Puedes tomar la información de la consulta entrante y usarla para crear un objeto `Response` de Symfony, con el que puedes crear contenido HTML, un string JSON o incluso un binario como una imagen o PDF.

**También puedes ver: Symfony posee un ciclo de vida para las HTTP Peticiones-Respuestas. Para encontrar más, mira [Symfony y Fundamentos de HTTP](https://symfony.com/doc/4.4/introduction/http_fundamentals.html)**

## Creando una Pagina: Ruta y Controlador

**Tip: Antes de continuar, asegurate de leer el articulo de [instalación](#setup--installation) y que puedas acceder a Symfony desde el explorador**

Supón que desear crear una pagina - `/lucky/number` - que genera un código de la suerte (random) y lo imprime. Para hacer esto, crea una clase `Controller` y un método "controlador" dentro de el:

      <?php
      // src/Controller/LuckyController.php
      namespace App\Controller;

      use Symfony\Component\HttpFoundation\Response;

      class LuckyController
      {
          public function number()
          {
              $number = random_int(0, 100);

              return new Response(
                  '<html><body>Lucky number: '.$number.'</body></html>'
              );
          }
      }

Ahora necesitas asociar esta función del controlador con una url publica (E.J `/lucky/number`) así el método `number()` sera llamado cuando el usuario busque esa url. Esta asociación es definida creando una **route** en el archivo `config/routes.yaml`:

      # config/routes.yaml

      # the "app_lucky_number" route name is not important yet
      app_lucky_number:
          path: /lucky/number
          controller: App\Controller\LuckyController::number

Eso es todo! Si estás usando el servidor web de Symfony, intenta acceder a el:
[http://localhost:8000/lucky/number](http://localhost:8000/lucky/number)

Si ves el número de la suerte impreso, felicitaciones! Pero antes de que corras a jugar la loteria, verifica cómo funciona. Recuerdas los dos pasos para crear la pagina?

1. *Crear un controlador y un método*: Esta es una función donde creas la pagina y al final retornas un objeto `Response`. Puedes aprender más acerca de los [controladores](#controllers) en su sección respectiva, incluso como retornar respuestas de tipo JSON;
2. *Crear una ruta*: En `config/routes.yaml`, la ruta define la URL de tu pagina (`path`) y que  `controller` llamar. Puedes aprender más acerca del [ruteo](#routing) en su propia sección.

### Rutas con Anotaciones

En lugar de definir tu ruta en YAML, Symfony además te permite usar *annotation* routes. Para hacer esto instala el paquete `annotation`:

      $ composer require annotations

Ahora puedes agregar directamente tu ruta en el controlador:

      // src/Controller/LuckyController.php

        // ...
      + use Symfony\Component\Routing\Annotation\Route;

        class LuckyController
        {
      +     /**
      +      * @Route("/lucky/number")
      +      */
            public function number()
            {
                // this looks exactly the same
            }
        }

Eso es todo! La pagina [http://localhost:8000/lucky/number](http://localhost:8000/lucky/number) funcionara exactamente igual que la anterior. Las anotaciones son la forma recomendada para configurar rutas.

## Auto instalar recetas con Symfony Flex

Quizá no lo has notado, pero cuando corres `composer require annotations` dos especiales cosas suceden, ambas gracias al poderoso plugin de Composer llamado [Flex](https://symfony.com/doc/4.4/setup.html#symfony-flex).

Primero, `annotations` no es el real nombre del paquete: es un alias (EJ: un atajo) que flex resuelve de `sensio/framework-extra-bundle`.

Segundo, despues de que el paquete ha sido descargado, Flex corrre la *receta* que es una lista de instrucciones que le dicen a Symfony como integrar un paquete externo. [Las recetas de Flex](https://flex.symfony.com/) existen para muchos paquetes y tienen muchas habilidades, como agregar archivos de configuración, crear directorios, editar el archivo `.gitignore` y agregar nueva configuración al archivo `.env`. Flex automatiza la instalación de paquetes, así puedes regresar a codificar.

### El Comando bin/console

Tu proyecto tiene una poderosa herramienta de depuración: el comando `bin/console`. Intenta correrlo:

      $ php bin/console

Puedes ver la lista de comando que pueden darte información de depuración, ayudarte a generar código, generar migraciones de bases de datos y mucho más. Cuanto más instales paquetes, más comandos veras.

Para obtener la lista completa de rutas en tu sistema, usa el comando `debug:router`:

      $ php bin/console debug:router

Podrás ver la ruta `app_lucky_number` en la lista.

Aprenderás más comandos a medida que continues!

### Renderizando un Template

Si estar retornando un HTML desde tu controlador probablemente quieras renderizar una plantilla. Afortunadamente Symfony viene con [Twig](#templates--twig): un lenguaje que es mínimo, poderoso y en realidad bastante divertido.

Instala el paquete de twig con:

      $ composer require twig

Asegurate que `LuckyController` extienda de la clase base `AbstraactController`:

        // src/Controller/LuckyController.php

          // ...
        + use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

        - class LuckyController
        + class LuckyController extends AbstractController
          {
              // ...
          }

Ahora, usa el método `render()` para renderizar una plantilla. Pasa la variable `number` y podrás usarla en twig:

      // src/Controller/LuckyController.php
      namespace App\Controller;

      use Symfony\Component\HttpFoundation\Response;
      // ...

      class LuckyController extends AbstractController
      {
          /**
          * @Route("/lucky/number")
          */
          public function number(): Response
          {
              $number = random_int(0, 100);

              return $this->render('lucky/number.html.twig', [
                  'number' => $number,
              ]);
          }
      }

Los archivos de plantillas se encuentran en el directorio `templates/`, el cual fue creado automáticamente cuando instalaste Twig. Crea un nuevo directorio `templates/lucky` con un nuevo archivo `number.html.twig` dentro.

      {# templates/lucky/number.html.twig #}
      <h1>Your lucky number is {{ number }}</h1>



## Routing

### Configuration (annotations)

- Annotations /* @Route()

Se pueden generar rutas en Symfony usando anotaciones usando la clase: Symfony\Component\Routing\Annotation\Route

- `/* {variables}`
- `/* {variablesUNICODE<\p{L}\d+>} utf8=true`
- `/* condition=" context.getMethod() in ['GET', 'HEAD'] and and request.headers.get('User-Agent') matches '/chrome/i' “`
- `/* requirements={"codigoEntero"="\d+"}`
- `/* methods={"HEAD", "GET"}`
- `/* name="route_name"`
- `/* paramConverter {entity_id}` <https://symfony-com.translate.goog/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=wapp>
- `/* {_locale} {_format}`

### Restrict URL parameters

Se usan las anotaciones: requirements
>`*   requirements={`
>`*     "_locale": "en|fr|es",`
>`*     "_format": "html|xml|json",`
>`*     "variable"="\d+"`
>`*   }`
>`* )`

### Set default values to URL parameters

- Se puede asignar en comentarios o en la función.
`{slug<\C+>?defaultAnnotation}`

### Special internal routing attributes

`/ {_locale} {_format}`

### Domain name matching

condition="request.headers.get('User-Agent') matches '/chrome/i'"

### Conditional request matching

Se puede usar en la condición los objetos context, request y ENV_VARS % % [OR AND]
condition="context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/chrome/i'"

### HTTP methods matching

`/* condition="context.getMethod() in ['GET', 'HEAD']"`

## Console

### Built-in commands

- Para ejecutar un comando desde consola se debe usar el comando: php bin/console “comando”
- Para ver la lista de comandos se usa el comando: php bin/console list
  - Agregarndo --short al comando retornara la lista de comandos sin la descripción
- Para ver la ayuda correspondiente al comando se debe agreegar la opción  –help
  - `$ php bin/console assets:install --help`
- Los comandos se ejecutan por defecto en el entorno definido en el archivo .env en la opción variable APP_ENV. Pero se puede determinar el entorno al momento de ejecutar el comando:
  - `$ APP_ENV=prod php bin/console cache:clear`
- TIP (Symfony 6): Se puede agregar un autocompletar usando TAB agregando la la extensión para symfony en el sistema: `php bin/console completion bash | sudo tee /etc/bash_completion.d/console-events-terminate`

### Custom commands

Los comandos se definen en clases que amplian la clase Command

- Crear una clase que extienda Command
  - Con namespace App\Command;
  - Agregar un nombre al comando: `protected static $defaultName = 'app:create-user';`
  - Crear una función execute que retorna el ID de respuesta: `protected function execute(InputInterface $input, OutputInterface $output): int`
    - `Command::SUCCESS;` // Si el comando se ejecuto sin problemas => 1
    - `Command::FAILURE;` // Si ocurrió un error => 1
    - `Command::INVALID;` // Si el comando se ejecutó erroneamente => 2

  - Agregar una descripción al comando: `protected static $defaultDescription = 'Creates a new user.';`
    - TIP: “Definir la `$defaultDescriptionpropiedad` estática en lugar de usar el `setDescription()` método permite obtener la descripción del comando sin instanciar su clase. Esto hace que el `php bin/console list` comando se ejecute mucho más rápido.”

  - Agregar la descripción de ayuda al comando `“ –help”`, en la función: `protected function configure(): void`
    - `$this->setHelp('This command allows you to create a user...')`

  - A partir de PHP 8 se puede definir el comando haciendo uso de los comentarios

>`#[AsCommand(`
>`name: 'app:create-user',`
>`description: 'Creates a new user.',`
>`hidden: false,`
>`aliases: ['app:add-user']`
>`)]`

- Si no se pueden usar los atributos de PHP se deberá registrar el servicio y etiquetarlo con console.command: `config/services.yaml`

>`services:`
>`App\Twig\AppExtension:`
>`tags: ['twig.extension']`

- Salida de consola: con la variable  OutputInterface $output
  - Se puede imprimir mensajes con salto de linea: `$output->writeln('Whoa!')`
  - Se pueden imprimir mensajes sin salto de linea: `$output->write('create a user.');`
  - Se puede imprimir mensajes durante la ejecución del comando haciendo uso de `$output->section()`. Eso creará una nueva sección para cada mensaje con: `$section1->writeln('Hello');` Y permitira sobreescribirlas con `$section1->overwrite('Goodbye')` así se podrán mostrar mensajes de avance  sobre la ejecución. Finalmente se puede limpiar toda la sección con el método: `$section2->clear();`

- Entrada de consola:
  - Para especificar los argumentos de entrada se deben usar el siguiente método en al función configure: `$this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')` O se puede especificar en los nested attributes (atributos anidados) si se usa PHP 8
  - Para obtener las argumentos se usa `$input->getArgument('username')`

- Se puede usar inyección de dependencias en el controlador como en cualquier servicio dado que los comandos se encuentran registrados como servicios. **NOTA: no olvidar llamar el cosntructor padre al final del controlador para obtener las variables establecidas: `parent::__construct();`**

- Ciclo de vida de los comandos:
  - `initialize()` OPCIONAL: Este método se ejecuta antes que interact()los execute()métodos y . Su objetivo principal es inicializar las variables utilizadas en el resto de los métodos de comando.
  - `interact()` OPCIONAL: Se ejecuta despues de `initialize()` y antes de `execute()`
    - Su propósito es verificar si faltan algunas de las opciones/argumentos y preguntar de forma interactiva al usuario por esos valores.     - Este es el último lugar donde puede solicitar opciones/argumentos faltantes. Después de este comando, las opciones/argumentos faltantes darán como resultado un error.
  - `execute()`
    - Este metodo se encarga de ejecutar el comando en sí.

#### Estilos de comandos

`clase SymfonyStyle $io = new SymfonyStyle($input, $output);`

- Declarar un titulo `$io->title('Lorem Ipsum Dolor Sit Amet');`
- Declarar una sección: `$io->section('Adding a User');`

- Métodos de contenido
  - `$io->text(array|string $texto)`: mostrar cadenas de texto
  - `$io->listing(array $lista)`: Muestra una lissta en base a una matriz
  - `$io->table(array $headerTable, array $table)`: Muestra una tabla
  - `$io->horizontalTable(array $headerTable, array $table)`: Muestra una tabla horizontal
  - `$io->definitionList(mixed $title, mexed $table)`: Muestra los key => valuepares dados como una lista compacta de elementos:
  - `$io->newLine(?int $lineNumber);` crea una nueva linea

- Métodos de amonestación
  - `$io->note(string|array $messages)`: Muestra una advertencia
  - `$io->caution(string|array $messages)`: Muestra un mensaje de error

- Métodos de barra de progreso
  - `$io->progressStart();` Muestra una barra de progreso
  - `$io->progressStart(100);` Muestra una barra de progreso con 100 pasos
  - `$io->progressAdvance(?int = 1);` Hace avanzar la barra de progreso n pasos
  - `$io->progressFinish();` Finaliza la barra de progreso
  - `$io->progressIterate(array $iterable)` El helper progressIterable sirve para avanzar la barra de progreso en base a una variable iterable, en foreach SYMFONY 6.1
  - `$io->createProgressBar();` Crea una instancia de ProgressBar de acuerdo a la guía de estilos de symfony

- Métodos de entrada del usuario
  - `$io->ask(string $pregunta, any $default, function $validator)` Preguntar por un valor
Si al validar el parametro no es correcto, ejectue un error con la clase: throw new \RuntimeException(
  - `$io->askHidden(string $pregunta, any $default, function $validator)` preguntar por un valor sin mostrar el ingreso del usuario
  - `$io->confirm(string $pregunta, mixed $default)` Preguntar para obtener una respuesta del usuario, el segundo campo que se pasa es el valor predeterminado
  - `$io->choice(string $pregunta, array $opciones, mixed $respuestaDefault)` Hace una pregunta cuya respuesta está restringida a la lista dada de respuestas válidas

- Métodos de resultados
  - `$io->success(string|array $mensaje(s))` Muestra la cadena dada o la matriz de cadenas resaltada como un mensaje exitoso (con un fondo verde y la [OK]etiqueta)
  - `$io->info(string|array $mensaje(s))` Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, sin mostrar el resultado como exitoso o fallido:
  - `$io->warning(string|array $mensaje(s))` Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, pero puede usarlo repetidamente durante la ejecución del comando
  - `$io->error(string|array $mensaje(s))` . Está destinado a usarse una vez para mostrar el resultado final de ejecutar el comando dado, pero puede usarlo repetidamente durante la ejecución del comando

## Templates / Twig

Es un motor de plantillas flexible, rápido y seguro

### Lenguaje de plantillas Twig

La  sintaxis de Twig se basa en tres construcciones:

- `{{ .. }}` Utilizado para mostrar el contenido de una variable o el resultado de evaluar una expresión
- `{% ... %}` Utilizado para ejecutar alguna lógica, como un condicional o bluccle
- `{# ... #}` Utilizado para agregar comentarios a la plantilla ( estos comentarios no se incluten en la página representada)

Twig prporciona algo de lógica en sus plantillas, ej: filtros `{{ titulo|upper }}` convertir la variable titulo en mayúscula. Además cienta con: etiqueta, filtro, funciones, funciones definidas por symfony y se puede crear filtrosy funciones propios.

- En el entoro `prod`: Twig es rápido  porque las plantillas se compilan en PHP y se almacenan en caché automáticamente
- En el entorno `dev`:  Las plantillas se vuelven a compilar automáticamente cuando se modifican

#### Para ver la configuración de twig

<https://symfony.com/doc/4.4/reference/configuration/twig.html>

### Creación de plantillas

#### Denominación de plantillas

- Utilizar snake_case para los nombres de archivos y directorios. Ej: `admin/default_theme/blog/blog_post.html.twig`
- Definir dos extensiones para los archivos, siendo la primer extensión, la extensión de la plantilla (`html`, `xml`, etc...) y `twig` para el final

Las plantillas pueden generar cualquier formato basado en textos

#### Ubicación de la plantilla

Las plantillas se almacenan de forma predeterminada en el directorio `templates/`. Cuando se representa la plantilla `product/index.html.twig` en realidad se está refiriendo al archivo `<projecto>/templates/product/index.html.twig`.

El directorio predeterminado de las plantillas se puede cambiar en `twig.default_path`.

#### Variables de plantilla

Ejemplo del orden en que Twig busca el atributo d eun objeto:

1. $foo['bar'](matriz y elemento);
2. $foo->bar(objeto y propiedad pública);
3. $foo->bar()(objeto y método público);
4. $foo->getBar()(objeto y método getter );
5. $foo->isBar()(método objeto y emisor );
6. $foo->hasBar()(objeto y método hasser );
7. Si no existe ninguno de los anteriores, use null(o lance una Twig\Error\RuntimeErrorexcepción si la opción strict_variables está habilitada).

#### Links a páginas

- Para generar una dirección URL relativa a una acción determinada se debe usar `path('nombre_accion')`

  - Ejemplo: `<a href="{{ path('blog_index') }}">Homepage</a>`

- Para generar una dirección URL absoluta se debe usar `url('nombre_accion')`

  - Ejemplo: `<a href="{{ url('blog_index') }}">Homepage</a>`

### Vincular a CSS, JavaScript y activos de imagen

Si una plantilla necesita vincularse a un activo estatico, por ejemplo una imagen, css o javascript. Symfony proporciona la función 'asset()'. Instalando el paquete `composer require symfony/asset`

Ejemplo:
`<link href="{{ asset('css/blog.css') }}" rel="stylesheet"/>`

- Para rutas absulutas de assets usar `absolute_asset('pag/ass.ext')`

### La variable global de la aplicación

> Symfony crea un objeto de contexto que se inyecta en cada plantilla de Twig automáticamente como una variable llamada `app`. Proporciona acceso a cierta información de la aplicación

- `app.user` El objetio del usuario actual o null si no está autenticado
- `app.request` El objeto Requet
- `app.session` El objeto Session
- `app.flashes` Una matriz con los mensajes flash
- `app.enviroment` El nombre del entorno actual (`dev`, `prod`, etc)
- `app.debug` True si está en modo depuración
- `app.token` Un objeto TokenInterface que representa el token de seguridad.

- También se pueden inyectar variables en todas las plantillas, ver:
<https://symfony.com/doc/4.4/templating/global_variables.html>

### Componentes Twig

Los componentes Twig son una forma alternativa de representar plantillas, donde cada plantilla está vinculada a una "clase de componente". Esto hace que sea más fácil representar y reutilizar pequeñas "unidades" de plantilla, como una alerta, marcado para un modal o una barra lateral de categoría.
<https://symfony.com/bundles/ux-twig-component/current/index.html>

Los componentes de Twig también tienen otro superpoder: pueden volverse "en vivo", donde se actualizan automáticamente (a través de Ajax) a medida que el usuario interactúa con ellos. Por ejemplo, cuando su usuario escribe en un cuadro, su componente Twig se volverá a procesar a través de Ajax para mostrar una lista de resultados.
<https://symfony.com/bundles/ux-live-component/current/index.html>

Para renderizar un componente de plantilla Twig, en el controlador que extiende de `AbstractController` se debe usar `$this->renderView`. Ej:

> `$contents = $this->renderView('product/index.html.twig', [`
> `'category' => '...',`
> `'promotions' => ['...', '...'],`
> `]);`
>
> `return new Response($contents);`

Esto renderizará únicamente la porción correspondiente al componente.

### Representación de una plantilla en servicios

Inyectando la clas `use Twig\Environment` se puede hacer uso de twig en un Servicio.

### Representación de una plantilla en correo electronicos

<https://symfony.com/doc/4.4/mailer.html#mailer-twig>

### Comprobar si existe una plantilla

Para comprobar si existe una plantilla Twig debemos usar un Loader de plantillas, este se puede obtener obtener inyectando la clas "Twig\Enviroment" y  llamando al método `->getLoader()`. Luego con el loader usar el método `->exists('theme/plantilla.html.twig')``

### Depuración de Plantillas

Symfony proporciona varias utilidades para ayudarte a depurar problemas en las plantillas.

El comando `lint:twig` verifica que las platillas de Twig no tengan errores de sintaxis. Es útil implementarlo en servidores de integración continua.

- Revisar todos los templates de la aplicación

> $ php bin/console lint:twig

- Revisar templates individuales

> $ php bin/console lint:twig templates/email/
> $ php bin/console lint:twig templates/article/recent_list.html.twig

- Ver las caracteristicas deprecadas en los templates

> $ php bin/console lint:twig --show-deprecations templates/email/

El comando `debug:twig`enumera toda la información disponible sobre Twig(funciones, filtros, variables globales, etc.). Verifica las funciones personailizadas y nuevas de Twig al agregar paquetes:

- Información general

> $ php bin/console debug:twig

- Filtrar alguna palabra clave
php bin/console debug:twig --filter=date

- Pasar el path del archivo a debugear
php bin/console debug:twig @Twig/Exception/error.html.twig

### Las utiidades de Dump Twig

Symfony proporciona una función dump(), pero es necesario primero instalar el paquete: `composer require symfony/var-dumper`

Luego se puede usar `{% dump %} o {{ dump() }} según el requemrimiento

Por razones de seguridad dump solo funciona en entornos de desarrollo, en `prod` o `test` se verá un error.

### Incluir plantillas

Se pueden incluir plantillas dentro de otras plantillas haciendo uso de `include()`. Ej:

- `{{ include('blog/_user_profile.html.twig') }}`
- `{{ include('blog/_user_profile.html.twig', {user: blog_post.author}) }`

Una mejor alternativa es incrustar el resultado de ejecutar algún controlador con las funciones `render()` y `controller()` Twig.

EJ:

- `{{ render(url('latest_articles', {max: 3})) }}`
- `render(controller( 'App\\Controller\\BlogController::recentArticles', {max: 3} ))`

**La incrustación de controladores requiere realizar solicitudes a esos controladores y generar algunas plantillas como resultado.**

Las plantillas también pueden incrustar contenido de forma asincronica con la libreria hinclude.js, ver:
<https://symfony.com/doc/4.4/templating/hinclude.html>

### Herencia de plantillas y diseños

> El concepto de herencia de plantillas Twig es similar a la herencia de clases de PHP. Usted define una plantilla principal a partir de la cual pueden extenderse otras plantillas y las plantillas secundarias pueden anular partes de la plantilla principal.

Symfony recomienda la siguiente herencia de plantillas de tres niveles para aplicaciones medianas y complejas:

1. `templates/base.html.twig`, define los elementos comunes de todas las plantillas de aplicación, como `<head>`, `<header>`, `<footer>`, etc.
2. `templates/layout.html.twig`, se extiende desde `base.html.twig` y define la estructura de contenido utilizada en todas o la mayoría de las páginas, como un contenido de dos columnas + diseño de barra lateral. Algunas secciones de la aplicación pueden definir sus propios diseños (p. ej `templates/blog/layout.html.twig`);
3. `templates/*.html.twig`, las páginas de la aplicación que se extienden desde la `layout.html.twig` plantilla principal o cualquier otro diseño de sección

Ejemplo:

- *templates/base.html.twig*
  - `<html><body>{% block content %}{% endblock %}  </body> </html>`

- *templates/blog/layout.html.twig*
  - `{% extends 'base.html.twig' %} {% block content %} <h1>Blog</h1> {% block page_contents %}{% endblock %} {% endblock %}`

- *templates/blog/index.html.twig*
- `{% extends 'blog/layout.html.twig' %} {% block title %}Blog Index{% endblock %} {% block page_contents %} {% for article in articles %} <h2>{{ article.title }}</h2> <p>{{ article.body }}</p> {% endfor %} {% endblock %}`

La etiqueta `{% block %}` determina un espacio de bloque en la plantilla.

- ***Cuando se usa extends, una plantilla secundaria tiene prohibido definir partes de la plantilla fuera de un bloque. El siguiente código arroja un SyntaxError***

### Escape de salida

Para mostrar una variable sin pasar por los filtros de seguridad de XSS de Twig, use el filtro `raw`. Ej: {{ product.title|raw }}

### Espacios de nombre en plantillas

Para configurar espacios de nombre para plantillas almacenadas en directorios distintos a `templates/`. Se debe configurar `paths` en `config/packages/twig.yaml`

`# config/packages/twig.yaml`

`twig:`

`# ...`

`paths:`

`'email/default/templates': 'email'`

`'backend/templates': 'admin'`

Despues se pueden renderizar de esta forma: `@email/layout.html.twigy` `@admin/layout.html.twig`

### Paquete de plantillas

Si instala `paquetes/bundles` en su aplicación, pueden incluir sus propias plantillas Twig (en el `Resources/views/directorio` de cada paquete). Para evitar jugar con tus propias plantillas, Symfony agrega plantillas de paquetes en un espacio de nombres automático creado después del nombre del paquete.

Por ejemplo, las plantillas de un paquete llamado AcmeFooBundleestán disponibles en el espacio de AcmeFoonombres. Si este paquete incluye la plantilla `<your-project>/vendor/acmefoo-bundle/Resources/views/user/profile.html.twig`, puede referirse a ella como `@AcmeFoo/user/profile.html.twig`

También se pueden sobre escribir plantillas de otos paquetes:
<https://symfony.com/doc/4.4/bundles/override.html>

## Configurando Symfony

Las aplicciones de symfony se encuentran configuradas con los archivos guaardados en el directorio `config/` el cual tiene la siguiente estructura:

your_proyect/
- config/
  - packages/
  - bundles.php
  - routes.yaml
  - services.yaml

El archivo `routes.yaml` define la configuración de rutas; el archivo `services.yaml` configura los servicios del contenedor de servicios (service container); el archivo `bundles.php` habilita o deshabilita paquetes en la aplicación.

El directorio `config/packages/` guarda la configuración de cada paquete instalado en a aplicación. Los paquetes llamados `bundles` agregar caracteristicas listas para usar en el proyecto.

Cuando se usa `Symfony Flex` que está activado por default en las aplicaciones de Symfony, los paquetes editan el archivo `bundles.php` y crear nuevos archivos en `config/packages`automaticamente durante su instalación.

**Para conocer más sobre las configuraciones disponibles se puede usar el siguiente comando `config:dump-reference`**

### Formatos de configuración

A diferencia de otros frameworks, Symfony no impoe un formato de configuración especifico. Symfony permite elegir entre YAML, XML y PHP y toda la documentación de symfony cuenta con ejemplos en los tres formatos.

Practicamente no existe diferencia entre los formatos. De hecho symfony transforma y crea un cache de cada uno en formato PHP despues corre la aplicación, así que no hay diferencia de performance entre los diferentes formators.

YAML es usado por defecto cuando se instalan los paquetes porque es conciso y de facil lectura. Estas son las ventajas y desventajas entre cada formato:

- **YAML:** Simple, limpio y de facil lectura, pero no todos los IDEs soportan la validación y autocompletado
- **XML:** La mayoria de IDEs soportan el autocompletado y la validación, además es procesado nativamente por PHP, pero algunas configuraciones deben se muy detalladas.
- **YAML:** Muy poderoso y permite que se creen dinamicamente las configuraciones, pero el resultado de la configuración es menos legible que los otros formatos.

### Importing Configuration Files

Symfony carga archivos de configuración usando el componente `Config` el cual provee caracteristica avanzada como importaar otros archivos de configuración, incluso si usan diferente formato:

    # config/services.yaml:
  
    imports:
    - { resource: 'legacy_config.php' }

    # glob expressions are also supported to load multiple files
    - { resource: '/etc/myapp/*.yaml' }

    # ignore_errors: not_found silently discards errors if the loaded file doesn't exist
    - { resource: 'my_config_file.xml', ignore_errors: not_found }
    # ignore_errors: true silently discards all errors (including invalid code and not found)
    - { resource: 'my_other_config_file.xml', ignore_errors: true }

### Paramtros de configuración

En ocasiones los mismos valores de configuración son usados en varios archivos de configuración. En lugar de repetirlos, se pueden definir como parametros, es como usar valores de configuración reutilizables. Por convención los para metros están definidos debajo de la llave `parameters`en el archivo `config/services.yaml`

    # config/services.yaml
    parameters:
        # the parameter name is an arbitrary string (the 'app.' prefix is recommended
        # to better differentiate your parameters from Symfony parameters).
        app.admin_email: 'something@example.com'

        # boolean parameters
        app.enable_v2_protocol: true

        # array/collection parameters
        app.supported_locales: ['en', 'es', 'fr']

        # binary content parameters (encode the contents with base64_encode())
        app.some_parameter: !!binary VGhpcyBpcyBhIEJlbGwgY2hhciAH

        # PHP constants as parameter values
        app.some_constant: !php/const GLOBAL_CONSTANT
        app.another_constant: !php/const App\Entity\BlogPost::MAX_ITEMS

***Precaución: cuanto se usa la configuración XML, el valor dentro del tag `<parameter>` no se le borraran los espacios en blanco.***

Una vez definido, se puede hacer referencia al valor del parametro desde cualquier archivo de configuración usando la sintaxis: envolviendo el parametro entre dos `%` (ej: `app.admin_email`)

    # config/packages/some_package.yaml
    some_package:
        # any string surrounded by two % is replaced by that parameter value
        email_address: '%app.admin_email%'

***Nota: si algún parameotro incluye el caracter `%`, será necesario escaparlo agregando otro `%` por lo tanto Symfony no lo considerara como una referencia al parametro.***

    # config/services.yaml
    parameters:
        # Parsed as 'https://symfony.com/?foo=%s&amp;bar=%d'
        url_pattern: 'https://symfony.com/?foo=%%s&amp;bar=%%d'

***Nota: Debido a la forma en que se resuelven los parametros, no se pueden usar para realizar importaciones dinamicamente. Eso significa que alg como lo siguiente no funciona:***

    # config/services.yaml
    imports:
        - { resource: '%kernel.project_dir%/somefile.yaml' }

Los parametros en Symfony son muy comunes. Algunos paquetes definen sus propios parametros. (Ej: cuando se instala el paquete de traducción, un nuevo parametro `locale`es agregado al archivo `config/services.yaml`).

### Entornos de Configuración

Tienes sólo una aplicación, pero sin embargo necesitas en ocasiones que se comporte distinto en diferentes momentos:

- Mientras desarrolla, necesitas realizar un log de todo y mostrar buenas herramientas de depuración.
- Despues de desplegar la aplicación en producción necesitas la misma aplicación optimizada para la velocidad y solo registrar los errores.

Los archivos guardados en `config/packages/` son usados por Symfony para configurar los servicios de la aplicación. En otras palabras, es posible cambiar el comportamiento de la aplicación cambiando los archivos de coniguración cargados. Esa es la idea de los entornos de configuración de Symfony.

Una aplicación tipica de Symfony inicia con tres entornos: `dev` (para el desarrollo local), `prod` (para los servidores de producción) y `test`(para los test automaticos). Cuando corres la aplicación, Symfony carga los archivos de configuración en este orden (el ultimo archivo puede sobre escribir los valores asignados en el anterior):

1. `config/packages/*yaml` (y los archivos `*.xml` y `*.php` también)
2. `config/packages/<enviroment-name>/*.yaml` (y los archivos `*.xml` y `*.php` también)
3. `config/services.yaml`  (y los archivos `services.xml` y `services.php` también)
4. `config/services_<enviroment-name>.yaml` (y los archivos `services_<enviroment-name>.xml` y `services_<enviroment-name>.php` también)

Toma el paquete `framework`, instalado por defecto, como ejemplo:

- Primero, `config/packages/framework.yaml` está cargado en todos los etornos y se configura con algunas opciones
- En el entorno `prod`, no hay nada extra asignado y no existe el archivo `config/packages/prod/framework.yaml`
- En el entorno `dev`, no hay nada extra asignado y no existe el archivo `config/packages/prod/framework.yaml`
- En el entorno `test` el archivo `config/packages/test/framework.yaml` está cargado y sobre escribe algunas configuraciones previas del archivo `config/packages/framework.yaml`

En realidad, cada entorno se diferencia solo algo de los otros. Esto significa que todos los entornos comparten una gran base de configuración, que se encuentra en los archivo del directorio `config/packages/` directamente.

### Seleccionando el Entorno Activo

Las aplicaciones de Symfony vienen con un archivo llamado `.env` ubicado en el directorio raiz del proyecto. Este archivo es usado para definir el valor del entorno.

Abre el archivo `.env` (o mejor, el archivo `.env.local` si haz creado uno) y edita el valor de la variable `APP_ENV` para cambiar el entorno, por ejemplo correr la aplicación en producción:

      # .env (or .env.local)
      APP_ENV=prod

Este valor es usado tanto para la web como para la consola de comandos. De todas formas puedes sobre escribir este en la consola de comando anteponiendo `APP_ENV`.

      APP_ENV=prod php bin/console command_name

### Creando un nuevo entorno

Los tres entornos proporcionados por Symfony son suficientes para la mayoría de proyectos, pero también puedes definir tus propios entornos. Por ejemplo, así es como puedes definir un entorno de `staging` cuando el cliente quiere probar la aplicación antes del entorno de producción.

1. Crea un directorio de configuración con el mismo nombre del entorno (en este caso `config/packages/staging/`);
2. Agrega la configuración que necesitas en `config/packages/staging/` para definir los comportamientos del nuevo entorno. Symfony cargará primero los archivos `config/packages/*.yaml`, por lo tanto solo necesitas definir las diferencias de estos archivos.
3. Selecciona en entorno `staging` usando la variable env `APP_ENV` tal como fue explicado anteiormente.

**Tip: es comun que para entornos similares se use la misma configuración, así que puedes usar links simbolicos entre los directorios `config/packages/<environment-name>/` para reusar la misma configuración**

En lugar de crear nuevos entornos, puedes usar variables de entorno como se explica en la siguiente sección. De esta forma podras usar la misma aplicación y entorno (ej: `prod`), pero cambiando su conmportamiento gracias a la configuracion de las variables de entorno (ej: correr la aplicación en diferentes escenarios: stagign, quality assurance, client review, etc...)

### Configtuación Basada en en Variables de Entorno

Usar las viriables de entorno ("env vars") es una practica comun para configurar opciones que dependen de donde corre la aplicación (Ej: las credenciales de la base de datos son usualmente diferentes en producción en comparación a la maquina local). Si los valores son sensibles, puedes encriptarlos como secretos (https://symfony.com/doc/4.4/configuration/secrets.html)

Se puede referenciar las variables de entorno usando la sintaxis especial `%env(ENV_VAR_NAME)%`. Los valores de estas opciones son resueltos en tiempo de ejecución (solo uno por consulta, para no impactar en el performance).

Este ejemplo muestra como se puede configurar la conexión a la base de datos usando las variables de entorno:

      # config/packages/doctrine.yaml
      doctrine:
          dbal:
              # by convention the env var names are always uppercase
              url: '%env(resolve:DATABASE_URL)%'
          # ...

Los valores de las variables de entorno solo pueden ser strings, pero Symfony incluye algunos procesadores de env vars para transformar su contenido (E.J. Convertir un string a integer)

#### Env Var Processors

- `env(string:FOO)` => procesar como string
- `env(bool:FOO)` => procesar como boolean (los valores `true` son `on`, `true`, `yes` y todos los número excepto el `0` y el `0.0` todo lo demas es `false` )
- `env(int:FOO)` => procesar como int
- `env(float:FOO)` => procesar como float
- `env(const:FOO)` => procesar como const
- `env(base64:FOO)` => procesar como base64
- `env(json:FOO)` => procesar como json
- `env(resolve:FOO)` => si el contenido de `FOO` incluye un parametro (con la sintaxis `%parameter_name%`), se reemplazara el parametro con ese valor
- `env(csv:FOO)` => procesar como csv
- `env(file:FOO)` => retorna el contenido de un archivo cual directorio es el valor de `FOO``
- `env(require:FOO)` => El `require()` de PHP, retorna el valor que retorna la función en base al archivo
- `env(trim:FOO)` => Remueve los espacios de inicio y fin de la variable
- `env(key:FOO:BAR)` => recupera el valor asociado con la llave `FOO`del array que está contenido en `BAR`de la variable de entorno 

        # config/services.yaml
        parameters:
            env(SECRETS_FILE): '/opt/application/.secrets.json'
            database_password: '%env(key:database_password:json:file:SECRETS_FILE)%'
            # if SECRETS_FILE contents are: {"database_password": "secret"} it returns "secret"
- `env(default:fallback_param:BAR)` => retorna el parametro `fallback_param` si la variable `BAR` no está disponible
- `env(url:FOO)` => procesa una URL absoluta y retorna sus componentes como un array asociativo

        # config/packages/mongodb.yaml
        mongo_db_bundle:
            clients:
                default:
                    hosts:
                        - { host: '%env(string:key:host:url:MONGODB_URL)%', port: '%env(int:key:port:url:MONGODB_URL)%' }
                    username: '%env(string:key:user:url:MONGODB_URL)%'
                    password: '%env(string:key:pass:url:MONGODB_URL)%'
            connections:
                default:
                    database_name: '%env(key:path:url:MONGODB_URL)%'

- `env(query_string:FOO)` => Procesa la query de una url y retorna sus componenetes como un array asociativo

        # .env
        MONGODB_URL="mongodb://db_user:db_password@127.0.0.1:27017/db_name?timeout=3000"

        # config/packages/mongodb.yaml
        mongo_db_bundle:
            clients:
                default:
                    # ...
                    connectTimeoutMS: '%env(int:key:timeout:query_string:MONGODB_URL)%'

**Pecacuición: Tener cuidado de hacer dump del contenido de las variables `$_SERVER` y `$_ENV` o mostrar el contenido de `phpinfo()` esto expondrá información sensible**

### Configurando Variables de Entorno los Archivos .env

En lugar de definir variables de entorno en la terminal o e el servidor web, Symfony provee una conveniente forma de defirnirlos dentro del archivo `.env` ubicado en la raiz del proyecto.

El archivo `.env` se lee y se analiza en cada petición y se sus variables se agregan a las variables de PHP `$_ENV` y `$_SERVER`. Ninguna variable de entorno existente será sobre escrita por los valores definidos en `.env` pero se pueden combinar las dos.

Por ejemplo, para definir la variable de entorno `DATABASE_URL` mostrada anteriormente, puedes agregaar:

    # .env
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Podrías hacer commit de este archivo a tu repositorio y solo contendria los parametros por defecto necesarios en tu entorno local. Este archivo no contiene las variables de producción.

Además de tus propias variables de entorno, este archivo `.env` también contendra las variables de entorno definidas por los paquetes de terceros instalados en tu aplicación (estos se agregar automaticamente por Symfony Flex cuando instalas paquetes).

**Tip: Como el archivo `.env` es leido y analizado en cada petición, no es necesario limpiar el cache de Symfony o reiniciar el contenedor de PHP si usas Docker**

### .env File Syntax

- Se agregan comentarios con poniendo como prefijo el signo `#`
- Puedes usar variables de entorno en los valores usando el prefijo `$`

      DB_USER=root
      DB_PASS=${DB_USER}pass # include the user as a password prefix

**Tip: Al ser `.env` un archivo regular de scripts para la terminal, puedes hacer `source` de el en tus propios scripts de la terminal``

      $ source .env

### Anular variables de entorno con .env.local

Si necesitas anular un valor de entorno (EJ: diferentes valores en tu maquina local), puedes hacerlo con el archivo `.env.local``

      # .env.local
      DATABASE_URL="mysql://root:@127.0.0.1:3306/my_database_name"

Este archivo debería ser ingnorado por git y no deberías subirse al repositorio del proyecto. Otros archivos `.env`estaran disponibles para asignar variables de entorno solo en las situaciones correctas:

- `.env` Define los valores por defecto de las variables de entorno necesarias en la aplicación
- `.env.local` anula los valores por defecto de todos los entornos pero solo en la maquina que contenga el archivo. Este archivo no debería ser guardado en el repositorio y debe ser ignorado en el entorno de`test` (porque los test deberían producir el mismo resultado para todos)
- `.env<enviroment>` (E.J. `.env.test`): anula las variables de entorno solo para un entorno pero para todas las maquinas (este archivo será subido al repositorio)
- `.env.<enviroment>.local` (E.J. `.env.test.local`): define las variables de entorno especificas de la maquina, anula solo para un entorno. Es similar a `.env.local`, pero la anulación se aplica solo a un entorno.

*Las varaibles de entorno reales siempre tendrán prioridad sobre las variables de entorno creadas con cualquier archivo `.env`*

Los archivos `.env` y `.env.<enviroment>`siempre deberían cargarse en el repositorio porque estos seran siemre los mismo para las maquinas de todos los desarrolladores. De todas formas, el archivo env que finaliza con `.local` (`.env.local` y `.env.<enviroment>.local`) **no deberían ser cargados al repositorio** porque solo tu los usaras. De hecho, el archivo `.gitignore` que viene con Symfony previene esto desde el principio.

### Configruando las Variables de Entorno en Producción

En producción, el archivo `.env` es analizado y cargado en cada request. Así que la forma más facil de definir variables en tu entorno local es creado un archiv `.env.local` en el servidor de producción con los valores de producción.

Para mejorar el performance, tu puedes opcionalmente correr el comando `dump-env` (disponible en Symfony Flex 1.2 o superior).

      # analiza TODOS los .env files y copia estos valores a `.env.loca.php`
      $ composer dump-env prod

Despues de correr este comando, Symfony cargará el archivo `.env.local.php`para obtener las variables de entorno y no gastará tiempo analizando los archivos `.env`

***Tip: Actualiza tus herramientas o flujos de trabajo para correr el comando `dump-env` despues de cada despliegue (deploy) para mejorar el performance de la aplicación***

### Encriptando Variables de Entorno (Secrets)

En lugar de definir variables de entorno reales o agregarlas a el archivo `.env`, si el valor de la variable es sensible (E.J. Una key de API o una contraseña de base de datos), puedes encriptar los valores usando el sistema de administración de secretos (https://symfony.com/doc/4.4/configuration/secrets.html).

### Listando las Variables de Entorno

- Independientemente de como esten establecidas las vairables de entorno, puedes ver el lsitado completo de sus valores con el comando:

      $ php bin/console debug:container --env-vars

- Puedes filtrar entre la lista de variables por nombre

      $ php bin/console debug:container --env-vars foo

- O ver todos los detalles para una variable de entorno especifica

      $ php bin/console debug:container --env-var=FOO

### Acediendo a los Parametros de Configuración

Los controlladores y servicios pueden acceder a todos los parametros de configuración. Esto incluye ambos, los parametros definidos por el desarrollador y los parametros creados por paquetes/bundles. Corre el siguiente parametro y veras todos los parametros existentes en la aplicación:

      $ php bin/console debug:container --parameters

En los controladores que extienden de `AbstractController`, usa el la función helper getParameter():

      $this->getParameter('kernel.project_dir')
      $this->getParameter('app.admin_email')

En los servicios y controladores que no exitienden de `AbstractController`, inyecta los parametros como argumentos en sus contructores. Deberas inyectarlos explicitamente porque el servicio de cableado automatico (autowiring) no funciona para parametros:

      # config/services.yaml
      parameters:
          app.contents_dir: '...'

      services:
          App\Service\MessageGenerator:
              arguments:
                  $contentsDir: '%app.contents_dir%'

Si inyectas el mismo parametro una y otra vez, en su lugar usa la opción `services._defaults.bind`. Los argumentos definidos en esta opcion serán inyectados automaticamente siempre que un servicio contructor o una acción del controllador defina un argumento con exactamente el mismo nombre. Por Ejemplo, para inyectar el valor del parametro `kernel.project_dir` siempre que un servicio/controlador defina un argumento `$projectDir`, usa esto:

        # config/services.yaml
        services:
            _defaults:
                bind:
                    # pass this value to any $projectDir argument for any service
                    # that's created in this file (including controller arguments)
                    $projectDir: '%kernel.project_dir%'

            # ...

Finalmente, si algún servicio necestia acceso a demasiados para metros, en lugar de inyectar cada uno de estos individualmente, puedes inyectar todos los parametros de la aplicación a la vez, usando la clase `ContainerBagInterface` en su constructor.

          public function __construct(ContainerBagInterface $params)
          ...
          ...
          $this->params->get('mailer_sender')
