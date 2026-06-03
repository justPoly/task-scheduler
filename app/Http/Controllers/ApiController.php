use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\ApiLog;

class ApiController extends Controller
{
    public function weather()
    {
        // 1. Log request
        ApiLog::create([
            'endpoint' => '/api/weather',
            'ip_address' => request()->ip()
        ]);

        // 2. Cache API response for 1 hour
        $data = Cache::remember('weather_data', 3600, function () {

            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => 'Lagos',
                'appid' => env('WEATHER_API_KEY'),
                'units' => 'metric'
            ]);

            return $response->json();
        });

        return response()->json($data);
    }
}