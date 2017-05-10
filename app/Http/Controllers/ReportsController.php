<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiclename;
use App\Vehicle;
use App\Route;
use App\Currency;
use App\Payment;
use App\Schedule;
use App\Event;
use App\Booking;
use App\Organization;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel as Excel;

class ReportsController extends Controller
{
    //
    public function test(){
    	$pdf = PDF::loadView('pdf.test');
        return $pdf->download('test.pdf');
    }

    public function organization(Request $request){
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.organization',compact('organization'));
        return $pdf->download('organization.pdf');
      }

    public function vehiclenames(Request $request){
        if($request->type == 'pdf'){
        $vehiclenames = Vehiclename::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehiclenames',compact('vehiclenames','organization'));
        if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
        return $pdf->download('vehiclenames.pdf');
        }else if(Auth::user()->type == 'SGR'){
        return $pdf->download('trainnames.pdf');
        }else if(Auth::user()->type == 'Airline'){
        return $pdf->download('airplanenames.pdf');
        }
    }else{
        $data = Vehiclename::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

        $reportname = '';

        if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
          $reportname = 'Vehicle names Report';
        }else if (Auth::user()->type == 'SGR') {
           $reportname = 'Train names Report';
        }elseif (Auth::user()->type == 'Airline') {
           $reportname = 'Airplane names Report';
        }
    
  Excel::create($reportname, function($excel) use($data,$reportname,$organization) {

    
    $excel->sheet($reportname, function($sheet) use($data,$organization){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              'Vehicle names Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'Name'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->name
             ));
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }

    public function vehicles(Request $request){
        if($request->type == 'pdf'){
        $status = $request->status;
        if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
        if($request->status == 'all'){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('vehicles.pdf');
        }else if($request->status == 1){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',1)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('active vehicles.pdf');
        }else if($request->status == 0){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',0)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('inactive vehicles.pdf');
        }
        }else if(Auth::user()->type == 'SGR'){
        if($request->status == 'all'){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('trains.pdf');
        }else if($request->status == 1){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',1)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('active trains.pdf');
        }else if($request->status == 0){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',0)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('inactive trains.pdf');
        }
        }else if(Auth::user()->type == 'Airline'){
        if($request->status == 'all'){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('airplanes.pdf');
        }else if($request->status == 1){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',1)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('active airplanes.pdf');
        }else if($request->status == 0){
        $vehicles = Vehicle::where('organization_id',Auth::user()->organization_id)->where('active',0)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.vehicles',compact('vehicles','organization','status'));
        return $pdf->download('inactive airplanes.pdf');
        }
        }
        
        }else{
        $data = Vehicle::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

        $status = $request->status;

        $header = '';

              if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
              if($status == 'all'){
              $header = 'Vehicles Report';
              }else if($status == 1){
              $header = 'Active Vehicles Report';
              }else if($status == 0){
              $header = 'Inactive Vehicles Report';
              }
              }else if (Auth::user()->type == 'SGR') {
              if($status == 'all'){
              $header = 'Trains Report';
              }else if($status == 1){
              $header = 'Active Trains Report';
              }else if($status == 0){
              $header = 'Inactive Trains Report';
              }
              }elseif (Auth::user()->type == 'Airline') {
              if($status == 'all'){
              $header = 'Airplanes Report';
              }else if($status == 1){
              $header = 'Active Airplanes Report';
              }else if($status == 0){
              $header = 'Inactive Airplanes Report';
              }
              }
    
  Excel::create($header, function($excel) use($data,$organization,$header,$status) {

    
    $excel->sheet($header, function($sheet) use($data,$organization,$header,$status){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              if(Auth::user()->type == 'Travel'){
              if($status == 'all'){
              $sheet->mergeCells('A3:H3');
              }else{
              $sheet->mergeCells('A3:G3');
              }
              }else{
              if($status == 'all'){
              $sheet->mergeCells('A3:E3');
              }else{
              $sheet->mergeCells('A3:D3');
              } 
              }

              $sheet->row(3, array(
              $header
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $headeractive='';
              if($status == 'all'){
              $headeractive='Active';
              }else{
              $headeractive='';
              }

              if(Auth::user()->type == 'Travel'){
              $sheet->row(5, array(
              '#', 'Regno', 'Name', 'Capacity', 'Type', 'Has Conductor', 'Has Chair', $headeractive
              ));
              }else{
                $sheet->row(5, array(
              '#', 'Regno', 'Name', 'Capacity', $headeractive
              ));
              }

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;

            $hasconductor = '';
            $haschair = '';
            $active = '';
             
             for($i = 0; $i<count($data); $i++){
             if($data[$i]->has_conductor == 1){
               $hasconductor = 'Yes';
             }else{
               $hasconductor = 'No';
             }

             if($data[$i]->has_chair == 1){
               $haschair = 'Yes';
             }else{
               $haschair = 'No';
             }

             if($status == 'all'){
             if($data[$i]->active == 1){
               $active = 'Yes';
             }else{
               $active = 'No';
             }
             }else{
                $active = '';
             }

             if(Auth::user()->type == 'Travel'){
             $sheet->row($row, array(
             $i+1,$data[$i]->regno,$data[$i]->vehiclename->name,$data[$i]->capacity,$data[$i]->type,$hasconductor,$haschair,$active
             ));
             }else{
             $sheet->row($row, array(
             $i+1,$data[$i]->regno,$data[$i]->vehiclename->name,$data[$i]->capacity,$active
             ));
             }
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }

    public function currencies(Request $request){
        if($request->type == 'pdf'){
        $currencies = Currency::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.currencies',compact('currencies','organization'));
        return $pdf->download('currencies.pdf');
    }else{
        $data = Currency::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

    
  Excel::create('Currencies Report', function($excel) use($data,$organization) {

    
    $excel->sheet('Currencies Report', function($sheet) use($data,$organization){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:C3');
              $sheet->row(3, array(
              'Currencies Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'Shortname', 'Name'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->shortname,$data[$i]->name
             ));
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }

    public function destinations(Request $request){
        if($request->type == 'pdf'){
        $destinations = Route::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.destinations',compact('destinations','organization'));
        return $pdf->download('destinations.pdf');
    }else{
        $data = Route::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

    
  Excel::create('Destinations Report', function($excel) use($data,$organization) {

    
    $excel->sheet('Destinations Report', function($sheet) use($data,$organization){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:B3');
              $sheet->row(3, array(
              'Destinations Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'Name'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->name
             ));
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }

    public function paymentoptions(Request $request){
        if($request->type == 'pdf'){
        $payments = Payment::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.paymentoptions',compact('payments','organization'));
        return $pdf->download('paymentoptions.pdf');
        }else{
        $data = Payment::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

    
  Excel::create('Payment Options Report', function($excel) use($data,$organization) {

    
    $excel->sheet('Payment Options Report', function($sheet) use($data,$organization){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              if(Auth::user()->type == 'Taxi'){
              $sheet->mergeCells('A3:C3');
              }else{
              $sheet->mergeCells('A3:F3');
              }
              
              $sheet->row(3, array(
              'Payment Options Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $currency = '';

              if($organization->currency_shortname == null || $organization->currency_shortname == ''){
              $currency = 'KES';
              }else{
              $currency = $organization->currency_shortname;
              }

              $name = '';

              if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
              $name = 'Vehicle';
              }else if (Auth::user()->type == 'SGR') {
              $name = 'Train';
              }elseif (Auth::user()->type == 'Airline') {
              $name = 'Airplane';
              }

              if(Auth::user()->type == 'Taxi'){
              $sheet->row(5, array(
              '#', $name, 'Fare per kilometer ('.$currency.')'
              ));
              }else{
              $sheet->row(5, array(
              '#', $name, 'Origin', 'Destination', 'VIP Fare ('.$currency.')', 'Normal Fare ('.$currency.')'
              ));
              }

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             for($i = 0; $i<count($data); $i++){
             if(Auth::user()->type == 'Taxi'){
             $sheet->row($row, array(
             $i+1,Payment::getVehicle($data[$i]->vehicle_id),$data[$i]->economic
             ));
             }else{
             $sheet->row($row, array(
             $i+1,Payment::getVehicle($data[$i]->vehicle_id),Schedule::getDestination($payment->origin_id)->name,Schedule::getDestination($payment->destination_id)->name,$data[$i]->firstclass,$data[$i]->economic
             ));
             }
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }

    public function schedules(Request $request){
        if($request->type == 'pdf'){
        $schedules = Schedule::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.schedules',compact('schedules','organization'));
        return $pdf->download('schedules.pdf');
    }else{
        $data = Schedule::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);

    
  Excel::create('Schedules Report', function($excel) use($data,$organization) {

    
    $excel->sheet('Schedules Report', function($sheet) use($data,$organization){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:F3');
              $sheet->row(3, array(
              'Schedules Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $name = '';

              if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
              $name = 'Vehicle';
              }else if (Auth::user()->type == 'SGR') {
              $name = 'Train';
              }elseif (Auth::user()->type == 'Airline') {
              $name = 'Airplane';
              }

              $sheet->row(5, array(
              '#', $name, 'Origin', 'Destination', 'Arrival', 'Departure'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,Schedule::getVehicle($data[$i]->vehicle_id)->regno.' '.Schedule::getVehicle($data[$i]->vehicle_id)->vehiclename->name,Schedule::getDestination($data[$i]->origin_id)->name,Schedule::getDestination($data[$i]->destination_id)->name,$data[$i]->arrival,$data[$i]->departure
             ));
             $row++;
             }             
             
    });

  })->download('xls');
    }
    }


    public function events(Request $request){
        if($request->type == 'pdf'){
        $events = Event::where('organization_id',Auth::user()->organization_id)->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.events',compact('events','organization'));
        return $pdf->download('events.pdf');
    }else{
        $data = Event::where('organization_id',Auth::user()->organization_id)->get();

        $organization = Organization::find(Auth::user()->organization_id);
        

    
  Excel::create('Events Report', function($excel) use($data,$organization) {

    
    $excel->sheet('Events Report', function($sheet) use($data,$organization){


               $sheet->row(1, array(
               'Organization: ',$organization->name
               ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:H3');
              $sheet->row(3, array(
              'Events Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });
              
              $currency = '';

              if($organization->currency_shortname == null || $organization->currency_shortname == ''){
              $currency = 'KES';
              }else{
              $currency = $organization->currency_shortname;
              }

              $name = '';

              $sheet->row(5, array(
              '#', 'Name','Description','Contact','Address','VIP Entrance Fee ('.$currency.')','Normal Entrance Fee ('.$currency.')','Children Entrance Fee ('.$currency.')'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $viptotal = 0;
            $normaltotal = 0;
            $childrentotal = 0;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->name,$data[$i]->description,$data[$i]->contact,$data[$i]->address,$data[$i]->vip,$data[$i]->normal,$data[$i]->children
             ));
             $viptotal = $viptotal + $data[$i]->vip;
             $normaltotal = $normaltotal + $data[$i]->normal;
             $childrentotal = $childrentotal + $data[$i]->children;
             $row++;
             }  

             $sheet->row($row, array(
             '','','','','Total',$viptotal,$normaltotal,$childrentotal
             ));
             $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
                      
             
    });

  })->download('xls');
    }
    }

    public function bookings(Request $request){
        if($request->type == 'pdf'){
        $from = $request->from;
        $to = $request->to;
        $bookings = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.bookings',compact('bookings','organization','from','to'));
        return $pdf->download('bookings_'.$from.'_'.$to.'.pdf');
    }else{
        $from = $request->from;
        $to = $request->to;
        $data = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();

        $organization = Organization::find(Auth::user()->organization_id);
        

    
  Excel::create('Booking_Report_'.$from.'_'.$to, function($excel) use($data,$organization,$from,$to) {

    
    $excel->sheet('Booking Report', function($sheet) use($data,$organization,$from,$to){


               $sheet->row(1, array(
               'Organization: ',$organization->name
               ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(2, array(
               'Period From: ',$from
               ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
               'Period To: ',$to
               ));
              
              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A5:H5');
              $sheet->row(5, array(
              'Booking Report'
              ));

              $sheet->row(5, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });
              
              $currency = '';

              if($organization->currency_shortname == null || $organization->currency_shortname == ''){
              $currency = 'KES';
              }else{
              $currency = $organization->currency_shortname;
              }

              $name = '';

              if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
              $name = 'Vehicle';
              }else if (Auth::user()->type == 'SGR') {
              $name = 'Train';
              }elseif (Auth::user()->type == 'Airline') {
              $name = 'Airplane';
              }

              $sheet->row(7, array(
              '#', 'Ticket No.',$name,'Customer','Email','Contact','Date','Amount ('.$currency.')'
              ));

              $sheet->row(7, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 8;
            $total = 0;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->ticketno,Booking::getVehicle($data[$i]->vehicle_id)->regno.' '.Booking::getVehicle($data[$i]->vehicle_id)->vehiclename->name,$data[$i]->firstname.' '.$data[$i]->lastname,$data[$i]->email,$data[$i]->phone,$data[$i]->date,$data[$i]->amount
             ));
             $total = $total + $data[$i]->amount;
             $row++;
             }  

             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
             $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
                      
             
    });

  })->download('xls');
    }
    }

    public function customers(Request $request){
        if($request->type == 'pdf'){
        $from = $request->from;
        $to = $request->to;
        $bookings = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.customers',compact('bookings','organization','from','to'));
        return $pdf->download('customers_'.$from.'_'.$to.'.pdf');
    }else{
        $from = $request->from;
        $to = $request->to;
        $data = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();

        $organization = Organization::find(Auth::user()->organization_id);
        

    
  Excel::create('Customers_Report_'.$from.'_'.$to, function($excel) use($data,$organization,$from,$to) {

    
    $excel->sheet('Customers Report', function($sheet) use($data,$organization,$from,$to){


               $sheet->row(1, array(
               'Organization: ',$organization->name
               ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(2, array(
               'Period From: ',$from
               ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
               'Period To: ',$to
               ));
              
              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A5:G5');
              $sheet->row(5, array(
              'Customers Report'
              ));

              $sheet->row(5, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(7, array(
              '#','Firstname','Lastname','Email','Contact','Date Booked','Travel Date'
              ));

              $sheet->row(7, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 8;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->firstname,$data[$i]->lastname,$data[$i]->email,$data[$i]->phone,$data[$i]->date,$data[$i]->departure_date
             ));
             $row++;
             }        
             
    });

  })->download('xls');
    }
    }

    public function payments(Request $request){
        if($request->type == 'pdf'){
        $from = $request->from;
        $to = $request->to;
        $bookings = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = PDF::loadView('reports.payments',compact('bookings','organization','from','to'));
        return $pdf->download('payments_'.$from.'_'.$to.'.pdf');
    }else{
        $from = $request->from;
        $to = $request->to;
        $data = Booking::where('organization_id',Auth::user()->organization_id)->whereBetween('date',array($from, $to))->get();

        $organization = Organization::find(Auth::user()->organization_id);
        

    
  Excel::create('Payments_Report_'.$from.'_'.$to, function($excel) use($data,$organization,$from,$to) {

    
    $excel->sheet('Payments Report', function($sheet) use($data,$organization,$from,$to){


               $sheet->row(1, array(
               'Organization: ',$organization->name
               ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(2, array(
               'Period From: ',$from
               ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
               'Period To: ',$to
               ));
              
              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A5:F5');
              $sheet->row(5, array(
              'Payments Report'
              ));

              $sheet->row(5, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $currency = '';

              if($organization->currency_shortname == null || $organization->currency_shortname == ''){
              $currency = 'KES';
              }else{
              $currency = $organization->currency_shortname;
              }

              $name = '';

              if(Auth::user()->type == 'Travel' || Auth::user()->type == 'Taxi'){
              $name = 'Vehicle';
              }else if (Auth::user()->type == 'SGR') {
              $name = 'Train';
              }elseif (Auth::user()->type == 'Airline') {
              $name = 'Airplane';
              }

              $sheet->row(7, array(
              '#', 'Ticket No.',$name,'Customer','Date','Amount ('.$currency.')'
              ));

              $sheet->row(7, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 8;
            $total = 0;
             
             for($i = 0; $i<count($data); $i++){
             $sheet->row($row, array(
             $i+1,$data[$i]->ticketno,Booking::getVehicle($data[$i]->vehicle_id)->regno.' '.Booking::getVehicle($data[$i]->vehicle_id)->vehiclename->name,$data[$i]->firstname.' '.$data[$i]->lastname,$data[$i]->date,$data[$i]->amount
             ));
             $total = $total + $data[$i]->amount;
             $row++;
             }  

             $sheet->row($row, array(
             '','','','','Total',$total
             ));
             $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
                      
             
    });

  })->download('xls');
    }
    }

    public function excel(){
    	$data = array(
        array('data1', 'data2'),
        array('data3', 'data4')
        );

    Excel::create('Filename', function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {

        $sheet->fromArray($data);

    });

    })->download('xls');
    }
}