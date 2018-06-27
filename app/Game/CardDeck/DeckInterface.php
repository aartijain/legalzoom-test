<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author A.Jain
 */
namespace App\Game\CardDeck;

interface DeckInterface {
    
    static function getSuits();
	static function getValues();
	function getCards();
	function addCard($suit, $card);
	function shuffle();

}
