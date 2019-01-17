<?php

class ShowModel {
    
    private $id;
    private $name;
    private $date;
    private $people;

    public function findAll() {
        $sql = '
        SELECT
            `id`,
            `name`,
            `date`,
            `people`
        FROM `spectacles` ORDER BY `date`
        ';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->query($sql);

        $shows = $pdoStatement->fetchAll(PDO::FETCH_CLASS,'ShowModel');
        return $shows;
    }

    public function addShow() {
        $sql = '
            INSERT INTO `spectacles` (name, date, people) VALUES (:name, :date, 0)
        ';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindParam(':date', $this->date, PDO::PARAM_STR);

        $queryStatus = $pdoStatement->execute();

        return $queryStatus;
    }

    public function editShow() {

        if(!empty($this->getName())) {
            $sql = '
                UPDATE spectacles SET `name` = :name WHERE `id` = :id
            ';

            $pdo = Database::getPDO();
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindParam(':name', $this->name, PDO::PARAM_STR);
            $pdoStatement->bindParam(':id', $this->id, PDO::PARAM_INT);
        }

        if(!empty($this->getDate())) {
            $sql = '
                UPDATE spectacles SET `date` = :date WHERE `id` = :id
            ';

            $pdo = Database::getPDO();
            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindParam(':date', $this->date, PDO::PARAM_STR);
            $pdoStatement->bindParam(':id', $this->id, PDO::PARAM_INT);
        }


        $queryStatus = $pdoStatement->execute();

        return $queryStatus;
    }

    public function deleteShow() {
        $sql = '
            DELETE FROM `spectacles` WHERE `id` = :id
        ';

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':id', $this->id, PDO::PARAM_INT);

        $queryStatus = $pdoStatement->execute();

        return $queryStatus;
    }

    public function updatePeople($id, $update, $places) {
        if($update == true) {
            $sql = 'UPDATE spectacles set `people` = people + :places WHERE `id` = :id';
        } else {
            $sql = 'UPDATE spectacles set `people` = `people` - :places WHERE `id` = :id';
        }

        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindParam(':places', $places, PDO::PARAM_INT);
        $pdoStatement->bindParam(':id', $id, PDO::PARAM_INT);

        $queryStatus = $pdoStatement->execute();

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
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of people
     */ 
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set the value of people
     *
     * @return  self
     */ 
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }
}