<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mascota;

class MascotaSeeder extends Seeder
{
    public function run(): void
    {
        $mascotas = [
            ['nombre' => 'Firulais', 'tipo' => 'Perro', 'edad' => 3, 'raza' => 'Labrador', 'peso' => 25.5, 'fecha_adopcion' => '2022-01-15'],
            ['nombre' => 'Mishi', 'tipo' => 'Gato', 'edad' => 2, 'raza' => 'Persa', 'peso' => 4.3, 'fecha_adopcion' => '2023-02-10'],
            ['nombre' => 'Kiko', 'tipo' => 'Pájaro', 'edad' => 1, 'raza' => 'Canario', 'peso' => 0.2, 'fecha_adopcion' => '2023-07-01'],
            ['nombre' => 'Rex', 'tipo' => 'Perro', 'edad' => 5, 'raza' => 'Pastor Alemán', 'peso' => 30.1, 'fecha_adopcion' => '2020-11-20'],
            ['nombre' => 'Nube', 'tipo' => 'Gato', 'edad' => 4, 'raza' => 'Siamés', 'peso' => 5.0, 'fecha_adopcion' => '2021-09-12'],
            ['nombre' => 'Luna', 'tipo' => 'Conejo', 'edad' => 2, 'raza' => 'Mini Lop', 'peso' => 1.8, 'fecha_adopcion' => '2023-05-22'],
            ['nombre' => 'Rocky', 'tipo' => 'Perro', 'edad' => 6, 'raza' => 'Pitbull', 'peso' => 28.7, 'fecha_adopcion' => '2019-06-10'],
            ['nombre' => 'Pepe', 'tipo' => 'Pájaro', 'edad' => 3, 'raza' => 'Loro', 'peso' => 1.0, 'fecha_adopcion' => '2021-04-05'],
            ['nombre' => 'Mota', 'tipo' => 'Gato', 'edad' => 1, 'raza' => 'Angora', 'peso' => 3.6, 'fecha_adopcion' => '2023-12-01'],
            ['nombre' => 'Max', 'tipo' => 'Perro', 'edad' => 4, 'raza' => 'Beagle', 'peso' => 10.0, 'fecha_adopcion' => '2020-08-19'],
            ['nombre' => 'Bolita', 'tipo' => 'Conejo', 'edad' => 1, 'raza' => 'Rex', 'peso' => 1.3, 'fecha_adopcion' => '2024-03-10'],
            ['nombre' => 'Kiwi', 'tipo' => 'Pájaro', 'edad' => 2, 'raza' => 'Periquito', 'peso' => 0.25, 'fecha_adopcion' => '2022-11-14'],
            ['nombre' => 'Chispa', 'tipo' => 'Gato', 'edad' => 3, 'raza' => 'Maine Coon', 'peso' => 6.2, 'fecha_adopcion' => '2021-01-30'],
            ['nombre' => 'Boby', 'tipo' => 'Perro', 'edad' => 7, 'raza' => 'Bulldog', 'peso' => 22.4, 'fecha_adopcion' => '2018-05-07'],
            ['nombre' => 'Coco', 'tipo' => 'Perro', 'edad' => 2, 'raza' => 'Chihuahua', 'peso' => 3.0, 'fecha_adopcion' => '2024-01-25'],
        ];

        foreach ($mascotas as $mascota) {
            Mascota::create($mascota);
        }
    }
}
