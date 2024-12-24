<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TodoController extends Controller
{
    //
    public function index()
    {
        $client = new Client();
        $response = $client->get('https://api.sugity.kelola.biz/api/todo');
        $data = json_decode($response->getBody()->getContents(), true);

        return view('todo', compact(var_name: 'data'));
    }

    public function store(Request $request)
    {
        $client = new Client();

        try {
            // Persiapkan payload request
            $payload = [
                'todos' => [
                    [
                        'id' => rand(1000, 9999),
                        'todo' => $request->input('todo'),
                        'completed' => filter_var($request->input('completed'), FILTER_VALIDATE_BOOLEAN),
                        'userId' => rand(1, 100),
                    ],
                ],
            ];

            Log::info('Request Payload: ' . json_encode($payload)); // Log payload request

            // Kirim permintaan POST ke API
            $response = $client->post('https://api.sugity.kelola.biz/api/todo', [
                'json' => $payload,
            ]);

            // Ambil respons dari API
            $responseBody = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $headers = $response->getHeaders();

            // Log respons dari API
            Log::info('API Raw Response: ' . $responseBody);
            Log::info('API Status Code: ' . $statusCode);
            Log::info('API Response Headers: ' . json_encode($headers));

            // Periksa status kode respons
            if (!in_array($statusCode, [200, 201])) {
                return redirect('/')->with('error', 'Unexpected response from server. Status Code: ' . $statusCode);
            }

            // Decode respons JSON
            $data = json_decode($responseBody, true);

            if ($data === null) {
                Log::error('Failed to decode JSON: ' . $responseBody);
                return redirect('/')->with('error', 'Invalid JSON response from API.');
            }

            // Periksa jika respons menunjukkan kesuksesan
            if (isset($data['type']) && $data['type'] === 'success') {
                return redirect('/')->with('success', $data['message'] ?? 'Todo added successfully!');
            } else {
                return redirect('/')->with('error', 'Failed to add todo. Server error.');
            }
        } catch (RequestException $e) {
            Log::error('API Request Error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Failed to connect to the API. Please try again.');
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect('/')->with('error', 'An unexpected error occurred.');
        }
    }

    public function edit($id)
    {
        // Fetch data from the external API
        $response = Http::get("https://api.sugity.kelola.biz/api/todo/", [
            'id' => $id
        ]);

        if ($response->successful()) {
            return response()->json($response->json()); // Return the todo data to pre-fill the modal form
        } else {
            return response()->json(['error' => 'Unable to fetch data from the API'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $response = Http::post("https://api.sugity.kelola.biz/api/todo/$id", [
                'todo' => $request->todo,
                'completed' => filter_var($request->completed, FILTER_VALIDATE_BOOLEAN),
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Data updated successfully');
            } else {
                return redirect()->back()->with('error', 'API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error updating Todo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the Todo');
        }
    }

    public function delete($id)
    {
        // Create a new Guzzle client instance
        $client = new Client();

        try {
            // Make the DELETE request to the correct API endpoint
            $response = $client->delete("https://api.sugity.kelola.biz/api/todo/$id");

            // Log the entire response for debugging
            $responseBody = $response->getBody()->getContents();
            Log::info('API Response:', [
                'status' => $response->getStatusCode(),
                'body' => $responseBody
            ]);

            // Check if the response is successful
            $body = json_decode($responseBody, true);  // Decode the response to check its structure

            if ($response->getStatusCode() == 200) {
                if (isset($body['type']) && $body['type'] == 'success') {
                    return redirect()->back()->with('success', 'Data deleted successfully');
                }

                // Log and return the error if the 'type' field is not 'success'
                Log::error('Unexpected API response structure', ['response' => $body]);
                return redirect()->back()->with('error', 'API did not return success message');
            } else {
                // Log and return an error if the status code is not 200
                Log::error('Unexpected status code', ['status_code' => $response->getStatusCode()]);
                return redirect()->back()->with('error', 'Unexpected status code: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            Log::error('Error during API call', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
