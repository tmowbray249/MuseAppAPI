<?php

class APIEventsController extends Controller {

    protected function setGateway() {
        $this->gateway = new eventsgateway();
    }

    protected function processRequest() {

        if ($this->getRequest()->getRequestMethod() === "POST") {
            $action = $this->getRequest()->getParameter("action");

            if (!is_null($action)) {
                if ($action == "get-events") {
                    $this->getGateway()->getAllEvents();
                } elseif ($action == "get-event-details") {
                    $event_id = $this->getRequest()->getParameter('event_id');
                    if (!is_null($event_id)) {
                        $this->getGateway()->getEventDetails($event_id);
                    } else {
                        $this->getResponse()->setBadRequestResponse("Please provide and event id");
                    }
                } elseif ($action == "get-event-categories") {
                    $this->getGateway()->getEventCategories();
                } elseif ($action == "get-event-types") {
                    $this->getGateway()->getEventTypes();
                } elseif ($action == "new-event") {
                    $event_data = $this->prepareData($this->getEventData());
                    $this->getGateway()->addEvent($event_data);
                } elseif ($action == "save-event"){
                    //todo validation & check no db error
                    $event_data = $this->prepareData($this->getEventData());
                    //todo save image then save file name
                    if ($event_data['event_image'] !== "") {
                        $this->saveImage('assets/images/event_images/', $event_data['event_image_name'], $event_data['event_image']);
                    }
                    $this->getGateway()->saveEvent($event_data);
                    $this->getResponse()->setOkResponse("Event successfully saved.");
                } else if ($action == "delete-event") {
                    $event_id = $this->getRequest()->getParameter('event_id');
                    $this->getGateway()->deleteEvent($event_id);
                    $this->getResponse()->setOkResponse("Event successfully deleted.");
                }
            } else {
                $this->getResponse()->setBadRequestResponse("Please provide an action parameter");
            }
        }

        return $this->getGateway()->getResult();

    }

    private function getEventData() {
        return [
            'event_id' => $this->getRequest()->getParameter("event_id"),
            'event_name' => $this->getRequest()->getParameter("event_name"),
            'event_summary' => $this->getRequest()->getParameter("event_summary"),
            'event_category' => $this->getRequest()->getParameter("event_category"),
            'event_image_name' => $this->getRequest()->getParameter("event_image_name"),
            'event_image' => $this->getRequest()->getParameter("event_image"),
            'event_description' => $this->getRequest()->getParameter("event_description"),
            'event_date' => $this->getRequest()->getParameter("event_date"),
            'event_start' => $this->getRequest()->getParameter("event_start"),
            'event_end' => $this->getRequest()->getParameter("event_end"),
            'event_type' => $this->getRequest()->getParameter("event_type"),
            'event_street' => $this->getRequest()->getParameter("event_street"),
            'event_town' => $this->getRequest()->getParameter("event_town"),
            'event_postcode' => $this->getRequest()->getParameter("event_postcode"),
            'event_signup_url' => $this->getRequest()->getParameter("event_signup_url"),
            'show_on_site' => $this->getRequest()->getParameter("show_on_site")
        ];
    }

    private function prepareData($data) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $data[$key] = "";
            }
        }

        return $data;
    }


}