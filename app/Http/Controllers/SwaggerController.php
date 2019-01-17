<?php
/**
 * @license Apache 2.0
 */
namespace App\Http\Controllers;

use OpenApi\Annotations\Contact;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Server;

/**
 *
 * @Info(
 *     version="1.0.0",
 *     title="Presentación del servicio",
 *     description="Desarrollo de sistema de autogestión de conocimiento como herramienta informática inclusiva Open source que favorezca el aprendizaje de estudiantes con discapacidad auditiva leve de tercer nivel de educación superior",
 *     @Contact(
 *         email="j.arturopad@gmail.com",
 *         name="José Arturo Padilla Espinoza"
 *     )
 * )
 */
 /**
 * @Tag(
 *     name="home",
 *     @ExternalDocumentation(
 *         url="http://localhost:8000"
 *     )
 * )
 * @Server(
 *     url="http://localhost:8000",
 *     description="development environment",
 * )
 * @Schema(
 *     schema="ApiResponse",
 *     type="object",
 *     description="Response to the entity, the response result uses the structure uniformly",
 *     title="Response entity",
 *     @Property(
 *         property="code",
 *         type="string",
 *         description="response code"
 *     ),
 *     @Property(property="message", type="string", description="response to results")
 * )
 * @ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger.io"
 * )
 *
 * @package App\Http\Controllers
 */
class SwaggerController  {
    //
}
