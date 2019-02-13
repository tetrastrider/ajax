//Introducción
//Javascript es un lenguaje puramente orientado a objetos. Sin embargo, en muchas ocasiones comenzamos a programar sin un patrón de diseño y llenamos nuestra aplicación de variables y funciones globales. Esto se considera una mala práctica y puede dar lugar a errores como las colisiones o dificultades para mantener y reusar el código.
//En este artículo vamos a revisar las técnicas más recientes para la creación de objetos en Javascript. Gracias a estos patrones, podremos crear aplicaciones más organizadas, mantenibles y reusables.
//Malas prácticas desde el día cero
//Cuando comenzamos a programar en Javascript es frecuente declarar un sin fin de variables globales que más tarde iremos utilizando en nuestro script conforme las necesitemos.
//Sin embargo, la bibliografía moderna nos recomienda reservar el uso de este tipo de variables a aquellos objetos que tienen un impacto general en el entorno de nuestra aplicación. Evitando las variables globales reducimos el riesgo de colisión entre ellas a la vez que evitamos ambigüedades.
//Para la mayoría de autores, se resume con la misma frase: hay que evitar la creación de variables y funciones (objetos en general) globales siempre que no sean absolutamente necesarios.
//Para ilustrar esto, hay que recordar que en Javascript, cualquier variable global se asigna inmediatamente a un namespace (contexto) general: el objeto window. Esto permite que podamos acceder a ella directamente por su nombre, o como una propiedad del objeto general:
//view plaincopy to clipboardprint?
var foo = 'bar'; // Definimos la variable como global  
console.log( foo ); // Invocamos a la variable directamente por su nombre  
console.log( window.foo ); // Invocamos a la variable como un método  
//No hay nada nuevo en todo esto. A partir de aquí, ya podemos buscar una estrategia para evitar el uso de variables globales. Para ello, lo ideal es crear un número pequeño de objetos que hagan de contenedores para estas variables o, lo que es lo mismo, recoger todo aquello global que participe de un mismo proceso dentro de un namespace (contexto) propio.
//Autores como Douglas Crockford, John Resig, Angus Croll o James Edwards han elaborado sus propias aproximaciones a este modelo. Veamos algunas de ellas comentando sus ventajas e incovenientes…
//Creación de un objeto global y asignación de métodos por prefijo
//Es la opción más sencilla pero quizá algo desorganizada. En su favor, tenemos que es segura para refactorizar aquellos códigos que presentan un número considerable de variables globales haciendo difícil su reutilización en otros proyectos.
//Tomemos el siguiente código:
//view plaincopy to clipboardprint?
// Opción mala (antipattern)  
var foo = 'Hello';  
var bar = 'World';  
function sum( param1, param2 ){  
return param1 + param2;  
}  
function myMessage(){  
return foo + ' ' + bar;  
}  
  
console.log( sum( 10, 5 ) ); // 15  
console.log( myMessage() ); // Hello World  
//En el ejemplo anterior, definimos dos variables globales y dos funciones dentro del namespace general. Como ya hemos visto, esta forma de programar puede traernos problemas de colisión además de que el código no presenta ningua cohesión.
//Si quisiéramos reaprovechar parte del script, tendríamos que tener cuidado de no olvidarnos alguna variable o función durante el proceso. Según el método de asignación directa que comentamos, el código anterior quedaría como sigue:
//view plaincopy to clipboardprint?
var myApp = {}  
myApp.foo = 'Hello';  
myApp.bar = 'World';  
myApp.sum = function( param1, param2 ){  
return param1 + param2;  
}  
myApp.myMessage = function(){  
return myApp.foo + ' ' + myApp.bar;  
}  
  
console.log( myApp.sum( 10, 5 ) ); // 15  
console.log( myApp.myMessage() ); // Hello World  
//Hemos creado un único objeto global, myApp, que utilizamos como contenedor para el resto de variables y funciones. De este modo, ganamos legibilidad al poder identificar de un solo vistazo, aquellas partes de código que trabajan conjuntamente. A la hora de portar el código, solo tendríamos que preocuparnos de coger aquellas funciones cuyo prefijo coincida con su contexto.
//En el código anterior podríamos utilizar la referencia this en el interior de las funciones para facilitar el mantenimiento en el futuro, pero esto puede dar lugar a errores inesperados. Probemos por ejemplo a asignar uno de los métodos que hemos creado a una nueva función:
//view plaincopy to clipboardprint?
var newFunction = myApp.myMessage;  
console.log( newFunction() ); // Hello World  
//Las referencias a las variables se conservan y nuestra nueva función accede a ellas siguiendo la ruta original (myApp.foo y myApp.bar).
//Cambiemos ahora la referencia a las variables en el ejemplo original:
//view plaincopy to clipboardprint?
// ...  
myApp.myMessage = function(){  
return this.foo + ' ' + this.bar;  
}  
// ...  
console.log( myApp.myMessage); // Hello World  
//El código continúa funcionando correctamente pero, si volvemos a asignar el método a una nueva función, el resultado varía:
//view plaincopy to clipboardprint?
var newFunction = myApp.myMessage;  
console.log( newFunction() ); // Undefined. this está refiriendo al objeto global.  
//Este ejemplo viene a ilustrar una regla que cada vez más autores defienden: nunca debemos referenciar un objeto que estamos utilizando como namespace (contexto) con ‘this‘ ya que podemos obtener errores cuando importamos métodos de un contexto a otro.
//Notación literal
//Utilizando la notación literal, podemos evitar hacer referencia al objeto global cada vez que necesitemos crear un nuevo método. Además, conseguimos un código más limpio y ordenado. Partiendo del ejemplo anterior, el resultado sería:
//view plaincopy to clipboardprint?
var myApp = {  
foo : 'Hello',  
bar : 'World',  
sum : function( param1, param2 ){  
return param1 + param2;  
},  
myMessage : function(){  
return this.foo + ' ' + this.bar;  
}  
};  
  
console.log( myApp.sum( 10, 5 ) ); // 15  
console.log( myApp.myMessage() ); // Hello World  
//Esta estrategia sería la más sencilla para la creación de una estructura básica de POO en Javascript. La portabilidad de los objetos resulta sencilla al tener ‘encapsulado’ todo el proceso.
//Módulos
//El patrón que llamamos módulo se configura a partir de una función que actúa como contexto para nuestra aplicación. Por lo general, esta función se autoejecuta devolviendo el objeto que representa la interfaz pública de nuestro módulo.
//Este modelo es más familiar para aquellos que provienen de otros lenguajes de programación orientados a objetos al permitir distinguir entre métodos públicos y privados. Ya que Javascript no implementa el concepto de clases de forma nativa, creamos funciones que actúen como tales.
//Todas las variables y funciones definidas en el interior de nuestra “clase” se consideran métodos privados. Aquellos métodos que queremos hacer públicos los devolvemos mediantes el comando “return” al ámbito general (módulo) de la aplicación.
//view plaincopy to clipboardprint?
var myApp = (function(){  
var foo = 'Hello';  
var bar = 'World';  
var sum = function( param1, param2 ){  
return param1 + param2;  
}  
return {  
myMessage: function(){  
return foo + ' ' + bar;  
}  
}  
})();  
  
console.log( myApp.myMessage() ); // Hello World  
console.log( myApp.sum( 10, 5 ) ); // myApp.sum is not a function. sum es privada  
//En el código anterior, myApp.sum no se ha incluido en el objeto return por lo que permanece privada y visible únicamente dentro de su contexto. Sin embargo, myMessage, si que ha sido devuelta y añadida al entorno de myApp, por lo que funciona como se espera. Con este modelo, ya no es necesario referenciar a las variables con this, ya que comparten mismo contexto.
//El aspecto negativo de este patrón es que accedemos de forma diferente a los métodos según sean públicos o privados. Esto supone que si queremos cambiar su visibilidad, tenemos que modificar el código moviendo funciones desde o hacia el método return. Otro inconveniente es que los métodos privados resultarán innacesibles para aquellas funciones que sean añadidas al objeto padre (módulo) con posterioridad a su definición.
//Contexto dinámico
//Si declaramos un entorno y lo pasamos como argumento de una función autoejecutable, evitamos tener que asignar variables y métodos al contexto mediante el comando return. Resulta por lo tanto una solución derivada de la anterior pero más legible e intuitiva.
//view plaincopy to clipboardprint?
var myApp = {};  
(function( context ){  
var foo = 'Hello';  
var bar = 'World';  
context.sum = function( param1, param2 ){  
return param1 + param2;  
};  
context.myMessage = function(){  
return foo + ' ' + bar;  
}  
})( myApp );  
  
console.log( myApp.sum( 10, 5 ) ); // 15  
console.log( myApp.myMessage() ); // Hello World  
//Las variables foo y bar, permanecen como privadas, por lo que solo tienen visibilidad dentro de su contexto. Los métodos asignados al objeto contenedor, se convierten en públicos.
//Siguiendo este patrón, incluso podemos asignar el contexto al objeto global tal y como hace, por ejemplo, la librería jQuery. Esto permite al usuario elegir si los métodos de nuestra aplicación se convierten en globales o se restringen a la misma:
//view plaincopy to clipboardprint?
(function( context ){  
var foo = 'Hello';  
var bar = 'World';  
context.sum = function( param1, param2 ){  
return param1 + param2;  
};  
context.myMessage = function(){  
return foo + ' ' + bar;  
}  
})( this );  
  
console.log( sum( 10, 5 ) ); // 15  
console.log( myMessage() ); // Hello World  
//Echemos ahora un vistazo al patrón de James Edwards…
//Patrón de James Edwards ‘This namespaces proxy’
//James Edwards ha creado un patrón cuya simpleza esconde una joya en cuanto a arquitectura de código. Utilizando la referencia this para inyectar métodos al contexto, evita que éstos puedan ser reasignados accidentalmente más adelante.
//view plaincopy to clipboardprint?
var myApp = {};  
(function(){  
var foo = 'Hello';  
var bar = 'World';  
this.sum = function( param1, param2 ){  
return param1 + param2;  
};  
this.myMessage = function(){  
return foo + ' ' + bar;  
};  
}).apply( myApp );  
  
console.log( myApp.sum( 10, 5 ) ); // 15  
console.log( myApp.myMessage() ); // Hello World  
//Simple y elegante: el uso de los comandos apply y call separan el contexto de los argumentos, lo que mejora aún más el diseño general. Siguiendo este patrón, podemos incluso asignar un mismo módulo a dos contextos direfentes consiguiendo implementaciones paralelas:
//view plaincopy to clipboardprint?
var context1 = {}, context2 = {};  
var incrementNumber = function( param1 ){  
var startNumber = param1 || 0;  
this.increment = function(){  
return startNumber++;  
}  
};  
incrementNumber.call( context1 );  
incrementNumber.call( context2, 10 );  
  
console.log( context1.increment() ); // 0  
console.log( context1.increment() ); // 1  
console.log( context1.increment() ); // 2  
console.log( context2.increment() ); // 10  
console.log( context2.increment() ); // 11  
console.log( context2.increment() ); // 12  
Conclusión final
//En la programación Javascript moderna, evitar la creación de variables y métodos globales resulta básico: si pretendemos integrar librerías de terceros o escribir un código que pueda ser reutilizado, tenemos que estructurarlo correctamente para evitar los errores derivados de las colisiones y ambigüedades.
//Para ello, recurrimos a la creación de objetos que actúen como contenedores de aquellas piezas de código que compartan funcionalidad. A lo largo del artículo hemos visto diferentes aproximaciones al mismo problema analizando tanto sus ventajas como los inconvenientes.
//Corresponde ahora al desarrollador elegir aquel método que mejor se adapte a sus necesidades concretas o crear su propio patrón a partir de los mismos.