<?php

class Doc
{
    public $endpoint;
    public $responseType = "GET";
    public $description;
    public $parameters = [];
    public $response = [];
    public $example;
    private $domElement;

    function addParameter($name, $type, $description)
    {
        $parameter = new Parameter($name, $type, $description);
        array_push($this->parameters, $parameter);
    }

    function addResponse($name, $type, $description)
    {
        $parameter = new Parameter($name, $type, $description);
        array_push($this->response, $parameter);
    }

    function buildHTML()
    {
        // Root Node
        $rootNode = new Div(["entryWrapper"]);
        $this->domElement = $rootNode;
        $left = new Div(["entryColumn", "entryColumnLeft"]);
        $right = new Div(["entryColumn", "entryColumnRight"]);
        $rootNode->addChild($left);
        $rootNode->addChild($right);

        // Header
        $headerWrapper = new Div(["flexWrapper"]);
        $requestType = new Span(["requestType"]);
        $requestType->innerHTML = $this->responseType;
        $endpointNode = new CodeSpan();
        $endpointNode->innerHTML = $this->endpoint;
        $headerWrapper->addChild($requestType);
        $headerWrapper->addChild($endpointNode);
        $left->addChild($headerWrapper);

        // Description
        $desc = new Div(["endpointDescription"]);
        $desc->innerHTML = $this->description;
        $left->addChild($desc);

        // Parameters
        $parameterHeader = new Div(["sectionHeader"]);
        $parameterHeader->innerHTML = "Parameters";
        $paramWrapper = new Div(["gridContainer"]);
        if (count($this->parameters) > 0) {
            $left->addChild($parameterHeader);
            $left->addChild($paramWrapper);
            foreach ($this->parameters as $param) {
                $paramTitle = new CodeSpan(["gridTitle"]);
                $paramTitle->innerHTML = $param->name;
                $paramEntry = new Span(["gridEntry"]);
                $paramType = new CodeSpan();
                $paramType->innerHTML = $param->type;
                $paramDesc = new Span(["paramDescription"]);
                $paramDesc->innerHTML = $param->description;
                $paramEntry->addChildren($paramType, $paramDesc);
                $paramWrapper->addChildren($paramTitle, $paramEntry);
            }
        }

        // Response
        $responseHeader = new Div(["sectionHeader"]);
        $responseHeader->innerHTML = "Response";
        $responseWrapper = new Div(["gridContainer"]);
        if (count($this->response) > 0) {
            $left->addChild($responseHeader);
            $left->addChild($responseWrapper);
            foreach ($this->response as $param) {
                $responseTitle = new CodeSpan(["gridTitle"]);
                $responseTitle->innerHTML = $param->name;
                $responseEntry = new Span(["gridEntry"]);
                $responseType = new CodeSpan();
                $responseType->innerHTML = $param->type;
                $responseDesc = new Span(["paramDescription"]);
                $responseDesc->innerHTML = $param->description;
                $responseEntry->addChildren($responseType, $responseDesc);
                $responseWrapper->addChildren($responseTitle, $responseEntry);
            }
        }

        // Example Response
        $exampleHeader = new Div(["sectionHeader", "noMarginTop"]);
        $exampleHeader->innerHTML = "Example Response";
        $exampleBody = new Div();
        $exampleBody->innerHTML = "<pre>" . $this->example . "</pre>";
        $right->addChildren($exampleHeader, $exampleBody);
    }

    function output()
    {
        $this->buildHTML();
        $this->domElement->output();
    }

    static function fromJsonFile($fileName)
    {
        $text = file_get_contents(stream_resolve_include_path("api/_docs/" . $fileName . ".json"));
        $json = json_decode($text, true);
        $doc = new Doc();
        foreach ($json as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $paramName => $paramArray) {
                    $paramObj = new Parameter($paramName, $paramArray[0], $paramArray[1]);
                    array_push($doc->$key, $paramObj);
                }
            } else $doc->$key = $value;
            $doc->example = file_get_contents(stream_resolve_include_path("api/_examples/" . $fileName . ".json"));
        }
        return $doc;
    }
}

class Parameter
{
    public $name;
    public $type;
    public $description;

    function __construct($name, $type, $description)
    {
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
    }
}
