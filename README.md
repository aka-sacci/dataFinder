# dataFinder
A simple project that returns a PDF archive with the data of a organization with a valid brazilian EIN (CNPJ);

I developed this to study some concepts and functionalities of Composer and few dependencies.

## Dependencies used:
[getcnpj-php()](https://github.com/aka-sacci/getcnpj-php) - API used to recovery the data from the national database;

[mpdf](https://github.com/mpdf/mpdf) - Dependecy used to generate PDF files;

[CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) - Dependecy used to organize the code following the rules of PSR12;

## How to use

Make sure that [Composer](https://github.com/composer/composer) are installed in your PHP server!

Clone my repo to your PHP server (like 'htdocs' folder in XAMPP);

Install the dependencies of the project:
>composer i

Acess 'localhost/datafinder'!

