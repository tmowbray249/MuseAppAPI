<?php

class EventsGateway extends Gateway {

//    private $sql = "SELECT author.author_id, author.first_name, author.middle_name, author.last_name FROM author ";
//    private $sqlOrderBy = " ORDER BY author.first_name, author.last_name";

    public function __construct() {
        $this->setDatabase(DATABASE);
    }

    public function getAllEvents($table_view=true) {
        if ($table_view) {
            $sql = "SELECT event_id, event_name, event_type_name, event_date, event_start, event_end 
                    FROM events";
        } else {
            $sql = "SELECT * FROM events";
        }
        $sql .= " INNER JOIN event_types ON (events.event_type = event_types.event_type_id)";
        $result = $this->getDatabase()->executeSQL($sql);
        $this->setResult($result);
    }

    public function getEventDetails($id) {
        $sql = "SELECT * FROM events WHERE event_id = ?";
        $param = [$id];
        $result = $this->getDatabase()->executeSQL($sql, $param);
        $this->setResult($result);
    }

    public function getEventCategories() {
        $sql = "SELECT * FROM event_categories";
        $result = $this->getDatabase()->executeSQL($sql);
        $this->setResult($result);
    }

    public function getEventTypes() {
        $sql = "SELECT * FROM event_types";
        $result = $this->getDatabase()->executeSQL($sql);
        $this->setResult($result);
    }

    public function addEvent($data) {
        $sql = "INSERT INTO events (
                    event_name,
                    event_summary,
                    event_category,
                    event_image,
                    event_description,
                    event_date,
                    event_start,
                    event_end,
                    event_type,
                    event_street,
                    event_town,
                    event_postcode,
                    event_signup_url,
                    show_on_site 
                )
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $params = [
            $data['event_name'],
            $data['event_summary'],
            $data['event_category'],
            $data['event_image'],
            $data['event_description'],
            $data['event_date'],
            $data['event_start'],
            $data['event_end'],
            $data['event_type'],
            $data['event_street'],
            $data['event_town'],
            $data['event_postcode'],
            $data['event_signup_url'],
            $data['show_on_site'],
        ];

        $new_id = $this->getDatabase()->executeSQL($sql, $params, true);
        $this->setResult(['event_id' => $new_id]);
    }

    public function saveEvent($data) {
        $sql = "UPDATE events
                SET
                    event_name=?,
                    event_summary=?,
                    event_category=?,
                    event_image=?,
                    event_description=?,
                    event_date=?,
                    event_start=?,
                    event_end=?,
                    event_type=?,
                    event_street=?,
                    event_town=?,
                    event_postcode=?,
                    event_signup_url=?,
                    show_on_site=?  
                WHERE event_id=?";
        $params = [
            $data['event_name'],
            $data['event_summary'],
            $data['event_category'],
            $data['event_image'],
            $data['event_description'],
            $data['event_date'],
            $data['event_start'],
            $data['event_end'],
            $data['event_type'],
            $data['event_street'],
            $data['event_town'],
            $data['event_postcode'],
            $data['event_signup_url'],
            $data['show_on_site'],
            $data['event_id']
        ];
        $this->getDatabase()->executeSQL($sql, $params);
    }

    public function deleteEvent($id) {
        $sql = "DELETE FROM events WHERE event_id=?";
        $param = [$id];
        $this->getDatabase()->executeSQL($sql, $param);
    }

}