<?php

namespace App\Http\Controllers;

use App\Room;
use App\Branch;
use App\Food;
use App\Roomnumber;
use App\Organization;
use App\Hotelpricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelRoomsController extends Controller
{
    /*Hotel Rooms Landing Page*/
    public function index()
    {	
    	$organization=Organization::find(Auth::User()->organization_id);
    	$branches=Branch::where('organization_id','=',Auth::User()->organization_id)
    	->get();     	   
    	$rooms=Room::where('organization_id','=',Auth::User()->organization_id)
    	->get();     	    
        return view('hotels.rooms.index',compact('rooms','organization','branches'));
    }
    /*Storing room details in the database*/
    public function store(Request $request){
    	$room = new Room;
        if ( $request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/hotel/rooms'), $imageName);
            $room->image = $imageName;
        }else{
            $room->image = 'default_photo.png';
        }
        $room->branch_id = $request->branch;
        $room->type = $request->room_type;
        $room->adults = $request->adult_number;
        $room->children = $request->children_number;
        $room->room_count = $request->room_count;
        $room->price = str_replace(",", "", $request->price);
        $room->organization_id = Auth::user()->organization_id;
        $room->roomno= $request->room_number;
        $room->save();        

        return 1;
    }
    /*Displaying Room Details*/
    public function showrecord()
    {
        $display = "";
        $rooms = Room::where('organization_id',Auth::user()->organization_id)
        ->get();
        $i=1;
        foreach($rooms as $room){        
        $display .="
        <tr class='del$room->id'>
          <td> $i </td>
          <td>$room->roomno</td>
          <td>
          <img src=".url('/public/uploads/hotel/rooms/'.$room->image)." width='100' height='100' alt='No Room Image' />
          </td>
          <td>$room->type</td>
          <td>$room->room_count</td>";
          $display .="<td>
                  <div class='btn-group'>
                  	<button type='button' class='btn btn-info btn-sm dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                    	Action 
                    	<span class='caret'></span>
                  	</button>          
                  	<ul class='dropdown-menu' role='menu'>
                        <li>
                            <a data-toggle='modal' href='#modal-form' data-name='$room->roomno' data-id='$room->id' data-roomtype='$room->type' data-adultno='$room->adults' data-childrenno='$room->children' data-image='$room->image' data-branch='$room->branch_id' data-count='$room->room_count' data-price=".number_format($room->price,2)." enabled class='edit'>
                            View
                            </a>

	                    <li>
	                    	<a data-toggle='modal' href='#modal-form' data-name='$room->roomno' data-id='$room->id' data-roomtype='$room->type' data-adultno='$room->adults' data-childrenno='$room->children' data-image='$room->image' data-branch='$room->branch_id' data-count='$room->room_count' data-price=".number_format($room->price,2)." enabled class='edit'>
	                    	Update
	                    	</a>
	                    </li>
	                    <li>
		                    <a id='$room->id' class='delete'>
			                    <form id='delform'>".
			                    csrf_field()."
			                    Delete
			                    </form>
		                    </a>
	                    </li>                    
                  	</ul>
              </div>
            </td>
        </tr>
        ";
        $i++;         
        } 
        return $display;
        exit();
    }
    /*Updating the room details*/
    public function update(Request $request){
        $room = Room::find($request->id);
        if ( $request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/hotel/rooms'), $imageName);
            $room->image = $imageName;
        }else{
            $room->image = $room->image;
        }
        $room->branch_id = $request->branch;
        $room->type = $request->room_type;
        $room->adults = $request->adult_number;
        $room->children = $request->children_number;
        $room->room_count = $request->room_count;
        $room->price = str_replace(",", "", $request->price);
        $room->organization_id = Auth::user()->organization_id;
        $room->roomno= $request->room_number;
        $room->update();        
        return 1;
    }
    /*Deleting and unlinking the room details*/
    public function delete(Request $request)
    {      
        $room = Room::find($request->id);
       // unlink(url('/public/uploads/hotel/rooms/'.$room->image));
        $room->delete();       
    }

}
