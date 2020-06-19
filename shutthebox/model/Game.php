<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 17-05-2016
 * Time: 14:16
 */
class Game extends \ActiveRecord\Model
{
    public $stategame = "";
    public $playerdices = array();
    public $pcdices = array();
    public $playerscore = 0;
    public $pcscore = 0;

    function StartGame(){
        $this->stategame = "start";
        $this->playerdices = array();
        $this->pcdices = array();
        $this->playerscore = 0;
        $this->pcdices = 0;
        return $this;
    }

    function CheckGame($game){
        if (strcmp($game->stategame, "start") || strcmp($game->stategame, "player")){
            $this->stategame = "player";
            $this->playerdices = $game->playerdices;
            $count = 0;
            foreach ($this->playerdices as $dice){
                $count += $dice;
            }
            $this->playerscore = 45 - $count;
            if ($count == 45){
                $this->stategame = "pc";
            }
            return $this;
        }elseif (strcmp($game->stategame, "pc")){
            $this->pcdices = $game->pcdices;
            $count = 0;
            foreach ($this->pcdices as $dice){
                $count += $dice;
            }
            $this->pcscore = 45 - $count;
            if ($count == 45){
                $this->stategame = "end";
            }
            return $this;
        }
        return $this;
    }
}
