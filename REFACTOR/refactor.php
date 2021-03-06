<?php

class refactor1 {

  public function post_confirm(Request $request) {
    //validate input
    $this->validate($request, [
        'service_id'=>'required|numeric|',
        'driver_id'=>'required|numeric|',
    ]);

    //find service or return error codes
    $service=Servise::find($request->service_id);
    if ($service==NUll) {
      return Respose::json(['error'=>'3']);
    } elseif ($service->status_id=='6') {
      return Respose::json(['error'=>'1']);
    }


    if ($service->diver_id==NULL&&$service->status_id=='1') {
      //update driver
      $service=$this->update_driver($service, $request->driver_id);
      //notify if uuid is set
      if ($service->user->uuid!='') {
        $this->notify($service);
      }
      return Response::json(['error'=>'0']);
    }
  }

  private function update_driver(Service $service, $driver_id) {
    Driver::update($driver_id, ['available'=>'0']);
    $diverTmp=Driver::find($driver_id);
    $service->diver_id=$driver_id;
    $service->status_id=2;
    $service->car_id=$diverTmp;
    $service->save();
    return $service;
  }

  private function notify(Service $service) {
    $push=Push::make();
    $pushMessage='Tu servicio ha sido confirmado!';
    if ($service->user->type=='1') {
      $push->ios($service->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', ['serviceId'=>$service->id]);
    } else {
      $push->android2($service->user->uuid, $pushMessage, 1, 'default', 'Open', ['serviceId'=>$service->id]);
    }
  }

}
