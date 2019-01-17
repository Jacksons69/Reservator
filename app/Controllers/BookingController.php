<?php

class BookingController extends TwigLoader {

    public function addBooking () {

        $newBooking = new BookingModel();
        $name = $_POST['booking'];
        $id = $_POST['id'];
        $places = $_POST['places'];

        $newBooking->setName($name);
        $newBooking->setPlaces($places);
        $newBooking->addBooking($id);

        $datas = [
            'name' => $name,
        ];

        $returnData = json_encode($datas);
       
        echo $returnData;
    }

    public function showBooking() {

        $showBooking = new BookingModel();
        $id = $_POST['id'];

        $detailShow = $showBooking->showBooking($id);

        $nameList = [];
        $idList = [];

        foreach($detailShow as $name) {
            $nameList[] = $name->getName();
            $idList[] = $name->getId();
        }
        
        $datas = [
            'names' => $nameList,
            'id' => $idList,
        ];

        $returnData = json_encode($datas);

        echo $returnData;
    }

    public function deleteBooking () {

        $deleteBooking = new BookingModel();
        $booking = $_POST['id'];

        $deleteBooking->deleteBooking($booking);

        $datas = [
            'message' => 'La réservation a bien été supprimée',
        ];

        $message = json_encode($datas);
        echo $message;
    }
}