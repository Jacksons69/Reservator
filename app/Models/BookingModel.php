<?php

class BookingModel {
    
    private $id;
    private $name;
    private $places;
    private $show_id;
 
    public function addBooking($id) {
        $sql = '
        INSERT INTO bookings (`name`, `places`, `show_id`) VALUES (:name, :places, :id)';

        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindParam(':places', $this->places, PDO::PARAM_INT);
        $pdoStatement->bindParam(':id', $id, PDO::PARAM_INT);

        $queryStatus = $pdoStatement->execute();

        if ($queryStatus) {
            $add = true;
            $show = new ShowModel();
            $show->updatePeople($id, $add, $this->places);
        }

        return $queryStatus;
    }

    public static function findBooking($id) {

        $sql = 'SELECT * FROM bookings WHERE id = :id';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $people = $pdoStatement->fetch();

        return $people;
    }

    public function showBooking($id) {

        $sql = '
            SELECT bookings.name, bookings.id FROM `bookings` INNER JOIN `spectacles` ON spectacles.id = bookings.show_id WHERE bookings.show_id = :id
        ';
        $pdo = Database::getPDO();

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();

        $bookings = $pdoStatement->fetchAll(PDO::FETCH_CLASS, get_class($this));

        return $bookings;
    }

    public function deleteBooking($id) {

        $people = BookingModel::findBooking($id);
        $peopleId = $people['show_id'];
        $peoplePlaces = $people['places'];

        $sql = '
            DELETE FROM `bookings` WHERE `id` = :id
        ';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':id', $id, PDO::PARAM_INT);

        $queryStatus = $pdoStatement->execute();

        if ($queryStatus) {
            $add = false;
            $show = new ShowModel();
            $show->updatePeople($peopleId, $add, $peoplePlaces);
        }


        return $queryStatus;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

     /**
     * Get the value of places
     */ 
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Set the value of places
     *
     * @return  self
     */ 
    public function setPlaces($places)
    {
        $this->places = $places;

        return $this;
    }

    /**
     * Get the value of show_id
     */ 
    public function getShowid()
    {
        return $this->show_id;
    }

    /**
     * Set the value of show_id
     *
     * @return  self
     */ 
    public function setShowid($show_id)
    {
        $this->show_id = $show_id;

        return $this;
    }

}