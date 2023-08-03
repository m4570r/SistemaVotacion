# Sistema de Votación Electrónica

El Sistema de Votación Electrónica es una aplicación web diseñada para facilitar los procesos de votación. El sistema proporciona una interfaz de usuario intuitiva y segura para recopilar los votos de los usuarios y almacenarlos en una base de datos.
Tecnologías

## La aplicación utiliza las siguientes tecnologías:

    Front-end: HTML, CSS, JavaScript, jQuery
    Back-end: PHP
    Base de datos: MySQL

## Características

    Registro de votantes: La aplicación permite a los votantes registrarse introduciendo sus detalles en un formulario de registro. Los datos solicitados incluyen el nombre, apellido, alias, RUT, email, región, provincia, comuna, candidato, y cómo se enteró de nosotros. Todos estos campos son validados antes de que el voto se registre en la base de datos.
    Validación de RUT: La aplicación valida el RUT introducido por el usuario para asegurarse de que es válido y de que no se ha utilizado para votar anteriormente.
    Selección de candidato: La aplicación permite a los votantes seleccionar a su candidato preferido de una lista desplegable.
    Base de datos: La aplicación utiliza una base de datos MySQL para almacenar los votos. La base de datos está estructurada de forma que cada voto se registra junto con los detalles del votante.

## Instalación y uso

Para instalar y utilizar la aplicación, primero clone el repositorio a su máquina local utilizando git clone. A continuación, importe la base de datos a su servidor MySQL. Puede hacer esto utilizando la línea de comandos o una interfaz gráfica como phpMyAdmin.

Una vez que la base de datos está configurada, puede iniciar la aplicación abriendo el archivo index.html en su navegador.
