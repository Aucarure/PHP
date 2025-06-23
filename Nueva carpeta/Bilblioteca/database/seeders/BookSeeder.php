<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Introducción a la Programación',
                'author' => 'María Gonzales',
                'description' => 'Un libro completo para aprender los fundamentos de la programación desde cero. Perfecto para principiantes que quieren adentrarse en el mundo del desarrollo de software.',
                'price' => 24.99,
                'stock' => 999, // Valor alto para libros digitales
                'isbn' => '978-841234-567-8',
                'category' => 'Programación',
            ],
            [
                'title' => 'Base de datos Relacionales',
                'author' => 'Carlos Mendoza',
                'description' => 'Aprende todo sobre bases de datos relacionales, SQL y diseño de sistemas de información robustos y escalables.',
                'price' => 19.99,
                'stock' => 999,
                'isbn' => '978-842345-678-9',
                'category' => 'Base de Datos',
            ],
            [
                'title' => 'Desarrollo web moderno',
                'author' => 'Ana Rodríguez',
                'description' => 'Domina las tecnologías más actuales para el desarrollo web frontend y backend con JavaScript, frameworks modernos y mejores prácticas.',
                'price' => 29.99,
                'stock' => 999,
                'isbn' => '978-843456-789-0',
                'category' => 'Desarrollo Web',
            ],
            [
                'title' => 'Algoritmos y Estructuras',
                'author' => 'Roberto Silva',
                'description' => 'Una guía completa sobre algoritmos fundamentales y estructuras de datos esenciales para cualquier programador profesional.',
                'price' => 22.99,
                'stock' => 999,
                'isbn' => '978-844567-890-1',
                'category' => 'Algoritmos',
            ],
            [
                'title' => 'Desarrollo web con Laravel',
                'author' => 'Ana Rodríguez',
                'description' => 'Aprende a crear aplicaciones web modernas y escalables usando Laravel, el framework PHP más popular del mundo.',
                'price' => 34.99,
                'stock' => 999,
                'isbn' => '978-845678-901-2',
                'category' => 'Desarrollo Web',
            ],
            [
                'title' => 'Cien años de soledad',
                'author' => 'Gabriel García Márquez',
                'description' => 'Una obra maestra del realismo mágico que narra la historia de la familia Buendía a lo largo de siete generaciones.',
                'price' => 25.99,
                'stock' => 999,
                'isbn' => '9780307389732',
                'category' => 'Literatura',
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'author' => 'Miguel de Cervantes',
                'description' => 'La obra cumbre de la literatura española que narra las aventuras del ingenioso hidalgo Don Quijote y su fiel escudero Sancho Panza.',
                'price' => 30.50,
                'stock' => 999,
                'isbn' => '9788467033403',
                'category' => 'Clásicos',
            ],
            [
                'title' => 'El Principito',
                'author' => 'Antoine de Saint-Exupéry',
                'description' => 'Una hermosa historia sobre la amistad, el amor y las lecciones más importantes de la vida contada desde la perspectiva de un niño.',
                'price' => 15.99,
                'stock' => 999,
                'isbn' => '9788478887194',
                'category' => 'Infantil',
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author' => 'Douglas Crockford',
                'description' => 'Descubre las mejores características de JavaScript y aprende a escribir código elegante y eficiente.',
                'price' => 28.99,
                'stock' => 999,
                'isbn' => '978-846789-012-3',
                'category' => 'Programación',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'Un manual de estilo para el desarrollo ágil de software que te enseñará a escribir código limpio y mantenible.',
                'price' => 32.99,
                'stock' => 999,
                'isbn' => '978-847890-123-4',
                'category' => 'Programación',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}