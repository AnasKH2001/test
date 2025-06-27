use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/admin/providers', [AdminController::class, 'listProviders']);
Route::get('/admin/customers', [AdminController::class, 'listCustomers']);
