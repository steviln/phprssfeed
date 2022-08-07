<?php

namespace feedFetcher;


class feedFetcher{

    private $feedURL, $sortType, $sortField;


    public function __construct($url,$descasc,$field)
    {
        $this->feedURL = $url;
        $this->sortType = $descasc;
        $this->sortField = $field;
    }

    public function fetchRSScontent() : array{

        $responseObject = array('errorcode' => 0, 'feed' => null);

        $feedService = \helpers\DIhelper::getFeedServiceClass();
        $feed = $feedService->getRSSstring();
        if(!$feed){
            $responseObject["errorcode"] = 1;
        }else{
             // this is a dirty fix, but I do not take the time now to rewrite this by finding an XML reader that can handle colons in the tag names. 
            $feed = preg_replace('~(</?|\s)([a-z0-9_]+):~is', '$1$2_', $feed);
            $rss = simplexml_load_string($feed);    
            $items = $this->organizeArray($rss);    
            $items = $this->sortFeedItems($items);
            $responseObject["feed"] = $items;
        }

        return $responseObject;

    }

    private function organizeArray($rss) : array{

        $items = array();

        foreach($rss->channel->item as $row){
            $item = array();
            foreach($row as $key => $value){
                // this will only handle one leve of attributes or subnodes, but that seem to generally be sufficient for rss feeds. 
                if(count($value->attributes()) > 0){
                    $attrib = array();
                    foreach($value->attributes() as $a => $b) {
                        $attrib[$a] = $b->__toString();
                    }
                    $item[$key] = $attrib;
                }else{
                    $item[$key] = $value->__toString();
                }
            }
            array_push($items,$item);
        }

        return $items;

    }

    // I see that this function may have been set up to be testable, but I find it a bit troublesome to decouple this methond from the actual rss data at this point. 
    // TO do it I would have need more time to work with PHPUnit so I am satisfied with this so far. 

    private function sortFeedItems($content) : array{

        usort($content, function ($a, $b) {
            if(!array_key_exists($this->sortField,$a) || !array_key_exists($this->sortField,$b)){
                return 0;
            }else if($this->sortType == "asc"){
                return strcmp($a[$this->sortField], $b[$this->sortField]);
            }else{
                return strcmp($b[$this->sortField], $a[$this->sortField]);
            }       
        });

        return $content;

    }




}













?>