<?php

namespace Modules\BandInTown\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artist_id = 'id_279327';
        $artist_name = 'bruno mars' ?? $request->artist_name ?? null;

        if (!$artist_name) {
            return response()->json(['events' => []]);
        }
        $artist_name = urlencode(strtolower($artist_name));
        $app_id = config('bandintown.app_id') ?? null;
        $endpoint = 'https://rest.bandsintown.com/artists/' . $artist_name . '/events';

        // $hit = 'https://rest.bandsintown.com/artists/eminem/events';
        // dd($endpoint, $app_id);
        $data = $this->getResponse($endpoint, $app_id);
        $is_error = $data['errorMessage'] ?? null;
        $eventList = [];
        if (!$is_error) {
            foreach ($data as $res) {
                // Format the date
                $startsAt = $res['starts_at'] ?? null;
                $dateStr = null;
                if ($startsAt) {
                    $inputDatetime = Carbon::parse($startsAt);
                    $dateStr = strtoupper($inputDatetime->format('d M'));
                }
                $venue = $res['venue'] ?? [];
                // Get the venue name and location
                $venueName = strtoupper($venue['name'] ?? '');
                $venueLocation = $venue['location'] ?? null;

                // Get ticket URL from offers
                $ticketUrl = null;
                if (isset($res['offers'])) {
                    foreach ($res['offers'] as $offer) {
                        if ($offer['type'] === 'Tickets') {
                            $ticketUrl = $offer['url'] ?? null;
                            break;
                        }
                    }
                }

                // Build RSVP URL
                $rsvpUrl = null;
                $eventUrl = $res['url'] ?? null;
                if ($eventUrl) {
                    $rsvpUrl = $eventUrl . '&trigger=rsvp_going';
                }

                // Add to event list
                $eventList[] = [
                    'date' => $dateStr,
                    'venue_name' => $venueName,
                    'venue_location' => $venueLocation,
                    'ticket_url' => $ticketUrl,
                    'rsvp_url' => $rsvpUrl,
                ];
            }
        }


        return response()->json(['events' => $eventList]);
    }

    public function getResponse($endpoint, $app_id)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->get($endpoint, [
                        'app_id' => $app_id
                    ]);
            return $response->json() ?? [];
        } catch (\Exception $e) {

        }
        return [];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function script()
    {
        return response()->view('bandintown::script', [], 200)
            ->header('Content-Type', 'text/javascript');
    }


    public function dummy()
    {
        return view('bandintown::dummy');
    }

}
