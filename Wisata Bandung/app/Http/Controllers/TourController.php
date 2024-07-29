<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;


class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tours = Tour::all();
        return view('tours.index', [
            'tours' => $tours
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tours.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "<script>console.log('Debug Objects: " . $request->namatour . "' );</script>";
        $tour = new Tour();
        $tour->namatour = $request->namatour;
        $tour->deskripsi = $request->deskripsi;
        $tour->alamat = $request->alamat;
        $tour->longitude = $request->longitude;
        $tour->latitude = $request->latitude;
        $tour->jamoperasional = $request->jamoperasional;
        $tour->biayamasuk = $request->biayamasuk;
        $tour->kontak = $request->kontak;
        $tour->save();

        return redirect()->route('tours.index')->with('success', 'Data Tour Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tour = Tour::findOrFail($id);
        return view('tours.show', [
            'tour' => $tour
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if ($id === null) {
            // Handle case where no $id is provided, maybe show an error or redirect
            // For example, you might redirect to the index page.
            return redirect()->route('tours.index')->with('error', 'Invalid request.');
        }

        $tour = Tour::findOrFail($id);
        return view('edit', [
            'tour' => $tour
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $tour = Tour::findOrFail($id);
        $tour->namatour = $request->namatour;
        $tour->deskripsi = $request->deskripsi;
        $tour->alamat = $request->alamat;
        $tour->longitude = $request->longitude;
        $tour->latitude = $request->latitude;
        $tour->jamoperasional = $request->jamoperasional;
        $tour->biayamasuk = $request->biayamasuk;
        $tour->kontak = $request->kontak;
        $tour->save();

        return redirect()->route('tours.index')->with('success', 'Data tour berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Data tour berhasil dihapus.');
    }

    public function welcome()
    {
        $tours = Tour::all();
        return view('welcome', [
            'tours' => $tours
        ]);
    }
}
