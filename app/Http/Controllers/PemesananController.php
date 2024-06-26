<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Sapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $pesan = Pemesanan::all();
        $sapi = Sapi::all();
        return view('pemesanan.table', compact('sapi','pesan'));
    }

    public function create()
    {
        //get sapi untuk dropdown
        $user = Auth::user();
        $sapi = Sapi::all();
        // belum bikin kolom availabilitynya
        $sapi = Sapi::where('availability', 1)->get();
        return view('pemesanan.form', compact('sapi', 'user'));
    }

    public function store(Request $request)
    {
        // $input = $request->all();
        // Pemesanan::create($input);
        // return redirect('pemesanan/table');

        $input = $request->all();
        // $input['pembayaran'] = $request->input('formatted_pembayaran'); // Ensure 'pembayaran' field is set correctly
        $input['admin'] = auth()->user()->name;  // Assuming the user is authenticated

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new pemesanan record
            Pemesanan::create($input);

            // Update the sapi availability
            $sapi = Sapi::find($request->input('id_sapi'));
            $sapi->availability = 0;  // Update the availability
            $sapi->save();

            // Commit the transaction
            DB::commit();

            // Redirect after successful creation and update
            return redirect('pemesanan/table')->with('success', 'Order created and sapi updated successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            // Handle the error (log it, display error message, etc.)
            return back()->withErrors('Error creating order: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        //untuk modal
        $pesanan = Sapi::find($id);
        return response()->json($pesanan);
    }

    public function edit($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        return view('pemesanan.edit', compact('pemesanan'));
    }

    public function update(Request $request, $id)
    {
        $pesan = Pemesanan::findOrFail($id);
        $input = $request->all();
        $pesan->update($input);
        return redirect('pemesanan/table');
    }
    public function destroy($id)
    {
        $pesan = Pemesanan::findOrFail($id);
        $pesan->delete();
        return redirect('pemesanan/table');
    }

    public function showModal(Request $request)
    {
        $sapi = Sapi::findOrFail($request->id_sapi);
        return view('pemesanan.table', compact('pesansapi'));
    }

    public function import(Request $request)
    {

        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        // Skip the header row by slicing the array from the second element
        $fileContents = array_slice($fileContents, 1);

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);

            if (
                isset($data[0], $data[1], $data[2], $data[3]) &&
                is_numeric($data[2]) && is_numeric($data[3])
            ) {

                Sapi::create([
                    'tipe' => $data[0],
                    'status_kesehatan' => $data[1],
                    'harga_jual' => (int) $data[2], // Convert to integer
                    'harga_beli' => (int) $data[3], // Convert to integer
                ]);
            } else {
                // Log invalid data
                // Log::warning('Invalid data in CSV line:', $data);
            }
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }
}
