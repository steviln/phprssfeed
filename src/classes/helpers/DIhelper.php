<?php

namespace Helpers;


use Symfony\Component\DependencyInjection\ContainerBuilder;



class DIhelper{

    // I would have like to make this method reusable, but did not have time to find a way to do it right now
    // I moved it into an own class to make the controller class more reable. 

    const URL = "https://www.nrk.no/urix/toppsaker.rss";

    public static function getFeedFetcherClass($order,$field){

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('fetcher.feedURL', \Helpers\DIhelper::URL);
        // It is here you can change the sorting
        $containerBuilder->setParameter('fetcher.sortType', $order);
        $containerBuilder->setParameter('fetcher.sortField', $field);
        
        $containerBuilder->register('fetcher', 'feedFetcher\feedFetcher')->addArgument('%fetcher.feedURL%')->addArgument('%fetcher.sortType%')->addArgument('%fetcher.sortField%');

        $fetcher = $containerBuilder->get('fetcher');

        return $fetcher;

    }

    public static function getFeedServiceClass(){

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('service.feedURL',  \Helpers\DIhelper::URL);
        
        $containerBuilder->register('service', 'feedFetcher\net\feedService')->addArgument('%service.feedURL%');

        $service = $containerBuilder->get('service');

        return $service;



    }



}






















?>