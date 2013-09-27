<?php

namespace MyCoinJar\Controller;

use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\ActionController; 
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class CoinJarRest {
    const APIKey = "REPLACE_WITH_YOUR_KEY";
    const APIRoot = "https://secure.sandbox.coinjar.io/api"; // sandbox endpoint
    //const APIRoot = "https://api.coinjar.io"; // production endpoint
    const Account = "/v1/account.json";
    const FairRate = "/v1/fair_rate/{currency}.json";
    const Transactions = "/v1/transactions.json";
    const Addresses = "/v1/bitcoin_addresses.json";
}

class MyCoinJarController extends AbstractActionController
{
    public function indexAction()
    {
        $client = new Client();
        $client->setAuth(CoinJarRest::APIKey,'');

        // Account
        $request = new Request();
        $request->setUri(CoinJarRest::APIRoot . CoinJarRest::Account);
        $client->setRequest($request);
        $result = $client->dispatch($request)->getBody();
        $account = Json::decode($result, Json::TYPE_OBJECT);

        // Fair Rates
        $fair_rates = array();
        $currencies = array('AUD','USD', 'NZD', 'EUR');

        foreach($currencies as $currency) {
            $request = new Request();
            $request->setUri(CoinJarRest::APIRoot . str_replace("{currency}", $currency, CoinJarRest::FairRate));
            $client->setRequest($request);
            $result = $client->dispatch($request)->getBody();
            $fair_rates[$currency] = Json::decode($result, Json::TYPE_OBJECT);
        }

        // Transactions
        $request = new Request();
        $request->setUri(CoinJarRest::APIRoot . CoinJarRest::Transactions);
        $client->setRequest($request);
        $result = $client->dispatch($request)->getBody();
        $transactions = Json::decode($result, Json::TYPE_OBJECT);

        // Addresses
        $request = new Request();
        $request->setUri(CoinJarRest::APIRoot . CoinJarRest::Addresses);
        $client->setRequest($request);
        $result = $client->dispatch($request)->getBody();
        $addresses = Json::decode($result, Json::TYPE_OBJECT);

        return new ViewModel(array(
            'account' => $account,
            'fair_rates' => $fair_rates,
            'transactions' => $transactions->transactions,
            'addresses' => $addresses->bitcoin_addresses,
        ));
    }
}