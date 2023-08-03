# Sistema de Votación Electrónica

El Sistema de Votación Electrónica es una aplicación web diseñada para facilitar los procesos de votación. El sistema proporciona una interfaz de usuario intuitiva y segura para recopilar los votos de los usuarios y almacenarlos en una base de datos.
Tecnologías

## La aplicación utiliza las siguientes tecnologías:

* Front-end: HTML, CSS, JavaScript, jQuery
* Back-end: PHP
* Base de datos: MySQL

## Características

Registro de votantes: La aplicación permite a los votantes registrarse introduciendo sus detalles en un formulario de registro. Los datos solicitados incluyen el nombre, apellido, alias, RUT, email, región, provincia, comuna, candidato, y cómo se enteró de nosotros. Todos estos campos son validados antes de que el voto se registre en la base de datos.
    Validación de RUT: La aplicación valida el RUT introducido por el usuario para asegurarse de que es válido y de que no se ha utilizado para votar anteriormente.
    Selección de candidato: La aplicación permite a los votantes seleccionar a su candidato preferido de una lista desplegable.
    Base de datos: La aplicación utiliza una base de datos MySQL para almacenar los votos. La base de datos está estructurada de forma que cada voto se registra junto con los detalles del votante.

## Datos Técnicos

Para instalar y utilizar la aplicación, primero clone el repositorio a su máquina local utilizando git clone. A continuación, importe la base de datos a su servidor MySQL. Puede hacer esto utilizando la línea de comandos o una interfaz gráfica como phpMyAdmin.

---

# Sistema de Votación Electrónica

El Sistema de Votación Electrónica es una aplicación que permite a los usuarios emitir sus votos de manera electrónica en diferentes elecciones. El proyecto proporciona una plataforma segura y eficiente para realizar procesos de votación, eliminando la necesidad de votaciones presenciales en papel.

## Requisitos
* PHP 8.2.8
* Base de Datos ejemploVotoBD, versión: 10.4.24-MariaDB

## Instrucciones de Instalación

1. Descargar el código fuente del proyecto desde [aquí](https://github.com/m4570r/SistemaVotacion).
2. Crear una base de datos en MySQL con el nombre 'ejemploVotoBD'.
3. Importar el archivo de la base de datos 'estructuraBD.sql' ubicado en la carpeta del proyecto. Encuentra este archivo dentro de la subcarpeta 'SQL' y ejecútalo para crear la estructura de la base de datos.
4. En la misma carpeta, debes localizar el archivo 'datosBD.sql' y ejecútalo para poblar la base de datos con los datos iniciales del proyecto.
5. Configura la conexión a la base de datos en el archivo de configuración 'config.php'. Está ubicado dentro de la subcarpeta 'php'. Actualiza los parámetros de conexión, como el nombre del servidor, el nombre de usuario, la contraseña y el nombre de la base de datos.
6. Copiar todos los archivos del proyecto en la carpeta del servidor web local o en el directorio raíz del sitio web en el servidor remoto.
7. Asegurarse de que el servidor web tenga instalada y habilitada la versión de PHP 8.2.8, así como la versión de MySQL 10.4.24-MariaDB.
8. Acceder al proyecto desde el navegador web ingresando la URL `http://localhost/<nombre del directorio>/index.php`.
9. ¡Listo! Ahora puedes explorar y utilizar el proyecto.

## Notas adicionales
Si encuentras algún problema durante la instalación o el uso del Sistema de Votación Electrónica, contáctanos en mgonzalez.gnu@gmail.com para recibir asistencia técnica.

## Contacto y Soporte
Para cualquier consulta o soporte técnico relacionado con este proyecto, contáctanos en mgonzalez.gnu@gmail.com.

## Mensaje especial
Agradezco la oportunidad de participar en el proceso de selección para el cargo de programador PHP. Realizar este proyecto ha sido un verdadero placer para mí. Espero que el Sistema de Votación Electrónica sea de gran utilidad para evaluar mis habilidades y conocimientos. Estoy entusiasmado por formar parte de este equipo y contribuir al éxito de futuros proyectos. ¡Gracias por esta oportunidad! Me divertí mucho.

**¡Gracias por utilizar el Sistema de Votación Electrónica! Esperamos que esta plataforma facilite y mejore tus procesos de votación.**
