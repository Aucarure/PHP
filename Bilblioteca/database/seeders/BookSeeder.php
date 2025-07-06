<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // PROGRAMACIÓN
            [
                'title' => 'Introducción a la Programación',
                'author' => 'María González',
                'description' => 'Un libro completo para aprender los fundamentos de la programación desde cero. Perfecto para principiantes que quieren adentrarse en el mundo del desarrollo de software.',
                'price' => 24.99,
                'isbn' => '978-841234-567-8',
                'category' => 'Programación',
                'cover_image' => 'https://images.cdn1.buscalibre.com/fit-in/360x360/11/ec/11ec3bf8731ecb6e3e9fcebfb4bccf6f.jpg',
                'status' => 'active',
                'publication_date' => '2023-01-15',
                'publisher' => 'TechBooks Editorial',
                'language' => 'es',
                'pages' => 450,
                'rating' => 4.5,
                'downloads_count' => 1250,
                'views_count' => 5600
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author' => 'Douglas Crockford',
                'description' => 'Descubre las mejores características de JavaScript y aprende a escribir código elegante y eficiente.',
                'price' => 28.99,
                'isbn' => '978-846789-012-3',
                'category' => 'Programación',
                'cover_image' => 'https://p1.akcdn.net/books/mid/268279.jpg',
                'status' => 'active',
                'publication_date' => '2008-05-01',
                'publisher' => "O'Reilly Media",
                'language' => 'es',
                'pages' => 176,
                'rating' => 4.3,
                'downloads_count' => 1800,
                'views_count' => 6700
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'Un manual de estilo para el desarrollo ágil de software que te enseñará a escribir código limpio y mantenible.',
                'price' => 32.99,
                'isbn' => '978-847890-123-4',
                'category' => 'Programación',
                'cover_image' => 'https://elpythonista.com/wp-content/uploads/2020/10/Clean_Code-portada-1024x576.jpg',
                'status' => 'active',
                'publication_date' => '2008-08-01',
                'publisher' => 'Prentice Hall',
                'language' => 'es',
                'pages' => 464,
                'rating' => 4.6,
                'downloads_count' => 2300,
                'views_count' => 9100
            ],
            [
                'title' => 'Python para Principiantes',
                'author' => 'Ana Martínez',
                'description' => 'Aprende Python desde cero con ejemplos prácticos y proyectos reales. Ideal para comenzar en la programación.',
                'price' => 26.99,
                'isbn' => '978-848901-234-5',
                'category' => 'Programación',
                'cover_image' => 'https://m.media-amazon.com/images/I/31gjcSZv3UL.jpg',
                'status' => 'active',
                'publication_date' => '2023-04-10',
                'publisher' => 'Python Press',
                'language' => 'es',
                'pages' => 380,
                'rating' => 4.7,
                'downloads_count' => 1950,
                'views_count' => 7200
            ],

            // DESARROLLO WEB
            [
                'title' => 'Desarrollo Web Moderno',
                'author' => 'Ana Rodríguez',
                'description' => 'Domina las tecnologías más actuales para el desarrollo web frontend y backend con JavaScript y frameworks modernos.',
                'price' => 29.99,
                'isbn' => '978-843456-789-0',
                'category' => 'Desarrollo Web',
                'cover_image' => 'https://www.mentesliberadas.com/wp-content/uploads/2019/12/progressive-web.webp?x79855',
                'status' => 'active',
                'publication_date' => '2023-05-10',
                'publisher' => 'WebTech Publications',
                'language' => 'es',
                'pages' => 520,
                'rating' => 4.8,
                'downloads_count' => 1560,
                'views_count' => 7800
            ],
            [
                'title' => 'Laravel: Desarrollo Web Avanzado',
                'author' => 'Carlos Ruiz',
                'description' => 'Aprende a crear aplicaciones web modernas y escalables usando Laravel, el framework PHP más popular.',
                'price' => 34.99,
                'isbn' => '978-845678-901-2',
                'category' => 'Desarrollo Web',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmTaAvYIVTWFUq98-se29bC1K5dLpe3nI1hQ&s',
                'status' => 'active',
                'publication_date' => '2023-07-15',
                'publisher' => 'WebTech Publications',
                'language' => 'es',
                'pages' => 480,
                'rating' => 4.9,
                'downloads_count' => 2100,
                'views_count' => 8900
            ],
            [
                'title' => 'React y Node.js: Stack Completo',
                'author' => 'Luis Fernando',
                'description' => 'Construye aplicaciones web completas con React en el frontend y Node.js en el backend.',
                'price' => 38.99,
                'isbn' => '978-849012-345-6',
                'category' => 'Desarrollo Web',
                'cover_image' => 'https://images.cdn3.buscalibre.com/fit-in/360x360/be/f9/bef978e5780a2015d28d0e941aac5375.jpg',
                'status' => 'active',
                'publication_date' => '2023-08-20',
                'publisher' => 'Modern Web Press',
                'language' => 'es',
                'pages' => 650,
                'rating' => 4.6,
                'downloads_count' => 1820,
                'views_count' => 6900
            ],

            // BASE DE DATOS
            [
                'title' => 'Base de datos Relacionales',
                'author' => 'Carlos Mendoza',
                'description' => 'Aprende todo sobre bases de datos relacionales, SQL y diseño de sistemas de información robustos.',
                'price' => 19.99,
                'isbn' => '978-842345-678-9',
                'category' => 'Base de Datos',
                'cover_image' => 'https://editorial.unimagdalena.edu.co/Content/PortadasEditorial/20230418171727-651.jpg',
                'status' => 'active',
                'publication_date' => '2023-03-20',
                'publisher' => 'DataPress',
                'language' => 'es',
                'pages' => 380,
                'rating' => 4.7,
                'downloads_count' => 980,
                'views_count' => 3200
            ],
            [
                'title' => 'MongoDB: Base de Datos NoSQL',
                'author' => 'Patricia López',
                'description' => 'Domina MongoDB y las bases de datos NoSQL para aplicaciones modernas y escalables.',
                'price' => 31.99,
                'isbn' => '978-850123-456-7',
                'category' => 'Base de Datos',
                'cover_image' => 'https://images.cdn3.buscalibre.com/fit-in/360x360/6f/7f/6f7f67a778d4433864c6940dfe02941d.jpg',
                'status' => 'active',
                'publication_date' => '2023-06-15',
                'publisher' => 'NoSQL Publications',
                'language' => 'es',
                'pages' => 420,
                'rating' => 4.4,
                'downloads_count' => 740,
                'views_count' => 2800
            ],

            // ALGORITMOS
            [
                'title' => 'Algoritmos y Estructuras de Datos',
                'author' => 'Roberto Silva',
                'description' => 'Una guía completa sobre algoritmos fundamentales y estructuras de datos esenciales para programadores.',
                'price' => 22.99,
                'isbn' => '978-844567-890-1',
                'category' => 'Algoritmos',
                'cover_image' => 'https://images.cdn2.buscalibre.com/fit-in/360x360/03/99/03996c13a6c15e87acc7be4dd1788f12.jpg',
                'status' => 'active',
                'publication_date' => '2023-02-28',
                'publisher' => 'AlgoBooks',
                'language' => 'es',
                'pages' => 640,
                'rating' => 4.6,
                'downloads_count' => 890,
                'views_count' => 4200
            ],

            // LITERATURA CLÁSICA
            [
                'title' => 'Cien años de soledad',
                'author' => 'Gabriel García Márquez',
                'description' => 'Una obra maestra del realismo mágico que narra la historia de la familia Buendía.',
                'price' => 25.99,
                'isbn' => '9780307389732',
                'category' => 'Literatura',
                'cover_image' => 'https://images.cdn3.buscalibre.com/fit-in/520x520/90/d6/90d6455083f95cb36dc10052fe29f2ea.jpg',
                'status' => 'active',
                'publication_date' => '1967-05-30',
                'publisher' => 'Sudamericana',
                'language' => 'es',
                'pages' => 471,
                'rating' => 4.8,
                'downloads_count' => 3500,
                'views_count' => 12000
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'author' => 'Miguel de Cervantes',
                'description' => 'La obra cumbre de la literatura española que narra las aventuras del ingenioso hidalgo.',
                'price' => 30.50,
                'isbn' => '9788467033403',
                'category' => 'Clásicos',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4AGky90dq9vVpmKgveWx9r-jtc2KiIoOB7A&s',
                'status' => 'active',
                'publication_date' => '1605-01-16',
                'publisher' => 'Francisco de Robles',
                'language' => 'es',
                'pages' => 863,
                'rating' => 4.4,
                'downloads_count' => 2800,
                'views_count' => 15000
            ],
            [
                'title' => 'El Principito',
                'author' => 'Antoine de Saint-Exupéry',
                'description' => 'Una hermosa historia sobre la amistad, el amor y las lecciones más importantes de la vida.',
                'price' => 15.99,
                'isbn' => '9788478887194',
                'category' => 'Infantil',
                'cover_image' => 'https://www.crisol.com.pe/media/catalog/product/cache/f6d2c62455a42b0d712f6c919e880845/9/7/9788498386707_pnt7rzgdqctbroiu.jpg',
                'status' => 'active',
                'publication_date' => '1943-04-06',
                'publisher' => 'Reynal & Hitchcock',
                'language' => 'es',
                'pages' => 96,
                'rating' => 4.7,
                'downloads_count' => 4200,
                'views_count' => 18500
            ],

            // CIENCIA FICCIÓN
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'description' => 'Una épica aventura de ciencia ficción en el planeta desértico Arrakis, donde la especia es lo más valioso.',
                'price' => 28.99,
                'isbn' => '978-851234-567-8',
                'category' => 'Ciencia Ficción',
                'cover_image' => 'https://images.cdn1.buscalibre.com/fit-in/360x360/e7/25/e725760e5c93acdeccf44903ff2fcb94.jpg',
                'status' => 'active',
                'publication_date' => '1965-06-01',
                'publisher' => 'Chilton Books',
                'language' => 'es',
                'pages' => 688,
                'rating' => 4.9,
                'downloads_count' => 3200,
                'views_count' => 11500
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'Una distopía que retrata un futuro totalitario donde el Gran Hermano lo vigila todo.',
                'price' => 22.99,
                'isbn' => '978-852345-678-9',
                'category' => 'Ciencia Ficción',
                'cover_image' => 'https://images.cdn1.buscalibre.com/fit-in/360x360/cd/98/cd98b8ec87bf3636c6d3e9019d794bba.jpg',
                'status' => 'active',
                'publication_date' => '1949-06-08',
                'publisher' => 'Secker & Warburg',
                'language' => 'es',
                'pages' => 328,
                'rating' => 4.6,
                'downloads_count' => 2900,
                'views_count' => 13200
            ],

            // HISTORIA
            [
                'title' => 'Sapiens: De animales a dioses',
                'author' => 'Yuval Noah Harari',
                'description' => 'Una breve historia de la humanidad que explica cómo Homo sapiens llegó a dominar el mundo.',
                'price' => 27.99,
                'isbn' => '978-853456-789-0',
                'category' => 'Historia',
                'cover_image' => 'https://www.sancristoballibros.com/imagenes/9788499/978849992421.GIF',
                'status' => 'active',
                'publication_date' => '2011-01-01',
                'publisher' => 'Dvir Publishing House',
                'language' => 'es',
                'pages' => 466,
                'rating' => 4.7,
                'downloads_count' => 4100,
                'views_count' => 16800
            ],

            // FILOSOFÍA
            [
                'title' => 'El mundo de Sofía',
                'author' => 'Jostein Gaarder',
                'description' => 'Una novela sobre la historia de la filosofía contada de manera accesible y entretenida.',
                'price' => 24.99,
                'isbn' => '978-854567-890-1',
                'category' => 'Filosofía',
                'cover_image' => 'https://www.crisol.com.pe/media/catalog/product/cache/f6d2c62455a42b0d712f6c919e880845/9/7/9788498414516_p6mq75cpzgtxzwpt.jpg',
                'status' => 'active',
                'publication_date' => '1991-01-01',
                'publisher' => 'Aschehoug',
                'language' => 'es',
                'pages' => 638,
                'rating' => 4.5,
                'downloads_count' => 2600,
                'views_count' => 9800
            ],

            // ECONOMÍA
            [
                'title' => 'Freakonomics',
                'author' => 'Steven D. Levitt',
                'description' => 'Un economista rebelde explora el lado oculto de todas las cosas con datos y estadísticas sorprendentes.',
                'price' => 26.99,
                'isbn' => '978-855678-901-2',
                'category' => 'Economía',
                'cover_image' => 'https://images.cdn1.buscalibre.com/fit-in/360x360/a2/47/a2479116da393c03d6e2cdfd62ca887a.jpg',
                'status' => 'active',
                'publication_date' => '2005-04-12',
                'publisher' => 'William Morrow',
                'language' => 'es',
                'pages' => 315,
                'rating' => 4.3,
                'downloads_count' => 1800,
                'views_count' => 6700
            ],

            // AUTOAYUDA
            [
                'title' => 'Los 7 hábitos de la gente altamente efectiva',
                'author' => 'Stephen R. Covey',
                'description' => 'Un enfoque integral para resolver problemas personales y profesionales basado en principios universales.',
                'price' => 23.99,
                'isbn' => '978-856789-012-3',
                'category' => 'Autoayuda',
                'cover_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTenKrsU5G4pGuQZeP4Y2DPMrh_CtW-IJdaHg&s',
                'status' => 'active',
                'publication_date' => '1989-08-15',
                'publisher' => 'Free Press',
                'language' => 'es',
                'pages' => 381,
                'rating' => 4.4,
                'downloads_count' => 3100,
                'views_count' => 11200
            ],

            // BIOGRAFÍAS
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'description' => 'La biografía oficial del cofundador de Apple basada en más de cuarenta entrevistas exclusivas.',
                'price' => 29.99,
                'isbn' => '978-857890-123-4',
                'category' => 'Biografías',
                'cover_image' => 'https://leadersummariespro.blob.core.windows.net/lsm/Entity/884338C8D3549F65ABF0302612AFF74E/64FF03483C6F4B66A8DEBCF5F90F48F3/264dd3db-cc7a-4e3c-8b62-bb53ac525e4f.jpg',
                'status' => 'active',
                'publication_date' => '2011-10-24',
                'publisher' => 'Simon & Schuster',
                'language' => 'es',
                'pages' => 656,
                'rating' => 4.6,
                'downloads_count' => 2700,
                'views_count' => 10400
            ]
        ];

        foreach ($books as $bookData) {
            // Generar slug automáticamente
            $bookData['slug'] = Str::slug($bookData['title']);
            
            Book::create($bookData);
        }
    }
}