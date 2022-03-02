<?php

abstract class webpage
{

    private $head;
    private $body;
    private $foot;
    private $pageHeader;
    private $nav;

    public function __construct($title, $heading)
    {
        $this->setHead($title);
        $this->setPageHeader($title);
        $this->setNav(["Home", "Documentation"]);
        $this->addMain();
        $this->setFoot();
    }

    protected function setHead($title)
    {
        $css = BASEPATH . "assets/style.css";
        $this->head = <<<eot
<!doctype html>
<html lang="en-gb">
<head>
    <title>$title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href=$css>
</head>
<body>
eot;
    }

    private function getHead()
    {
        return $this->head;
    }

    protected function setBody($text)
    {
        $this->body .= $text;
    }

    private function getBody()
    {
        return $this->body;
    }

    protected function setFoot()
    {
        $this->foot = <<<eot
</div>
<script>
        let coll = document.getElementsByClassName("collapsible");
        let i;
        
        for (i = 0; i < coll.length; i++) {
          coll[i].addEventListener("click", function() {
            this.classList.toggle("uncollapsed");
            let content = this.nextElementSibling;
            let name = this.innerText;
            if (content.style.display === "block") {
              this.innerText = name.replace("-", "+");
              content.style.display = "none";
            } else {
              this.innerText = name.replace("+", "-");
              content.style.display = "block";
            }
          });
        }
    </script>
</body>
</html>
eot;

    }

    private function getFoot()
    {
        return $this->foot;
    }

    protected function setPageHeader($heading)
    {
        $this->pageHeader = <<<eot
<div class="page-header">
  <h1>$heading</h1>
</div>
eot;
    }

    protected function setNav($options)
    {
        $menuOptions = "";
        foreach ($options as $option) {
            $active = ($this->getCurrentPage() === strtolower($option)) ? "active" : "";
            $menuOptions .= '<a class="' . $active . '" href="' . strtolower($option) . '">' . $option . '</a>';
        }

        $menu = <<<eot
<div id="menu-toggle">
	<input type="checkbox" />

	<span></span>
	<span></span>
	<span></span>

	<ul id="menu">
	    $menuOptions
	</ul>
</div>
<div class="sidenav">
    $menuOptions
</div>
eot;

        $this->nav = $menu;
    }

    private function getNav()
    {
        return $this->nav;
    }

    protected function addMain()
    {
        $this->setBody("<div class='main'>");
    }

    public function addCollapsableSection($title, $content, $uncollapsed=false)
    {
        if ($uncollapsed) {
            $section = <<<eot
<button type="button" class="uncollapsed-section">$title</button>
<div class="uncollapsed-section-content">
  $content
</div>
eot;
        } else {
            $section = <<<eot
<button type="button" class="collapsible">+ $title</button>
<div class="content">
  $content
</div>
eot;
        }
        $this->setBody($section);
    }

    public function addCollapsableSubSection($title, $content)
    {
        $subSection = "<button type='button' class='collapsible sub-collapsible'>+ $title</button><div class='content sub-collapsible-content'>";
        foreach ($content as $name => $data) {
            $subSection .= $this->addParagraph("<b>$name</b>" . ": " . $data);
        }
        $subSection .= "</div>";
        return $subSection;
    }

    public function addHeading2($text)
    {
        $this->setBody("<h2>$text</h2>");
    }

    public function addHeading4($text)
    {
        return "<h4>$text</h4>";
    }

    public function addHeading5($text)
    {
        return "<h5>$text</h5>";
    }

    public function addParagraph($text)
    {
        return "<p>$text</p>";
    }

    public function addLink($url, $text)
    {
        return "<a href=$url>$text</a>";
    }

    protected function addList($listItems) {
        $list = "<ul>";
        foreach ($listItems as $item) {
            $list .= "<li>$item</li>";
        }
        $list .= "</ul>";
        return $list;
    }

    public function addPageSeparator($number) {
        $separators = "";
        $i = 0;
        while ($i < $number) {
            $separators .= "<hr>";
            $i++;
        }
        return $separators;
    }

    protected function writeStudentDetails()
    {
        $name = $this->addParagraph("Name: Student 1");
        $id = $this->addParagraph("ID: w1xxxxxxxxxx");
        return $name . $id;
    }

    public function generateWebpage()
    {
        return $this->head . $this->pageHeader . $this->nav . $this->body . $this->foot;
    }

    private function getCurrentPage()
    {
        $urlFragments = explode("/", $_SERVER['REQUEST_URI']);
        $currentPage = end($urlFragments);
        return ($currentPage === "") ? "home" : $currentPage;
    }

}