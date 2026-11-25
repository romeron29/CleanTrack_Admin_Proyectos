<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Inmueble;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FichaInmuebleTest extends TestCase
{
    use RefreshDatabase;

    private Cliente $cliente;

    private Inmueble $inmueble;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cliente = Cliente::factory()->create([
            'nombre' => 'Hotel Sol',
            'tipo' => 'comercial',
            'telefono' => '2222-3333',
        ]);

        $this->inmueble = Inmueble::factory()->for($this->cliente)->create([
            'direccion' => 'Paseo Colón, edificio 4',
            'tipo' => 'oficina',
            'habitaciones' => 0,
            'banos' => 3,
            'cocinas' => 1,
            'oficinas' => 7,
        ]);
    }

    private function urlFicha(?Cliente $cliente = null, ?Inmueble $inmueble = null): string
    {
        return route('clientes.inmuebles.show', [$cliente ?? $this->cliente, $inmueble ?? $this->inmueble]);
    }

    public function test_la_ficha_muestra_direccion_tipo_y_cliente(): void
    {
        $this->get($this->urlFicha())
            ->assertOk()
            ->assertSee('Ficha del inmueble')
            ->assertSee('Paseo Colón, edificio 4')
            ->assertSee('Oficina')
            ->assertSee('Hotel Sol')
            ->assertSee('2222-3333');
    }

    public function test_la_ficha_muestra_la_cantidad_de_cada_area(): void
    {
        $this->get($this->urlFicha())
            ->assertOk()
            ->assertSeeInOrder([
                '0', 'Habitaciones',
                '3', 'Baños',
                '1', 'Cocinas',
                '7', 'Oficinas',
            ]);
    }

    public function test_la_lista_de_inmuebles_enlaza_a_la_ficha(): void
    {
        $this->get(route('clientes.inmuebles.index', $this->cliente))
            ->assertOk()
            ->assertSee($this->urlFicha())
            ->assertSee('Ver ficha');
    }

    public function test_la_ficha_permite_volver_a_la_lista_del_cliente(): void
    {
        $this->get($this->urlFicha())
            ->assertSee(route('clientes.inmuebles.index', $this->cliente))
            ->assertSee('Volver a los inmuebles de Hotel Sol');
    }

    public function test_la_ficha_es_adaptable_a_telefono(): void
    {
        $this->get($this->urlFicha())
            ->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1">', false)
            ->assertSee('class="ficha-areas"', false)
            ->assertSee('grid-template-columns: repeat(2, 1fr)', false);
    }

    public function test_un_inmueble_de_otro_cliente_devuelve_404(): void
    {
        $otro = Cliente::factory()->create();

        $this->get($this->urlFicha($otro, $this->inmueble))->assertNotFound();
    }

    public function test_un_inmueble_inexistente_devuelve_404(): void
    {
        $this->get(route('clientes.inmuebles.show', [$this->cliente, 999]))->assertNotFound();
    }
}
