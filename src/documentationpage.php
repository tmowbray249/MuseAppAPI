<?php

class DocumentationPage extends Webpage {

    public function __construct($title, $heading)
    {
        parent::__construct($title, $heading);
        $this->addCollapsableSection("Student Details", $this->writeStudentDetails());
        $this->addHeading2("Available Endpoints");
    }

    public function writeEndpoint($data) {
        $this->addCollapsableSection($data['name'], $this->buildEndpoint($data['endpointInfo']));
    }

    private function buildEndpoint($data) {
        $content = $this->writeEndpointURL($data['url']);
        $content .= $this->writeContentInformation($data['content']);
        $content .= $this->writeRequestMethods($data['request_methods']);
        $content .= $this->writeParameters($data['parameters']);
        $content .= $this->writeHTTPCodes($data['http_codes']);
        $content .= $this->writeExampleResponse($data['examples']);

        return $content;
    }

    private function writeEndpointURL($url) {
        $content = $this->addHeading4("Endpoint Url:") . $this->addLink($url, $url);
        $content .= $this->addPageSeparator(1);
        return $content;
    }

    private function writeRequestMethods($methods) {
        $content = $this->addHeading4("Request Methods:");
        $content .= $this->addList($methods);
        $content .= $this->addPageSeparator(1);
        return $content;
    }

    private function writeParameters($parameters) {
        $content = $this->addHeading4("Parameters:");
        if (count($parameters) === 1 && isset($parameters[0])) {
            $content .= $this->addheading5("This endpoint takes no parameters");
        } else {
            foreach ($parameters as $name => $info) {
                $content .= $this->addCollapsableSubSection($name, $info);
            }
        }
        $content .= $this->addPageSeparator(1);
        return $content;
    }

    private function writeContentInformation($information) {
        $content = $this->addHeading4("Description:");
        $content .= $this->addParagraph($information['description']);
        $content .= $this->addParagraph($information['json_description']);
        $content .= $this->addPageSeparator(1);
        return $content;
    }

    private function writeHTTPCodes($codes) {
        $content = $this->addHeading4("HTTP Response Codes:");
        $content .= $this->addList($codes);
        $content .= $this->addPageSeparator(1);
        return $content;
    }

    private function writeExampleResponse($exampleData) {
        $subSection = $this->addHeading4("Example Responses");

        foreach ($exampleData as $exampleName => $example) {
            $subSection .= "<button type='button' class='collapsible sub-collapsible'>+ $exampleName</button><div class='content sub-collapsible-content pretty-print-json'>";
            $subSection .= $this->addParagraph("<b>Request: </b>" . $example['url']);
            if (isset($example['request_body'])) {
                $subSection .= $this->addParagraph("<b>Request Body:</b>");
                $subSection .= "<pre>" . json_encode($example['request_body'], JSON_PRETTY_PRINT) . "</pre>";
            }
            $subSection .= $this->addParagraph("<b>Response: </b>");
            $subSection .= "<pre>" . json_encode($example['response'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "</pre>";
            $subSection .= $this->addParagraph("<b>Description: </b>");
            $subSection .= $this->addParagraph($example['description']);
            $subSection .= "</div>";
        }

        return $subSection;
    }


}