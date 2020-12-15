<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use DB;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newReserve = new Reservation;

        $newReserve->room_id = $request['room_id'];
        $newReserve->user_id = $request['user_id'];
        $newReserve->check_in = $request['check_in'];
        $newReserve->check_out = $request['check_out'];

        $newReserve->save();

        return $newReserve;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('reservations')->where('user_id', $id)->get();

    }

    public function roomReservations($id)
    {
        return DB::table('reservations')->where('room_id', $id)->get();
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserve = Reservation::find( $id );

        if( $reserve ){
            $reserve->delete();
            return;
        }

        return "Item not found";
    }
}
