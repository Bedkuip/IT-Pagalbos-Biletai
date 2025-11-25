namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller {
    public function login(Request $req) { /* kodas kaip pavyzdyje */ }
    public function refresh(Request $req) { /* kodas kaip pavyzdyje */ }
    public function logout(Request $req) { /* kodas kaip pavyzdyje */ }
}
