<?php

class ShowController extends TwigLoader {

    public function addShow () {

        $newShow = new ShowModel();
        
        $showName = $_POST['show-name'];
        $showDate = $_POST['show-date'];

        if (empty($showName) || empty($showDate)) {

            $datas = [
                'message' => 'Merci d\'indiquer le nom et la date du spectacle'
            ];
            echo json_encode($datas);
            return false;
        }

        $formatedDate = str_replace('/', '-', $showDate);
  
        $newShow->setName($showName);
        $newShow->setDate($showDate);
        $newShow->addShow();

        $datas = [
            'name' => $showName,
            'date' => $showDate,
        ];

        $returnData = json_encode($datas);
       
        echo $returnData;
    }

    public function editShow () {

        $editShow = new ShowModel();

        if(!empty($_POST['edit-show-name'])) {
            $showId = $_POST['edit-show-name-id'];
            $showName = $_POST['edit-show-name'];
            $editShow->setName($showName);
       
        } else if (!empty($_POST['edit-show-date'])) {
            $showId = $_POST['edit-show-date-id'];
            $showDate = str_replace('/', '-', $_POST['edit-show-date']);
            $editShow->setDate($showDate);
       
        } else {
            $datas = [
                'message' => 'Merci de choisir un champ à modifier'
            ];
            echo json_encode($datas);
            return false;
        }

        $editShow->setId($showId);
        $editShow->editShow();

        $datas = [
            'message' => 'Le spectacle a bien été modifié'
        ];

        $message = json_encode($datas);
        echo $message;
    }

    public function deleteShow () {

        $deleteShow = new ShowModel();
        $show = $_POST['id'];

        $deleteShow->setId($show);
        $deleteShow->deleteShow();

        $datas = [
            'message' => 'Le spectacle a bien été supprimé',
        ];

        $message = json_encode($datas);
        echo $message;
    }

    public function page404() {
        echo 'erreur';
    }
}
