<?php



namespace App\Http\Controllers;

use App\Models\Destinatarios;
use App\Http\Resources\DestinatarioResource;
use Illuminate\Http\Request;

class DestinatariosContrroller extends Controller
{
    public function index(Request $request)
    {
        // Iniciar la consulta base de destinatarios
        $destinatariosQuery = Destinatarios::query();

        // Aplicar búsqueda si existe
        $this->applySearch($destinatariosQuery, $request->search);

        // Si los checkboxes están presentes en la solicitud, filtramos por esos destinatarios
        if ($request->has('checkbox') && $request->checkbox) {
            $checkbox = json_decode($request->checkbox); // Decodificar los IDs de los destinatarios seleccionados
            $destinatariosQuery->whereIn('id', $checkbox); // Filtrar los destinatarios seleccionados
        }

        // Obtener los destinatarios con paginación
        $destinatarios = DestinatarioResource::collection(
            $destinatariosQuery->paginate(10) // Paginación de 10 por página
        );

        // Devolver la vista con los destinatarios, búsqueda, checkboxes y paginación
        return inertia('Lista/listapersonalizada', [
            'destinatarios' => $destinatarios,
            'search' => $request->search ?? '', // Pasar el valor de búsqueda
            'checkbox' => $request->checkbox ?? '[]', // Pasar el estado de los checkboxes
            'currentPage' => $destinatarios->currentPage(), // Pasar la página actual
        ]);
    }

    // Función para aplicar el filtro de búsqueda
    protected function applySearch($query, $search)
    {
        // Si existe un término de búsqueda, lo aplicamos
        return $query->when($search, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%')
                  ->orWhere('correo', 'like', '%' . $search . '%');
        });
    }
}
