<?php


namespace feedFetcher\net;

// This class is added to make it possible to test if the feed is working, as to distinguish error cased by the rss feed being down in contrast to the rest of the relevant code

class feedService{


    private $feedURL;


    public function __construct($url)
    {
        $this->feedURL = $url;
    }

    public function getRSSstring(){

        $feedString = file_get_contents($this->feedURL);

        return $feedString;

    }


}












?>