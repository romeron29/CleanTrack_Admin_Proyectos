<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Inmueble;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class InmuebleTest extends TestCase
{
    use RefreshDatabase;

    private Cliente $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cliente = Cliente::factory()->create(['nombre' => 'Hotel Sol']);
    }

    private function datosValidos(array $cambios = []): array
    {
        return array_merge([
            'direccion' => 'Avenida Central, casa 25',
            'tipo' => 'casa',
        ], $cambios);
    }

    public function test_muestra_el_formulario_con_el_cliente_y_los_tipos(): void
    {
        $this->get(route('clientes.inmuebles.create', $this->cliente))
            ->assertOk()
            ->assertSee('Nuevo inmueble')
            ->assertSee('Hotel Sol')
            ->assertSee('Casa')
            ->assertSee('Apartamento')
            ->assertSee('Oficina')
            ->assertSee('Local');
    }

    public function test_la_lista_indica_cuando_el_cliente_no_tiene_inmuebles(): void
    {
        $this->get(route('clientes.inmuebles.index', $this->cliente))
            ->assertOk()
            ->assertSee('Inmuebles de Hotel Sol')
            ->assertSee('Este cliente todavía no tiene inmuebles registrados.');
    }

    public function test_guardar_con_datos_validos_asocia_el_inmueble_al_cliente_y_lo_muestra(): void
    {
        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos())
            ->assertRedirect(route('clientes.inmuebles.index', $this->cliente))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('inmuebles', $this->datosValidos(['cliente_id' => $this->cliente->id]));

        $this->get(route('clientes.inmuebles.index', $this->cliente))
            ->assertOk()
            ->assertSee('Inmueble registrado correctamente.')
            ->assertSee('Avenida Central, casa 25');
    }

    public static function tiposValidos(): array
    {
        return array_map(fn ($tipo) => [$tipo], array_combine(Inmueble::TIPOS, Inmueble::TIPOS));
    }

    #[DataProvider('tiposValidos')]
    public function test_acepta_cada_tipo_de_inmueble(string $tipo): void
    {
        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['tipo' => $tipo]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('inmuebles', ['tipo' => $tipo, 'cliente_id' => $this->cliente->id]);
    }

    public function test_un_cliente_puede_tener_varios_inmuebles(): void
    {
        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['direccion' => 'Calle 1']));
        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['direccion' => 'Calle 2', 'tipo' => 'oficina']));

        $this->assertCount(2, $this->cliente->fresh()->inmuebles);

        $this->get(route('clientes.inmuebles.index', $this->cliente))
            ->assertSeeInOrder(['Calle 1', 'Calle 2']);
    }

    public function test_solo_se_muestran_los_inmuebles_del_cliente(): void
    {
        $otro = Cliente::factory()->create();
        Inmueble::factory()->for($otro)->create(['direccion' => 'Inmueble ajeno']);
        Inmueble::factory()->for($this->cliente)->create(['direccion' => 'Inmueble propio']);

        $this->get(route('clientes.inmuebles.index', $this->cliente))
            ->assertSee('Inmueble propio')
            ->assertDontSee('Inmueble ajeno');
    }

    public function test_el_cliente_se_toma_de_la_ruta_y_no_del_formulario(): void
    {
        $otro = Cliente::factory()->create();

        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['cliente_id' => $otro->id]));

        $this->assertDatabaseHas('inmuebles', ['cliente_id' => $this->cliente->id]);
        $this->assertDatabaseMissing('inmuebles', ['cliente_id' => $otro->id]);
    }

    public static function camposObligatorios(): array
    {
        return [
            'sin dirección' => ['direccion', 'La dirección es obligatoria.'],
            'sin tipo' => ['tipo', 'El tipo de inmueble es obligatorio.'],
        ];
    }

    #[DataProvider('camposObligatorios')]
    public function test_si_falta_un_campo_obligatorio_muestra_error_y_no_guarda(string $campo, string $mensaje): void
    {
        $this->from(route('clientes.inmuebles.create', $this->cliente))
            ->followingRedirects()
            ->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos([$campo => '']))
            ->assertOk()
            ->assertSee('Revisa los datos del formulario')
            ->assertSee($mensaje);

        $this->assertDatabaseCount('inmuebles', 0);
    }

    public function test_rechaza_un_tipo_no_valido(): void
    {
        $this->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['tipo' => 'bodega']))
            ->assertSessionHasErrors(['tipo' => 'El tipo debe ser casa, apartamento, oficina o local.']);

        // El mensaje se muestra en el formulario.
        $this->from(route('clientes.inmuebles.create', $this->cliente))
            ->followingRedirects()
            ->post(route('clientes.inmuebles.store', $this->cliente), $this->datosValidos(['tipo' => 'bodega']))
            ->assertOk()
            ->assertSee('El tipo debe ser casa, apartamento, oficina o local.');

        $this->assertDatabaseCount('inmuebles', 0);
    }

    public function test_cliente_inexistente_devuelve_404(): void
    {
        $this->get(route('clientes.inmuebles.index', 999))->assertNotFound();
        $this->post(route('clientes.inmuebles.store', 999), $this->datosValidos())->assertNotFound();

        $this->assertDatabaseCount('inmuebles', 0);
    }

    public function test_la_base_de_datos_exige_un_cliente_existente(): void
    {
        $this->expectException(QueryException::class);

        Inmueble::factory()->create(['cliente_id' => 999]);
    }

    public function test_la_lista_de_clientes_enlaza_a_sus_inmuebles(): void
    {
        Inmueble::factory()->count(2)->for($this->cliente)->create();

        $this->get(route('clientes.index'))
            ->assertSee(route('clientes.inmuebles.index', $this->cliente))
            ->assertSee('Ver inmuebles (2)');
    }
}
