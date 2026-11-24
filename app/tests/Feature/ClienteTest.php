<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    private function datosValidos(array $cambios = []): array
    {
        return array_merge([
            'nombre' => 'Condominio Las Flores',
            'tipo' => 'residencial',
            'telefono' => '8888-1234',
        ], $cambios);
    }

    public function test_muestra_el_formulario_de_registro(): void
    {
        $this->get(route('clientes.create'))
            ->assertOk()
            ->assertSee('Nuevo cliente')
            ->assertSee('Residencial')
            ->assertSee('Comercial');
    }

    public function test_la_lista_indica_cuando_no_hay_clientes(): void
    {
        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSee('Todavía no hay clientes registrados.');
    }

    public function test_guardar_con_datos_validos_muestra_el_cliente_en_la_lista(): void
    {
        $this->post(route('clientes.store'), $this->datosValidos())
            ->assertRedirect(route('clientes.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('clientes', $this->datosValidos());

        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSee('Cliente registrado correctamente.')
            ->assertSee('Condominio Las Flores')
            ->assertSee('8888-1234');
    }

    public function test_guarda_cliente_comercial(): void
    {
        $this->post(route('clientes.store'), $this->datosValidos(['nombre' => 'Oficinas Centro', 'tipo' => 'comercial']))
            ->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('clientes', ['nombre' => 'Oficinas Centro', 'tipo' => 'comercial']);
    }

    public static function camposObligatorios(): array
    {
        return [
            'sin nombre' => ['nombre', 'El nombre es obligatorio.'],
            'sin tipo' => ['tipo', 'El tipo de cliente es obligatorio.'],
            'sin teléfono' => ['telefono', 'El teléfono es obligatorio.'],
        ];
    }

    #[DataProvider('camposObligatorios')]
    public function test_si_falta_un_campo_obligatorio_muestra_error_y_no_guarda(string $campo, string $mensaje): void
    {
        $this->from(route('clientes.create'))
            ->post(route('clientes.store'), $this->datosValidos([$campo => '']))
            ->assertRedirect(route('clientes.create'))
            ->assertSessionHasErrors([$campo => $mensaje]);

        $this->assertDatabaseCount('clientes', 0);

        // Siguiendo la redirección, el formulario muestra el mensaje de error.
        $this->from(route('clientes.create'))
            ->followingRedirects()
            ->post(route('clientes.store'), $this->datosValidos([$campo => '']))
            ->assertOk()
            ->assertSee('Revisa los datos del formulario')
            ->assertSee($mensaje);

        $this->assertDatabaseCount('clientes', 0);
    }

    public function test_rechaza_un_tipo_no_valido(): void
    {
        $this->post(route('clientes.store'), $this->datosValidos(['tipo' => 'industrial']))
            ->assertSessionHasErrors(['tipo' => 'El tipo debe ser residencial o comercial.']);

        $this->assertDatabaseCount('clientes', 0);
    }

    public function test_rechaza_un_telefono_con_letras(): void
    {
        $this->post(route('clientes.store'), $this->datosValidos(['telefono' => 'abc123']))
            ->assertSessionHasErrors('telefono');

        $this->assertDatabaseCount('clientes', 0);
    }

    public function test_la_lista_muestra_los_clientes_registrados(): void
    {
        Cliente::factory()->create(['nombre' => 'Hotel Sol']);
        Cliente::factory()->create(['nombre' => 'Casa Mora']);

        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSeeInOrder(['Casa Mora', 'Hotel Sol']);
    }
}
